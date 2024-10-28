<?php
session_start();

// Simuler les identifiants corrects
$correct_username = 'admin';
$correct_password = 'password123';

// Récupérer les données POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des identifiants
    if ($username === $correct_username && $password === $correct_password) {
        // Enregistrer dans la session que l'administrateur est connecté
        $_SESSION['admin_logged_in'] = true;

        // Redirection vers le tableau de bord
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Afficher un message d'erreur
        echo "Identifiants incorrects.";
        echo "<br><a href='login.php'>Réessayer</a>";
    }
} else {
    // Si le fichier est accédé directement, rediriger vers la page de login
    header("Location: login.php");
    exit();
}
