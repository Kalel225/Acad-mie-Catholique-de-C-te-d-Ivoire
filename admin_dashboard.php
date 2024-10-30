<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["image"]["name"])) {
        // Dossier de destination pour les images
        
        
$target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifier si le fichier est une image réelle
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "Le fichier sélectionné n'est pas une image.";
            exit;
        }

        // Vérifier si l'image existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, cette image existe déjà.";
            exit;
        }
        if ($_FILES["image"]["size"] > 2000000) {
            echo "Désolé, votre fichier est trop volumineux.";
            exit;
        }

        // Limiter les types de fichiers autorisés
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            exit;
        }

        // Essayer de déplacer le fichier dans le dossier de destination
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            
          
// Insérer les détails de l'actualité dans la base de données
            $titre = $conn->real_escape_string($_POST['titre']);
            $contenu = $conn->real_escape_string($_POST['contenu']);
            $image = $conn->real_escape_string($target_file); 

            

 
$sql = "INSERT INTO actualites (titre, contenu, image) VALUES ('$titre', '$contenu', '$image')";
            
            
            
          
if ($conn->query($sql) === TRUE) {
                echo "Nouvelle actualité ajoutée avec succès.";
            } 
            } 
else {
                echo "Erreur : " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
       // echo "Veuillez sélectionner une image à télécharger.";
    }


// Récupérer les publications de la base de données
$sql = "SELECT * FROM actualites ORDER BY id DESC"; // Assurez-vous que la colonne 'id' existe dans votre table
$result = $conn->query($sql);

// Vérifier si la requête a réussi
if ($result === FALSE) {
    echo "Erreur lors de la récupération des publications : " . $conn->error;
    $result = null; // Définit $result à null pour éviter les avertissements plus tard
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ACACI</title>
    <link rel="icon" href="assets/images/newpng.png" type="image/png" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.css"
    />
    <style>
      :root {
        --primary-color: #8b0000;
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
    </style>
</head>

<body>
    <header>
        <div class="container">
            <h1><i class="fas fa-user-shield"></i> Tableau de bord administrateur ACACI</h1>
        </div>
    </header>

    <nav>
        <ul>
            <li>
                <a href="logout.php" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <section id="publications" class="dashboard-section">
            <h2><i class="fas fa-newspaper"></i> Gestion des publications</h2>
            <button id="addPublicationBtn" class="btn"><i class="fas fa-plus"></i> Ajouter une publication</button>
            <ul id="publicationList" class="publication-list"> 
            <?php
            $sql = "SELECT * FROM actualites";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<h3>" . htmlspecialchars($row['titre']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['categorie']) . "</p>";
                    echo "<p><img src='" . htmlspecialchars($row['image']) . "' alt='Image de l'actualité' style='max-width: 100%; height: auto;'></p>";

                    // Boutons Modifier et Supprimer
                    echo "<button class='editBtn' data-id='" . $row['id'] . "'>Modifier</button>";
                    echo "<button class='deleteBtn' data-id='" . $row['id'] . "'>Supprimer</button>";
                    echo "</li>";
                }
            } else {
                echo "<p>Aucune publication trouvée.</p>";
            }
            ?>
            </ul>
        </section>
    </div>

    <div id="publicationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Ajouter une publication</h2>
            <form id="publicationForm" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" name="titre" id="title" required />
                </div>
                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <option value="actualite">Actualité</option>
                        <option value="evenement">Événement</option>
                        <option value="article">Article</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editor">Contenu</label>
                    <textarea name="contenu" id="editor" required></textarea>
                </div>
                <div class="form-group">
                    <label for="imageUpload">Image de couverture</label>
                    <input type="file" name="image" id="imageUpload" accept="image/*" required />
                    <img id="imagePreview" class="image-preview" src="" alt="Aperçu de l'image" style="display: none" />
                </div>
                <button type="submit" class="btn">Enregistrer</button>
            </form>
        </div>
    </div>

    <script>
    // JavaScript pour gérer l'affichage du modal et la prévisualisation de l'image
    const addPublicationBtn = document.getElementById('addPublicationBtn');
    const modal = document.getElementById('publicationModal');
    const closeModal = document.getElementsByClassName('close')[0];

    // Afficher le pop-up quand on clique sur le bouton Ajouter une publication
    addPublicationBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Cacher le pop-up quand on clique sur le bouton de fermeture
    closeModal.onclick = function() {
        modal.style.display = "none";
    }

    // Fermer le pop-up si on clique à l'extérieur de celui-ci
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Prévisualisation de l'image
    document.getElementById('imageUpload').onchange = function(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
        imagePreview.style.display = "block";
    };

    // Gérer la suppression
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function() {
            const publicationId = this.getAttribute('data-id');
            if (confirm("Voulez-vous vraiment supprimer cette actualité ?")) {
                window.location.href = "delete_publication.php?id=" + publicationId;
            }
        });
    });

    // Gérer la modification
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function() {
            const publicationId = this.getAttribute('data-id');
            window.location.href = "edit_publication.php?id=" + publicationId;
        });
    });
    </script>
</body>
</html>
