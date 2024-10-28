<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mon_project"; // Assurez-vous que ce nom de base de données est correct

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de la présence du fichier image dans le formulaire
    if (!empty($_FILES["image"]["name"])) {
        // Dossier de destination pour les images
        $target_dir = "uploads/"; // Assurez-vous que ce dossier existe

        // Chemin complet du fichier téléchargé
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        // Obtenir l'extension du fichier
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

        // Limiter la taille de l'image
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
            echo "Le fichier " . htmlspecialchars(basename($_FILES["image"]["name"])) . " a été téléchargé avec succès.";

            // Insérer les détails de l'actualité dans la base de données
            $titre = $conn->real_escape_string($_POST['titre']);
            $contenu = $conn->real_escape_string($target_file); // Utiliser l'image comme contenu
            $categorie = $conn->real_escape_string($_POST['category']); // Récupérer la catégorie

            $sql = "INSERT INTO actualites (titre, contenu, image, categorie) VALUES ('$titre', '$contenu', '$target_file', '$categorie')";
            
            if ($conn->query($sql) === TRUE) {
                echo "Nouvelle actualité ajoutée avec succès.";
            } else {
                echo "Erreur : " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
       echo "Veuillez sélectionner une image à télécharger.";
    }
}

$conn->close();
?>
