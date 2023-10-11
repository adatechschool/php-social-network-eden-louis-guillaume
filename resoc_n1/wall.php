<?php
session_start();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- bibliothèque d'icones -->
    <script src="https://kit.fontawesome.com/7a1b45f3d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php $userId = intval($_GET['user_id']);
    include('header.php');
    include 'connexion_SQL.php'; ?>
    <div id="wrapper">

        <aside>
            <?php
            include 'profil.php';
            if (isset($_SESSION['connected_id'])) {
                if ($_SESSION['connected_id'] == $userId) {
                    include 'newpost.php';
                }
            } ?>
        </aside>
        <main>
            <?php
            $laQuestionEnSql = "
                    SELECT posts.content, posts.created, users.alias as author_name, posts.user_id as author_id,
                    COUNT(likes.id) as like_number, likes.post_id, GROUP_CONCAT(DISTINCT tags.label) AS taglist, GROUP_CONCAT(DISTINCT tags.id) AS idlist 
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
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }
            while ($post = $lesInformations->fetch_assoc()) {
                include "post.php";
            } ?>
        </main>
    </div>
</body>

</html>