<?php
session_start();
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>">
    </head>
    <body>
        <header>
        <?php include('header.php'); ?>
        </header>
        <div id="wrapper">
            <?php
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            $userId =intval($_GET['user_id']);
            
            ?>
            <?php
            /**
             * Etape 2: se connecter à la base de donnée
             */
            include 'connexion_SQL.php';
            //$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */                
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                //echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                <section>
    <h3>Présentation</h3>
    <p>Sur cette page vous trouverez tous les messages de l'utilisatrice : <?php echo $user['alias'] ?>
        (n° <?php echo $userId ?>)
    </p>
    <?php if (isset($_SESSION['connected_id'])) {
        // Vérifiez si l'utilisateur est sur son propre mur
        if ($_SESSION['connected_id'] == $userId) {
            // Utilisateur sur son propre mur, affichez le bouton "Nouveau post"
            echo "<a href='newpost.php'><button id='newpost'>Nouveau post !</button></a>";
        } else {
            // Vérifiez si l'utilisateur est déjà abonné à la personne
            $isFollowingQuery = $mysqli->prepare('SELECT * FROM followers WHERE followed_user_id = ? AND following_user_id = ?');
            $isFollowingQuery->bind_param('ii', $userId, $_SESSION['connected_id']);
            $isFollowingQuery->execute();
            $result = $isFollowingQuery->get_result();

            if ($result->num_rows > 0) {
                // L'utilisateur est abonné, affichez le bouton "Se désabonner"
                echo "<a href='follow.php?followedid=$userId'><button id='newpost'>Se désabonner</button></a>";
            } else {
                // L'utilisateur n'est pas abonné, affichez le bouton "S'abonner"
                echo "<a href='follow.php?followedid=$userId'><button id='newpost'>S'abonner</button></a>";
            }
        }
    } ?>
          <p>
          <?php 
          
        // Vérifiez si l'utilisateur est sur son propre mur
        if ($_SESSION['connected_id'] == $userId) {
            // Utilisateur sur son propre mur, affichez le bouton "Nouveau post"
            echo "<a href='logout.php'><button>Deconnexion</button></a>";
        }
    
   
            ?>
            </p>
</section>



            </aside>
            <main>
                <?php
                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, posts.id as post_id, users.id as author_id, 
                    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE posts.user_id='$userId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 */
                while ($post = $lesInformations->fetch_assoc())
                {

                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                   
                <?php include "post.php"; } ?>


            </main>
        </div>
    </body>
</html>
