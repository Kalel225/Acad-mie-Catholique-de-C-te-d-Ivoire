<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    die("Accès refusé. Vous devez être connecté en tant qu'administrateur.");
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mon_project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

$id = $_GET['id'];

// Suppression de l'actualité
$sql = "DELETE FROM actualites WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "L'actualité a été supprimée avec succès.";
    header("Location: actualite.php"); // Rediriger vers la page des actualités
    exit();
} else {
    echo "Erreur: " . $conn->error;
}

// Suppression de l'image
if (file_exists($image_path)) {
    if (unlink($image_path)) {
        echo "L'image a été supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'image.";
    }
} else {
    echo "L'image n'existe pas dans le dossier.";
}

// Fermeture de la connexion
$conn->close();
?>
