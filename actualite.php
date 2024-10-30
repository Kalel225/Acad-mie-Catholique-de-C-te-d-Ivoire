<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mon_project";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    
  
die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les actualités depuis la base de données
$sql = "SELECT titre, contenu, image, categorie FROM actualites ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Actualités - ACACI</title>
    <link rel="icon" href="assets/images/newpng.png" type="image/png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <style>
      /* Ajoute ton CSS ici */
      :root {
        --primary-color: #8b0000; /* Rouge bordeaux */
        --secondary-color: #ffd700; /* Jaune */
        --text-color: #333333;
        --background-light: #fff8dc; /* Cornsilk, un fond légèrement jaune */
        --white: #ffffff;
        --transition: all 0.3s ease-in-out;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
      }

      html {
        font-size: 16px;
        scroll-behavior: smooth;
      }

      body {
        font-family: "Lora", serif;
        line-height: 1.6;
        color: var(--text-color);
        background-color: var(--white);
        overflow-x: hidden;
      }

      .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
      }

      header {
        background-color: var(--primary-color);
        color: var(--white);
        padding: 1rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
      }

      .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .logo {
        display: flex;
        align-items: center;
      }

      .logo img {
        height: 60px;
        margin-right: 15px;
        transition: var(transition);
      }

      .logo-text {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--secondary-color);
        transition: var(transition);
      }

      nav ul {
        list-style-type: none;
        display: flex;
        justify-content: space-around;
      }

      nav ul li {
        margin: 0 15px;
      }

      nav ul li a {
        color: var(--white);
        text-decoration: none;
        font-weight: 500;
        font-size: 1.1rem;
        transition: var(--transition);
        position: relative;
      }

      nav ul li a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        left: 0;
        background-color: var(--secondary-color);
        transition: var(--transition);
      }

      nav ul li a:hover::after {
        width: 100%;
      }

      .hero {
        background: linear-gradient(rgba(139, 0, 0, 0.8), rgba(139, 0, 0, 0.8)),
          url("images/acaci-campus.jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--white);
      }

      .hero-content {
        max-width: 800px;
        padding: 2rem;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 10px;
      }

      .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        color: var(--secondary-color);
      }

      .hero-content p {
        font-size: 1.5rem;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
      }

      main {
        padding-top: 80px;
      }

      section {
        padding: 5rem 0;
      }

      h2 {
        color: var(--primary-color);
        font-size: 2.5rem;
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
      }

      h2::after {
        content: "";
        display: block;
        width: 50px;
        height: 3px;
        background-color: var(--secondary-color);
        margin: 10px auto 0;
      }

      .about-content,
      .mission-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
      }

      .about-text,
      .mission-text {
        flex: 1;
        padding-right: 2rem;
        min-width: 300px;
      }

      .about-image,
      .mission-image {
        flex: 1;
        text-align: center;
        min-width: 300px;
      }

      .about-image img,
      .mission-image img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
      }

      .about-image img:hover,
      .mission-image img:hover {
        transform: scale(1.05);
      }
      h1,
      h2,
      h3 {
        color: var(--primary-color);
        margin-bottom: 1rem;
      }

      h1 {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 2rem;
      }

      .college-description {
        background-color: var(--background-light);
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
      }

      .college-members {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
      }

      .member-card {
        background-color: var(--white);
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        transition: var(--transition);
      }

      .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .member-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
      }

      .member-name {
        font-weight: bold;
        margin-bottom: 0.5rem;
      }

      .member-title {
        font-style: italic;
        color: #666;
      }

      .contact-form {
        max-width: 600px;
        margin: 0 auto;
        background-color: var(--background-light);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }

      .contact-form input,
      .contact-form textarea {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: var(--transition);
      }

      .contact-form input:focus,
      .contact-form textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.2);
      }

      .contact-form button {
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0.8rem 2rem;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
      }

      .contact-form button:hover {
        background-color: #660000; /* Darker shade of burgundy */
      }

      .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
      }

      .news-card {
        background-color: var(--background-light);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
      }

      .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }

      .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: var(--transition);
      }

      .news-card:hover img {
        transform: scale(1.1);
      }

      .news-card-content {
        padding: 1.5rem;
      }

      footer {
        background-color: var(--primary-color);
        color: var(--white);
        text-align: center;
        padding: 2rem 0;
        margin-top: 4rem;
      }

      .organ-link {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 10px;
        background-color: var(--primary-color);
        color: var(--white);
        text-decoration: none;
        border-radius: 5px;
        transition: var(--transition);
      }

      .organ-link:hover {
        background-color: var(--secondary-color);
        color: var(--primary-color);
      }

      .acaci {
        text-decoration: none;
        color: var(--secondary-color);
      }

      a {
        text-decoration: none;
      }

      a img {
        border: 0;
      }

      /* Responsive design */
      @media (max-width: 1200px) {
        html {
          font-size: 14px;
        }

        .container {
          width: 95%;
        }
      }

      @media (max-width: 992px) {
        .about-content,
        .mission-content {
          flex-direction: column;
        }

        .about-text,
        .mission-text,
        .about-image,
        .mission-image {
          width: 100%;
          padding-right: 0;
          margin-bottom: 2rem;
        }

        .organ-card {
          flex-basis: calc(50% - 2rem);
        }
      }

      @media (max-width: 768px) {
        .header-content {
          flex-direction: column;
        }

        nav ul {
          margin-top: 1rem;
          flex-wrap: wrap;
          justify-content: center;
        }

        nav ul li {
          margin: 0.5rem;
        }

        .hero-content h1 {
          font-size: 2.5rem;
        }

        .hero-content p {
          font-size: 1.2rem;
        }

        section {
          padding: 3rem 0;
        }

        h2 {
          font-size: 2rem;
        }
      }

      @media (max-width: 576px) {
        html {
          font-size: 12px;
        }

        .organ-card {
          flex-basis: 100%;
        }

        .hero-content h1 {
          font-size: 2rem;
        }

        .hero-content p {
          font-size: 1rem;
        }
      }

      /* Accessibility Improvements */
      .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
      }

      /* Focus styles for keyboard navigation */
      a:focus,
      button:focus,
      input:focus,
      textarea:focus {
        outline: 3px solid var(--secondary-color);
        outline-offset: 2px;
      }

      /* Skip to main content link */
      .skip-link {
        position: absolute;
        top: -40px;
        left: 0;
        background: var(--primary-color);
        color: var(--white);
        padding: 8px;
        z-index: 100;
      }

      .skip-link:focus {
        top: 0;
      }

      /* Mobile menu styles */
      .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--white);
        font-size: 1.5rem;
        cursor: pointer;
      }

      @media (max-width: 768px) {
        .mobile-menu-toggle {
          display: block;
        }

        nav ul {
          display: none;
          flex-direction: column;
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: var(--primary-color);
          padding: 1rem 0;
        }

        nav ul.show {
          display: flex;
        }

        nav ul li {
          margin: 0.5rem 0;
        }
      }

      /* Responsive images */
      img {
        max-width: 100%;
        height: auto;
      }

      /* Flexible video embeds */
      .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
      }

      .video-container iframe,
      .video-container object,
      .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }

      /* Responsive tables */
      table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
      }

      @media (max-width: 600px) {
        table {
          display: block;
          overflow-x: auto;
          white-space: nowrap;
        }
      }

      /* Print styles */
      @media print {
        header,
        footer,
        nav,
        .hero {
          display: none;
        }

        body {
          font-size: 12pt;
          line-height: 1.5;
        }

        h1,
        h2,
        h3 {
          page-break-after: avoid;
        }

        img {
          max-width: 100% !important;
        }

        @page {
          margin: 2cm;
        }
      }

      .contact-form {
        max-width: 600px;
        margin: 0 auto;
        background-color: var(--background-light);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }

      .contact-form input,
      .contact-form textarea {
        width: 100%;
        padding: 0.8rem;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: var(--transition);
      }

      .contact-form input:focus,
      .contact-form textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.2);
      }

      .contact-form button {
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0.8rem 2rem;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
      }

      .contact-form button:hover {
        background-color: #660000; /* Darker shade of burgundy */
      }

      .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
      }

      .news-card {
        background-color: var(--background-light);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
      }

      .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }

      .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: var(--transition);
      }

      .news-card:hover img {
        transform: scale(1.1);
      }

      .news-card-content {
        padding: 1.5rem;
      }
    </style>
  </head>
  <body>
    <header>
      <div class="container header-content">
        <div class="logo">
          <img src="assets/images/jeoe.png" alt="Logo ACACI" width="60" height="60" />
          <span class="logo-text"><a class="acaci" href="acaciproz.php">ACACI</a></span>
        </div>
        <nav>
          <ul>
            <li><a href="acaciproz.php">Accueil</a></li>
            <li><a href="acaciproz.php">À propos</a></li>
            <li><a href="acaciproz.php">Mission</a></li>
            <li><a href="acaciproz.php">Domaines</a></li>
            <li><a href="acaciproz.php">Organes</a></li>
            <li><a href="actualite.php">Actualités</a></li>
            <!-- Lien pour le dashboard admin -->
          </ul>
        </nav>
      </div>
    </header>

    <main>
      <section id="actualites">
        <div class="container">
          <h2>Actualités et Événements</h2>
          <div class="news-grid">
          <?php
                if ($result->num_rows > 0) {
                    // Afficher chaque actualité
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="news-item">';
                        echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="Image de l\'actualité">';
                        echo '<h3>' . htmlspecialchars($row["titre"]) . '</h3>';
                        
                        
echo '<p>' . htmlspecialchars($row["contenu"]) . '</p>';
                        echo '<p><strong>Catégorie :</strong> ' . htmlspecialchars($row["categorie"]) . '</p>';
                        echo '</div>';
                    }
                } else {
                    
       
echo "<p>Aucune actualité disponible pour le moment.</p>";
                }
                ?>
          </div>
        </div>
      </section>
    <!-- Si l'administrateur est connecté, afficher le formulaire d'ajout d'actualités -->
    </main>
    <footer>
      <div class="container">
        <p>
          &copy; 2024 Académie Catholique de Côte d'Ivoire (ACACI). Tous droits
          réservés.
        </p>
        <div class="social-icons">
          <a
            href="https://www.facebook.com/ACACI"
            aria-label="Facebook de l'ACACI"
            ><i class="fab fa-facebook fa-2x"></i
          ></a>
          <a
            href="https://www.twitter.com/ACACI"
            aria-label="Twitter de l'ACACI"
            ><i class="fab fa-twitter fa-2x"></i
          ></a>
          <a
            href="https://www.linkedin.com/company/ACACI"
            aria-label="LinkedIn de l'ACACI"
            ><i class="fab fa-linkedin fa-2x"></i
          ></a>
        </div>
      </div>
    </footer>
  </body>
</html>
<?php
// Fermeture de la connexion
$conn->close();
?>
