<?php
session_start();
include('db_connect.php');

// Vérifiez que l'utilisateur est bien connecté, sinon redirection vers login.php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Vérifiez que l'ID de la publication est passé en GET, sinon affichez un message
if (!isset($_GET['id']) && !isset($_POST['id'])) {
    echo "Publication non trouvée.";
    exit();
}

// Récupération de l'ID de publication
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

// Si le formulaire a été soumis, mettez à jour les données
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Mise à jour de la publication
    $query = "UPDATE actualites SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $title, $content, $id);
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la publication.";
    }
} else {
    // Si le formulaire n'a pas été soumis, récupérez les données actuelles pour afficher dans le formulaire
    $query = "SELECT * FROM actualites WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $publication = $result->fetch_assoc();

    if (!$publication) {
        echo "Publication non trouvée.";
        exit();
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

