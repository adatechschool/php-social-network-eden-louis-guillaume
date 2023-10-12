<?php
session_start();
$userId = intval($_GET['user_id']);
include 'connexion_SQL.php';
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mes abonnés</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- bibliothèque d'icones -->
    <script src="https://kit.fontawesome.com/7a1b45f3d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'header.php';
    ?>
    <div id="wrapper">
        <aside>
            <article>
                <h1>Abonnements</h1>
                <p>Voici la liste de toutes les personnes qui vous suivent.
                </p>
            </article>
        </aside>
        <main class='contacts'>
            <?php
            $laQuestionEnSql = "
            SELECT users.*
            FROM followers
            LEFT JOIN users ON users.id=followers.following_user_id
            WHERE followers.followed_user_id='$userId'
            GROUP BY users.id
            ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            while ($subscription = $lesInformations->fetch_assoc()) {
                include 'subbed.php';
            }
            ?>
        </main>
    </div>
</body>

</html>