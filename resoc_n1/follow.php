<?php
session_start();
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

if (isset($_GET['followedid'])) {
    // Obtenez la valeur de 'followedid' depuis $_GET
    $getfollowedid = intval($_GET['followedid']);
    $userId = $_SESSION['connected_id'];

    // Vérifiez si l'utilisateur suit déjà la personne
    $checkFollowQuery = "SELECT * FROM followers WHERE followed_user_id = $getfollowedid AND following_user_id = $userId";
    $result = $mysqli->query($checkFollowQuery);

    if ($result->num_rows == 0) {
        // L'utilisateur ne suit pas encore cette personne, ajoutez le suivi
        $addFollowQuery = "INSERT INTO followers (followed_user_id, following_user_id) VALUES ($getfollowedid, $userId)";
        $mysqli->query($addFollowQuery);
    } else {
        // L'utilisateur suit déjà cette personne, supprimez le suivi
        $removeFollowQuery = "DELETE FROM followers WHERE followed_user_id = $getfollowedid AND following_user_id = $userId";
        $mysqli->query($removeFollowQuery);
    }

    // Redirigez l'utilisateur vers la page précédente
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    echo "L'ID de la personne à suivre n'est pas défini dans la requête GET.";
    // Gérez cette situation d'erreur comme vous le souhaitez
}
?>





