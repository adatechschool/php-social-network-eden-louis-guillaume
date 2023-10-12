<?php
session_start();
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Paramètres</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- bibliothèque d'icones -->
    <script src="https://kit.fontawesome.com/7a1b45f3d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    $userId = intval($_GET['user_id']);
    include 'connexion_SQL.php';
    $laQuestionEnSql = "
                SELECT users.*, 
                count(DISTINCT posts.id) as totalpost, 
                count(DISTINCT given.post_id) as totalgiven, 
                count(DISTINCT recieved.user_id) as totalrecieved 
                FROM users 
                LEFT JOIN posts ON posts.user_id=users.id 
                LEFT JOIN likes as given ON given.user_id=users.id 
                LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                WHERE users.id = '$userId' 
                GROUP BY users.id
                ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    if (!$lesInformations) {
        echo ("Échec de la requete : " . $mysqli->error);
    }
    $user = $lesInformations->fetch_assoc();
    include('header.php'); ?>
    <div id="wrapper" class='profile'>
        <aside>
            <article>
                <h1>Paramètres</h1>
                <p>Bonjour,
                    <b><em>
                            <?= $user['alias'] ?>
                        </em></b> ! Sur cette page, vous pouvez retrouver toutes vos informations et statistiques.
                </p>
            </article>
        </aside>
        <main>
            <article class='parameters'>
                <h2>Mon profil</h2>
                <div class="horizontal">
                    <img class="profile-pic large" src="./oldnerd.jpeg">
                    <dl>
                        <dt>Pseudo :</dt>
                        <dd>
                            <?php echo $user['alias'] ?>
                        </dd>
                        <dt>Email :</dt>
                        <dd>
                            <?php echo $user['email'] ?>
                        </dd>
                        <dt>Messages :</dt>
                        <dd>
                            <?php echo $user['totalpost'] ?>
                        </dd>
                        <dt>Nombre de 🤮 donnés :</dt>
                        <dd>
                            <?php echo $user['totalgiven'] ?>
                        </dd>
                        <dt>Nombre de 🤮 reçus :</dt>
                        <dd>
                            <?php echo $user['totalrecieved'] ?>
                        </dd>
                    </dl>
                </div>
            </article>
        </main>
    </div>
</body>

</html>