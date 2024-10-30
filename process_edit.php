<?php
session_start();
include('db_connect.php');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Mettez à jour la publication dans la base de données
    $query = "UPDATE atualites SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $title, $content, $id);
    if ($stmt->execute()) {
        // Redirigez vers le tableau de bord ou la page d'actualités après la modification réussie
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la publication.";
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
