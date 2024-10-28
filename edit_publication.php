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

// Récupérer les détails de l'actualité à modifier
$sql = "SELECT * FROM actualites WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Aucune actualité trouvée avec cet ID.");
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Mise à jour des données dans la base
    if ($image) {
        $sql = "UPDATE actualites SET titre='$titre', contenu='$contenu', image='$image' WHERE id=$id";
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $sql = "UPDATE actualites SET titre='$titre', contenu='$contenu' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "L'actualité a été mise à jour avec succès.";
        header("Location: actualite.php"); // Rediriger vers la page des actualités
        exit();
    } else {
        echo "Erreur: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'actualité</title>
</head>
<body>

<h2>Modifier l'actualité</h2>
<form action="" method="POST" enctype="multipart/form-data">
    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre" value="<?php echo $row['titre']; ?>" required>

    <label for="contenu">Contenu :</label>
    <textarea id="contenu" name="contenu" required><?php echo $row['contenu']; ?></textarea>

    <label for="image">Changer l'image (optionnel) :</label>
    <input type="file" id="image" name="image" accept="image/*">

    <button type="submit">Mettre à jour</button>
</form>

</body>
</html>

<?php
// Fermeture de la connexion
$conn->close();
?>

