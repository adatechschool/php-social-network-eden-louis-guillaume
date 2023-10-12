<?php
session_start();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- bibliothèque d'icones -->
    <script src="https://kit.fontawesome.com/7a1b45f3d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
        <aside>
            <article>
                <h1>Actualités</h1>
                <p class="large">Retrouvez sur cette page tous les derniers messages postés.</p>
            </article>
        </aside>
        <main>


            <?php include 'connexion_SQL.php';


            /*
              // C'est ici que le travail PHP commence
              // Votre mission si vous l'acceptez est de chercher dans la base
              // de données la liste des 5 derniers messsages (posts) et
              // de l'afficher
              // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
              // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
             */

            // Etape 1: Ouvrir une connexion avec la base de donnée.
            
            /* $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
             //verification
             if ($mysqli->connect_errno)
             {
                 echo "<article>";
                 echo("Échec de la connexion : " . $mysqli->connect_error);
                 echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
                 echo "</article>";
                 exit();
             } */

            // Etape 2: Poser une question à la base de donnée et récupérer ses informations
            // cette requete vous est donnée, elle est complexe mais correcte, 
            // si vous ne la comprenez pas c'est normal, passez, on y reviendra
            $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    posts.id as post_id,
                    users.alias as author_name, users.id as author_id,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    LIMIT 10
                    ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            // Vérification
            if (!$lesInformations) {
                echo "<article>";
                echo ("Échec de la requete : " . $mysqli->error);
                echo ("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>");
                exit();
            }

            while ($post = $lesInformations->fetch_assoc()) {
                include "post.php";
            }
            ?>


        </main>
    </div>
</body>

</html>