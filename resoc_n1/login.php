<?php
session_start();
$enCoursDeTraitement = isset($_POST['email']);
if ($enCoursDeTraitement) {
    $emailAVerifier = $_POST['email'];
    $passwdAVerifier = $_POST['motpasse'];
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
    $passwdAVerifier = md5($passwdAVerifier);
    $lInstructionSql = "SELECT * "
        . "FROM users "
        . "WHERE "
        . "email LIKE '" . $emailAVerifier . "'"
    ;
    $res = $mysqli->query($lInstructionSql);
    $user = $res->fetch_assoc();
    if (!$user or $user["password"] != $passwdAVerifier) {
        echo "La connexion a échouée. ";

    } else {
        $_SESSION['connected_id'] = $user['id'];
        $_SESSION['connected_alias'] = $user['alias'];
        header('Location: wall.php?user_id=' . $_SESSION['connected_id']);
        exit;
    }
}
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Connexion</title>
    <meta name="author" content="Julien Falconnet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- bibliothèque d'icones -->
    <script src="https://kit.fontawesome.com/7a1b45f3d5.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="wrapper" class="vertical">
        <aside>
            <article class="welcome-section">
                <h2>Bienvenue !</h2>
                <p>Renseignez vos identifiants pour accèder à votre compte.</p>
            </article>
        </aside>
        <main>
            <article>
                <h2>Connexion</h2>

                <form action="login.php" method="post">
                    <label for='email'>E-Mail</label>
                    <input type='email' class="text-area" name='email'>
                    <label for='motpasse'>Mot de passe</label>
                    <input type='password' name='motpasse' class="text-area">
                    <input type='submit' class="button-like">
                </form>
                <p>
                    Pas de compte?
                    <a href='registration.php'>Inscrivez-vous.</a>
                </p>
            </article>
        </main>
    </div>
</body>

</html>