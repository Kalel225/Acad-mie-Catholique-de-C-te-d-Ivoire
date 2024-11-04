<?php
// Inclure la connexion à la base de données
include('db_connect.php');

// Récupérer l'ID de l'actualité à modifier
$id = $_GET['id'] ?? null;

// Vérifier si l'ID est valide
if ($id === null) {
    
   
die("ID d'actualité non spécifié.");
}

// Récupérer les informations actuelles de l'actualité
$query = "SELECT * FROM actualites WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$publication = $result->fetch_assoc();

// Vérifier si l'actualité existe
if (!$publication) {
    die("L'actualité demandée n'existe pas.");
}

// Mettre à jour les informations si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $categorie = $_POST['categorie'];
    $contenu = $_POST['contenu'];

    // Vérifier s'il y a une nouvelle image à télécharger
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    } else {
        // Utiliser l'image actuelle si aucune nouvelle image n'est fournie
        $imagePath = $publication['image'];
    }

    // Requête de mise à jour
    $updateQuery = "UPDATE actualites SET titre = ?, categorie = ?, contenu = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $titre, $categorie, $contenu, $imagePath, $id);

    if ($stmt->execute()) {
        echo "L'actualité a été mise à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'actualité</title>
    <style>
        :root {--primary-color: #8b0000;
        --secondary-color: #ffd700;
        --text-color: #333333;
        --background-light: #fff8dc;
        --white: #ffffff;
        --gray: #f4f4f4;
        --transition: all 0.3s ease-in-out;
      }

      body {
        font-family: "Roboto", Arial, sans-serif;
        background-color: var(--background-light);
        margin: 0;
        padding: 0;
        color: var(--text-color);
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }

      header {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 20px 0;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      h1,
      h2,
      h3 {
        margin: 0;
      }

      nav {
        background-color: var(--secondary-color);
        padding: 10px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      nav ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
      }

      nav ul li {
        margin: 0 15px;
      }

      nav ul li a {
        color: var(--text-color);
        text-decoration: none;
        font-weight: bold;
        transition: var(--transition);
        padding: 5px 10px;
        border-radius: 5px;
      }

      nav ul li a:hover {
        background-color: var(--primary-color);
        color: var(--white);
      }

      .dashboard-section {
        background-color: var(--white);
        border-radius: 8px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .publication-list {
        list-style-type: none;
        padding: 0;
      }

      .publication-item {
        background-color: var(--gray);
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      }

      .publication-image {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin-top: 10px;
      }

      .btn-group {
        margin-top: 10px;
      }

      .btn {
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 14px;
        font-weight: bold;
        margin-right: 10px;
      }

      .btn:hover {
        background-color: var(--secondary-color);
        color: var(--text-color);
      }

      .btn-delete {
        background-color: #dc3545;
      }

      .btn-edit {
        background-color: #007bff;
      }

      #addPublicationBtn {
        display: block;
        margin: 20px auto;
        font-size: 18px;
        padding: 15px 30px;
      }

      #publicationModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
      }

      .modal-content {
        background-color: var(--white);
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        height: 80vh;
        overflow-y: auto;
      }

      .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
      }

      .close:hover,
      .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
      }

      .form-group {
        margin-bottom: 20px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }

      .form-group input[type="text"],
      .form-group textarea,
      .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
      }

      .form-group textarea {
        height: 150px;
        resize: vertical;
      }

      #editor {
        height: 300px;
      }

      .image-preview {
        max-width: 200px;
        max-height: 200px;
        margin-top: 10px;
      }

      .tag-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
      }

      .tag {
        background-color: var(--secondary-color);
        color: var(--text-color);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
      }

      .tag .remove-tag {
        margin-left: 5px;
        cursor: pointer;
      }

      #tagInput {
        width: calc(100% - 100px);
      }

      #addTagBtn {
        width: 90px;
        margin-left: 10px;
      }
      footer {
        background-color: var(--primary-color);
        color: var(--white);
        text-align: center;
        padding: 2rem 0;
        margin-top: 4rem;
      }
      a {
        text-decoration: none;
      }

      a img {
        border: 0;
      }
      .spy {
        text-decoration: none;
        color: var(--white);
      }
</style>

</head>
<body>
<header>
        <div class="container">
            <h1><i class="fas fa-user-shield"></i> Tableau de bord administrateur ACACI</h1>
        </div>
    </header>

    <div class="form-container" >
    <h2>Modifier l'actualité</h2>
    <form action="edit_publication.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" value="<?php echo htmlspecialchars($publication['titre']); ?>" required>
        </div>
        <div>
            <label for="categorie">Catégorie</label>
            <select name="categorie" id="categorie" required>
                <option value="actualite" <?php if ($publication['categorie'] == 'actualite') echo 'selected'; ?>>Actualité</option>
                <option value="evenement" <?php if ($publication['categorie'] == 'evenement') echo 'selected'; ?>>Événement</option>
                <option value="article" <?php if ($publication['categorie'] == 'article') echo 'selected'; ?>>Article</option>
            </select>
        </div>
        <div>
            <label for="contenu">Contenu</label>
            <textarea name="contenu" id="contenu" required><?php echo htmlspecialchars($publication['contenu']); ?></textarea>
        </div>
        <div>
            <label for="image">Image de couverture</label>
            <input type="file" name="image" id="image">
            <img src="<?php echo htmlspecialchars($publication['image']); ?>" alt="Aperçu de l'image" style="max-width: 100px;">
        </div>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    </div>
    
    <footer>
      <div class="container">
        <p>
          &copy; 2024 Académie Catholique de Côte d'Ivoire <span class=""><a class="spy" href="admin_dashboard.php">(ACACI)</a></span>. Tous droits
          réservés.
        </p>
        <div class="social-icons" style="margin-top: 1rem">
          <a
            href="https://www.facebook.com/ACACI"
            aria-label="Facebook de l'ACACI"
            ><i
              class="fab fa-facebook fa-2x"
              style="color: var(--secondary-color); margin: 0 10px"
            ></i
          ></a>
          <a
            href="https://www.twitter.com/ACACI"
            aria-label="Twitter de l'ACACI"
            ><i
              class="fab fa-twitter fa-2x"
              style="color: var(--secondary-color); margin: 0 10px"
            ></i
          ></a>
          <a
            href="https://www.linkedin.com/company/ACACI"
            aria-label="LinkedIn de l'ACACI"
            ><i
              class="fab fa-linkedin fa-2x"
              style="color: var(--secondary-color); margin: 0 10px"
            ></i
          ></a>
        </div>
      </div>
    </footer>
</body>
</html>
