<?php
session_start();

// Détruire la session pour déconnecter l'utilisateur
session_destroy();

// Rediriger l'utilisateur vers la page de connexion (login)
header('Location: login.php');
?>
