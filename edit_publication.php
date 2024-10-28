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
    <title>Edit Actu - ACACI</title>
    <link rel="icon" href="assets/images/newpng.png" type="image/png" />
</head>
<body>

<div class="modal-content">
    <h2>Modifier l'actualité</h2>
    <form action=
    <form action="POST" enctype="multipart/form-data" id="publicationForm">
        
        <!-- Champ Titre -->
        <div 
        
        <!-- Champ Titre --!>
<div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($row['titre']); ?>" required />
        </div>

        <!-- Champ Catégorie -->
        <div class="form-group">
            <label for="category">Catégorie :</label>
            <select id="category" name="category" required>
                <option value="actualite" <?php echo ($row['category'] === 'actualite') ? 'selected' : ''; ?>>Actualité</option>
                <option value="evenement" <?php echo ($row['category'] === 'evenement') ? 'selected' : ''; ?>>Événement</option>
                <option value="article" <?php echo ($row['category'] === 'article') ? 'selected' : ''; ?>>Article</option>
            </select>
        </div>

        <!-- Champ Contenu -->
        <div class="form-group">
            <label for="contenu">Contenu :</label>
            <div id="editor">
                <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($row['contenu']); ?></textarea>
            </div>
        </div>

        <!-- Champ Image -->
        <div class="form-group">
            <label for="image">Changer l'image (optionnel) :</label>
            <input type="file" id="imageUpload" name="image" accept="image/*" />
            <?php if (!empty($row['image'])): ?>
                <img id="imagePreview" src="<?php echo htmlspecialchars($row['image']); ?>" alt="Aperçu de l'image" class="image-preview" />
            <?php endif; ?>
        </div>

        <!-- Champ Tags (optionnel) -->
        <div class="form-group">
            <label for="tagInput">Tags :</label>
            <div style="display: flex">
                <input type="text" id="tagInput" name="tags" placeholder="Ajouter un tag" />
                <button type="button" id="addTagBtn" class="btn">Ajouter</button>
            </div>
            <div id="tagContainer" class="tag-container"></div>
        </div>

        <!-- Bouton de mise à jour -->
        <button type="submit" class="btn">Mettre à jour</button>
    </form>
</div>

<script>
// JavaScript similaire à celui de publicationModal pour gérer les éléments dynamiques comme les tags et la prévisualisation de l'image
const addPublicationBtn = document.getElementById('addPublicationBtn');
const modal = document.getElementById('publicationModal');
const closeModal = document.getElementsByClassName('close')[0];


document.getElementById('imageUpload').onchange = function(event) {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.src = URL.createObjectURL(event.target.files[0]);
    imagePreview.style.display = "block";
};
</script>

</body>
</html>

<?php
// Fermeture de la connexion
$conn->close();
?>

