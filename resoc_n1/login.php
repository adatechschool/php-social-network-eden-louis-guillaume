<?php
session_start();
/**
 * TRAITEMENT DU FORMULAIRE
 */
// Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
// si on recoit un champs email rempli il y a une chance que ce soit un traitement
$enCoursDeTraitement = isset($_POST['email']);
// print_r($_POST);
if ($enCoursDeTraitement) {
    // on ne fait ce qui suit que si un formulaire a été soumis.
    // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
    // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
    // et complétez le code ci dessous en remplaçant les ???
    $emailAVerifier = $_POST['email'];
    $passwdAVerifier = $_POST['motpasse'];


    //Etape 3 : Ouvrir une connexion avec la base de donnée.
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
    //Etape 4 : Petite sécurité
    // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
    // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
    $passwdAVerifier = md5($passwdAVerifier);
    // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
    //Etape 5 : construction de la requete
    $lInstructionSql = "SELECT * "
        . "FROM users "
        . "WHERE "
        . "email LIKE '" . $emailAVerifier . "'"
    ;
    // Etape 6: Vérification de l'utilisateur
    $res = $mysqli->query($lInstructionSql);
    $user = $res->fetch_assoc();
    if (!$user or $user["password"] != $passwdAVerifier) {
        echo "La connexion a échouée. ";

    } else {
        // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
        // documentation: https://www.php.net/manual/fr/session.examples.basic.php
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