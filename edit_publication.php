<?php
session_start();
include('db_connect.php');

// Vérifiez si la connexion à la base de données a réussi
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Vérifiez si l'administrateur est connecté
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit();
}

// Assurez-vous d'avoir l'ID de la publication à modifier
if (isset($_GET['id'])) {
    
   
$publication_id = $_GET['id'];

    // Récupérer la publication depuis la base de données
    $query = "SELECT * FROM actualites WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $publication_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $publication = $result->fetch_assoc();

    // Vérifiez si la publication existe
    if (!$publication) {
        echo "Publication non trouvée.";
        exit();
    }
} else {
    echo "ID de publication manquant.";
    exit();
}

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    
    // Mettre à jour la publication dans la base de données
    $update_query = "UPDATE actualites SET titre = ?, contenu = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $titre, $contenu, $publication_id);

    if ($update_stmt->execute()) {
        header('Location: admin_dashboard.php'); // Rediriger vers le tableau de bord après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la publication.";
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

