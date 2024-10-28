<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mon_project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Suppression de l'actualité
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Récupérer le chemin de l'image
    $sql = "SELECT image FROM actualites WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        // Supprimer l'actualité de la base de données
        $sql = "DELETE FROM actualites WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            // Supprimer le fichier image
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            echo "L'actualité a été supprimée avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'actualité : " . $conn->error;
        }
    } else {
        echo "Aucune actualité trouvée avec cet ID.";
    }
}

$conn->close();

header("Location: admin_dashboard.php");
exit();
?>
