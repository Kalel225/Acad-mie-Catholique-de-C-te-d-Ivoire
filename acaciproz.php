<?php
// Inclure la connexion à la base de données
include('db_connect.php');

// Requête pour récupérer les quatre actualités les plus récentes avec titre, contenu, image et catégorie
$query = "SELECT id, titre, contenu, image, categorie, date_publication FROM actualites ORDER BY date_publication DESC LIMIT 4";
$result = $conn->query($query);
?>

<html>
  <head>
    <base href="acaciproz.html" />
    <title>Académie Catholique de Côte d'Ivoire (ACACI)</title>
    <link rel="icon" href="assets/images/newpng.png" type="image/png" />
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0"
    />
    <meta
      name="description"
      content="Site officiel de l'Académie Catholique de Côte d'Ivoire (ACACI). Découvrez notre mission, nos domaines d'intervention et nos actualités."
    />
    <meta
      name="keywords"
      content="ACACI, Académie Catholique, Côte d'Ivoire, éducation, foi catholique, recherche"
    />
    <meta name="author" content="Académie Catholique de Côte d'Ivoire" />
    <style>
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

      .domains {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
      }

      .domain-card {
        background-color: var(--background-light);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        text-align: center;
        text-decoration: none;
        color: var(--text-color);
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .domain-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background-color: var(--primary-color);
        color: var(--white);
      }

      .domain-card h3 {
        color: var(--primary-color);
        margin-top: 0;
        margin-bottom: 1rem;
      }

      .domain-card:hover h3 {
        color: var(--white);
      }

      .domain-icon {
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 1rem;
      }

      .domain-card:hover .domain-icon {
        color: var(--white);
      }

      .domain-card p {
        font-size: 0.9rem;
      }

      .organs {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
      }

      .organ-card {
        flex-basis: calc(33.333% - 2rem);
        margin: 1rem;
        padding: 1.5rem;
        background-color: var(--background-light);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: var(--transition);
        text-decoration: none;
        color: var(--text-color);
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .organ-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background-color: var(--primary-color);
        color: var(--white);
      }

      .organ-card i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--secondary-color);
      }

      .organ-card:hover i {
        color: var(--white);
      }

      .organ-card h3 {
        margin-bottom: 0.5rem;
      }

      .organ-card p {
        font-size: 0.9rem;
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
    </style>
    <link
      href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    <a href="#main-content" class="skip-link">Aller au contenu principal</a>
    <header>
      <div class="container header-content">
        <div class="logo">
          <a href="acaciproz.php">
          <img
            src="assets/images/newpng.png"
            alt="Logo ACACI"
            width="60"
            height="60"
          />
          </a>
          <span class="logo-text"><a class="acaci" href="acaciproz.php">ACACI</a></span>
        </div>
        <button class="mobile-menu-toggle" aria-label="Ouvrir le menu">
          <i class="fas fa-bars"></i>
        </button>
        <nav>
          <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#a-propos">À propos</a></li>
            <li><a href="#mission">Mission</a></li>
            <li><a href="#domaines">Domaines</a></li>
            <li><a href="#organes">Organes</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="actualite.php">Actualités</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <main id="main-content">
      <section id="accueil" class="hero">
        <div class="hero-content">
          <h1>Académie Catholique de Côte d'Ivoire</h1>
          <p>
            Une institution dédiée à la réflexion intellectuelle, à la foi
            catholique et à la dignité humaine
          </p>
        </div>
      </section>
      <script>
        const images = [
          "assets/images/DSC_3707.JPG",
          "assets/images/DSC_3719.JPG",
          "assets/images/DSC_3776.JPG",
          "assets/images/DSC_3792.JPG",
          "assets/images/DSC00543.JPG",
        ];
        let currentIndex = 0;

        function changeBackground() {
          document.querySelector(
            ".hero"
          ).style.background = `url('${images[currentIndex]}') center/cover no-repeat`;
          currentIndex = (currentIndex + 1) % images.length;
        }

        setInterval(changeBackground, 7000); // Change image every 7 seconds
      </script>
      <section id="a-propos">
        <div class="container">
          <h2>À propos de l'ACACI</h2>
          <div class="about-content">
            <div class="about-text">
              <p>
                L'Académie Catholique de Côte d'Ivoire (ACACI) a été fondée en
                2019 suite à l'initiative des évêques de Côte d'Ivoire. Notre
                académie est une société savante indépendante, rattachée à la
                Conférence des Évêques Catholiques de Côte d'Ivoire.
              </p>
              <p>
                Nous nous engageons à maintenir notre indépendance vis-à-vis de
                toute affiliation politique ou syndicale. Par principe, l'ACACI
                n'admet pas en son sein les ordres ésotériques tels que la
                Franc-maçonnerie, la Rose-Croix, le Mahikari et autres
                organisations similaires.
              </p>
            </div>
            <div class="about-image">
              <img
                src="assets/images/DSC00481.JPG"
                alt="Bâtiment principal de l'ACACI"
                width="500"
                height="300"
              />
            </div>
          </div>
        </div>
      </section>

      <section id="mission">
        <div class="container">
          <h2>Notre Mission</h2>
          <div class="mission-content">
            <div class="mission-text">
              <p>
                La mission principale de l'ACACI est de promouvoir la réflexion
                et la production intellectuelles ancrées dans la foi catholique,
                la dignité humaine et les valeurs de nos peuples. Nous nous
                efforçons de :
              </p>
              <ul>
                <li>
                  Offrir notre expertise à la Conférence des Évêques sur
                  diverses questions d'importance.
                </li>
                <li>
                  Étudier les problématiques actuelles nationales et
                  internationales dans leurs multiples dimensions.
                </li>
                <li>
                  Faciliter la participation de l'Église de Côte d'Ivoire aux
                  débats cruciaux de notre société.
                </li>
                <li>
                  Jouer un rôle d'éclaireur sur les grandes questions
                  sociétales, en veillant à la sauvegarde de la dignité humaine.
                </li>
              </ul>
            </div>
            <div class="mission-image">
              <img
                src="assets/images/DSC_3792.JPG"
                alt="Membres de l'ACACI en réunion"
                width="500"
                height="300"
              />
            </div>
          </div>
        </div>
      </section>

      <section id="domaines">
        <div class="container">
          <h2>Commissions</h2>
          <div class="domains">
            <a href="commission-sens.html" class="domain-card">
              <i class="fas fa-flask domain-icon" aria-hidden="true"></i>
              <h3>Sciences Exactes, Naturelles et de la Santé (SENS)</h3>
              <p>
                Recherche et réflexion sur les avancées scientifiques et leurs
                implications éthiques.
              </p>
            </a>
            <a href="commission-shs.html" class="domain-card">
              <i class="fas fa-users domain-icon" aria-hidden="true"></i>
              <h3>Sciences Humaines et Sociales (SHS)</h3>
              <p>
                Analyse des dynamiques sociales et culturelles à la lumière de
                la pensée catholique.
              </p>
            </a>
            <a href="commission-lac.html" class="domain-card">
              <i class="fas fa-paint-brush domain-icon" aria-hidden="true"></i>
              <h3>Lettres, Arts et Culture (LAC)</h3>
              <p>
                Promotion de l'expression artistique et culturelle en harmonie
                avec les valeurs chrétiennes.
              </p>
            </a>
            <a href="commission-psr.html" class="domain-card">
              <i class="fas fa-book domain-icon" aria-hidden="true"></i>
              <h3>Philosophie et Sciences Religieuses (PSR)</h3>
              <p>
                Approfondissement de la réflexion théologique et philosophique
                dans le contexte contemporain.
              </p>
            </a>
            <a href="commission-add.html" class="domain-card">
              <i
                class="fas fa-balance-scale domain-icon"
                aria-hidden="true"
              ></i>
              <h3>Administration, Défense et Diplomatie (ADD)</h3>
              <p>
                Réflexion sur la gouvernance, la paix et les relations
                internationales dans une perspective catholique.
              </p>
            </a>
          </div>
        </div>
      </section>

      <section id="organes">
        <div class="container">
          <h2>Organes de l'ACACI</h2>
          <div class="organs">
            <a href="organe-college.html" class="organ-card">
              <i class="fas fa-users fa-3x mb-3" aria-hidden="true"></i>
              <h3>Le Collège</h3>
              <p>
                Assemblée générale des membres de l'Académie, organe suprême de
                décision.
              </p>
            </a>
            <a href="organe-bureau.html" class="organ-card">
              <i class="fas fa-building fa-3x mb-3" aria-hidden="true"></i>
              <h3>Le Bureau</h3>
              <p>
                Organe exécutif chargé de la gestion quotidienne de l'Académie.
              </p>
            </a>
            <a href="organe-conseil-scientifique.html" class="organ-card">
              <i class="fas fa-brain fa-3x mb-3" aria-hidden="true"></i>
              <h3>Le Conseil Scientifique</h3>
              <p>
                Garant de la qualité et de la pertinence des travaux
                académiques.
              </p>
            </a>
            <a href="organe-commissions.html" class="organ-card">
              <i
                class="fas fa-project-diagram fa-3x mb-3"
                aria-hidden="true"
              ></i>
              <h3>Les Commissions</h3>
              <p>
                Groupes de travail spécialisés dans les différents domaines
                d'intervention.
              </p>
            </a>
            <a href="organe-administration.html" class="organ-card">
              <i class="fas fa-cogs fa-3x mb-3" aria-hidden="true"></i>
              <h3>L'Administration</h3>
              <p>
                Équipe assurant le soutien logistique et administratif de
                l'Académie.
              </p>
            </a>
          </div>
        </div>
      </section>

      <section id="contact">
        <div class="container">
          <h2>Contactez-nous</h2>
          <div class="contact-form">
            <form
              action="https://academie-catholique-ci.edu/contact"
              method="POST"
            >
              <label for="name" class="visually-hidden">Votre nom</label>
              <input
                type="text"
                id="name"
                name="name"
                placeholder="Votre nom"
                required
              />

              <label for="email" class="visually-hidden">Votre email</label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="Votre email"
                required
              />

              <label for="message" class="visually-hidden">Votre message</label>
              <textarea
                id="message"
                name="message"
                placeholder="Votre message"
                rows="5"
                required
              ></textarea>

              <button type="submit">Envoyer</button>
            </form>
          </div>
          <div
            class="contact-info"
            style="text-align: center; margin-top: 2rem"
          >
            <p>
              <i class="fas fa-map-marker-alt" aria-hidden="true"></i> Cocody
              Riviera 3, Abidjan, Côte d'Ivoire
            </p>
            <p>
              <i class="fas fa-phone" aria-hidden="true"></i>
              <a href="tel:+22527224797664">+225 07 59 38 27 85</a>
            </p>
            <p>
              <i class="fas fa-envelope" aria-hidden="true"></i>
              <a href="mailto:contact@acaci.edu.ci"
                >academiecatholiqueci@hotmail.com</a
              >
            </p>
          </div>
        </div>
      </section>


<section
id="actualites">
    <div class="container">
        <h2>Dernières Actualités</h2>
        <div class="news-grid">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="news-item">
                    <div class="news-image">
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de <?php echo htmlspecialchars($row['titre']); ?>">
                    </div>
                    <div class="news-content">
                        <h3><?php echo htmlspecialchars($row['titre']); ?></h3>
                        <p class="category"><?php echo htmlspecialchars($row['categorie']); ?></p>
                        <p><?php echo substr(htmlspecialchars($row['contenu']), 0, 100); ?>...</p>
                        <a href="actualite.php?id=<?php echo $row['id']; ?>" class="see-more-link">Voir plus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php
// Fermer la connexion
$conn->close();
?>
    </main>

    <footer>
      <div class="container">
        <p>
          &copy; 2024 Académie Catholique de Côte d'Ivoire (ACACI). Tous droits
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
    <script>
      // Récupérer les publications depuis localStorage
      const publications =
        JSON.parse(localStorage.getItem("mainSitePublications")) || [];

      // Sélectionner l'élément où les publications seront affichées
      const publicationList = document.getElementById("publicationList");

      // Fonction pour afficher les publications
      function displayPublications() {
        if (publications.length === 0) {
          publicationList.innerHTML =
            "<p>Aucune actualité ou événement pour le moment.</p>";
        } else {
          publications.forEach((pub) => {
            const li = document.createElement("li");
            li.className = "publication-item";
            li.innerHTML = `
                    <h3>${pub.title}</h3>
                    <p><strong>Catégorie:</strong> ${pub.category}</p>
                    <div>${pub.content}</div>
                    ${
                      pub.imageUrl
                        ? `<img src="${pub.imageUrl}" alt="${pub.title}" class="publication-image">`
                        : ""
                    }
                    <p><strong>Tags:</strong> ${pub.tags.join(", ")}</p>
                    <p><small>Publié le ${new Date(pub.date).toLocaleDateString(
                      "fr-FR"
                    )} à ${new Date(pub.date).toLocaleTimeString(
              "fr-FR"
            )}</small></p>
                `;
            publicationList.appendChild(li);
          });
        }
      }

      // Afficher les publications au chargement de la page
      displayPublications();
    </script>
    <script>
      // Mobile menu toggle
      const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
      const nav = document.querySelector("nav ul");

      mobileMenuToggle.addEventListener("click", () => {
        nav.classList.toggle("show");
      });

      // Close mobile menu when a link is clicked
      nav.addEventListener("click", (e) => {
        if (e.target.tagName === "A") {
          nav.classList.remove("show");
        }
      });

      // Smooth scrolling for navigation links
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
          });
        });
      });

      // Simple form validation
      const form = document.querySelector("form");
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        // Here you would typically send the form data to a server
        alert("Merci pour votre message. Nous vous contacterons bientôt.");
        form.reset();
      });

      // Lazy loading for images
      if ("loading" in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach((img) => {
          img.src = img.dataset.src;
        });
      } else {
        // Fallback for browsers that don't support lazy loading
        const script = document.createElement("script");
        script.src =
          "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js";
        document.body.appendChild(script);
      }

      // Header shrink on scroll
      window.addEventListener("scroll", () => {
        const header = document.querySelector("header");
        const logo = document.querySelector(".logo img");
        if (window.scrollY > 100) {
          header.style.padding = "0.5rem 0";
          logo.style.height = "60px";
        } else {
          header.style.padding = "1rem 0";
          logo.style.height = "60px";
        }
      });

      // Accessibility improvements
      const accessibilityStyles = `
      *:focus {
        outline: 3px solid var(--secondary-color);
        outline-offset: 2px;
      }
      .visually-hidden:not(:focus):not(:active) {
        clip: rect(0 0 0 0);
        clip-path: inset(50%);
        height: 1px;
        overflow: hidden;
        position: absolute;
        white-space: nowrap;
        width: 1px;
      }
    `;
      const styleElement = document.createElement("style");
      styleElement.textContent = accessibilityStyles;
      document.head.appendChild(styleElement);

      // Add ARIA labels to icon buttons
      document.querySelectorAll("button").forEach((button) => {
        if (!button.getAttribute("aria-label")) {
          const buttonText = button.textContent.trim();
          button.setAttribute("aria-label", buttonText);
        }
      });

      // Enhance keyboard navigation
      const focusableElements =
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
      const firstFocusableElement = document.querySelector(focusableElements);
      const focusableContent = document.querySelectorAll(focusableElements);
      const lastFocusableElement =
        focusableContent[focusableContent.length - 1];

      document.addEventListener("keydown", function (e) {
        let isTabPressed = e.key === "Tab" || e.keyCode === 9;

        if (!isTabPressed) {
          return;
        }

        if (e.shiftKey) {
          if (document.activeElement === firstFocusableElement) {
            lastFocusableElement.focus();
            e.preventDefault();
          }
        } else {
          if (document.activeElement === lastFocusableElement) {
            firstFocusableElement.focus();
            e.preventDefault();
          }
        }
      });

      // Add aria-current to active navigation link
      const navLinks = document.querySelectorAll("nav a");
      const sections = document.querySelectorAll("section");

      window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach((section) => {
          const sectionTop = section.offsetTop;
          const sectionHeight = section.clientHeight;
          if (pageYOffset >= sectionTop - sectionHeight / 3) {
            current = section.getAttribute("id");
          }
        });

        navLinks.forEach((link) => {
          link.removeAttribute("aria-current");
          if (link.getAttribute("href").slice(1) === current) {
            link.setAttribute("aria-current", "page");
          }
        });
      });

      // Implement a "Back to Top" button
      const backToTopButton = document.createElement("button");
      backToTopButton.innerHTML = "&uarr;";
      backToTopButton.setAttribute("aria-label", "Retour en haut de la page");
      backToTopButton.classList.add("back-to-top");
      document.body.appendChild(backToTopButton);

      backToTopButton.addEventListener("click", () => {
        window.scrollTo({
          top: 0,
          behavior: "smooth",
        });
      });

      window.addEventListener("scroll", () => {
        if (window.pageYOffset > 300) {
          backToTopButton.style.display = "block";
        } else {
          backToTopButton.style.display = "none";
        }
      });

      // Add custom styles for the "Back to Top" button
      const backToTopStyles = `
      .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 20px;
        cursor: pointer;
        display: none;
        transition: var(--transition);
        z-index: 1000;
      }
      .back-to-top:hover {
        background-color: var(--secondary-color);
      }
    `;
      const backToTopStyleElement = document.createElement("style");
      backToTopStyleElement.textContent = backToTopStyles;
      document.head.appendChild(backToTopStyleElement);

      // Implement dark mode toggle
      const darkModeToggle = document.createElement("button");
      darkModeToggle.innerHTML = "🌙";
      darkModeToggle.setAttribute("aria-label", "Basculer en mode sombre");
      darkModeToggle.classList.add("dark-mode-toggle");
      document.body.appendChild(darkModeToggle);

      darkModeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        if (document.body.classList.contains("dark-mode")) {
          darkModeToggle.innerHTML = "☀️";
          darkModeToggle.setAttribute("aria-label", "Basculer en mode clair");
        } else {
          darkModeToggle.innerHTML = "🌙";
          darkModeToggle.setAttribute("aria-label", "Basculer en mode sombre");
        }
      });

      // Add custom styles for dark mode
      const darkModeStyles = `
      body.dark-mode {
        background-color: #333;
        color: #f4f4f4;
      }
      body.dark-mode header {
        background-color: #222;
      }
      body.dark-mode .domain-card,
      body.dark-mode .organ-card,
      body.dark-mode .contact-form {
        background-color: #444;
      }
      body.dark-mode h2,
      body.dark-mode h3 {
        color: var(--secondary-color);
      }
      .dark-mode-toggle {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: transparent;
        border: none;
        font-size: 24px;
        cursor: pointer;
        z-index: 1000;
      }
    `;
      const darkModeStyleElement = document.createElement("style");
      darkModeStyleElement.textContent = darkModeStyles;
      document.head.appendChild(darkModeStyleElement);

      // Implement a simple cookie consent banner
      const cookieConsent = localStorage.getItem("cookieConsent");
      if (!cookieConsent) {
        const cookieBanner = document.createElement("div");
        cookieBanner.classList.add("cookie-banner");
        cookieBanner.innerHTML = `
        <p>Nous utilisons des cookies pour améliorer votre expérience sur notre site. En continuant à naviguer, vous acceptez notre utilisation des cookies.</p>
        <button id="accept-cookies">Accepter</button>
      `;
        document.body.appendChild(cookieBanner);

        document
          .getElementById("accept-cookies")
          .addEventListener("click", () => {
            localStorage.setItem("cookieConsent", "true");
            cookieBanner.style.display = "none";
          });
      }

      // Add custom styles for the cookie banner
      const cookieBannerStyles = `
      .cookie-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: var(--primary-color);
        color: var(--white);
        padding: 10px;
        text-align: center;
        z-index: 1001;
      }
      .cookie-banner button {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        border: none;
        padding: 5px 10px;
        margin-left: 10px;
        cursor: pointer;
      }
    `;
      const cookieBannerStyleElement = document.createElement("style");
      cookieBannerStyleElement.textContent = cookieBannerStyles;
      document.head.appendChild(cookieBannerStyleElement);

      // Implement a simple newsletter signup form
      const newsletterForm = document.createElement("form");
      newsletterForm.classList.add("newsletter-form");
      newsletterForm.innerHTML = `
      <h3>Abonnez-vous à notre newsletter</h3>
      <input type="email" placeholder="Votre adresse e-mail" required>
      <button type="submit">S'abonner</button>
    `;
      document.querySelector("footer .container").appendChild(newsletterForm);

      newsletterForm.addEventListener("submit", (e) => {
        e.preventDefault();
        // Here you would typically send the email to a server
        alert("Merci de vous être abonné à notre newsletter!");
        newsletterForm.reset();
      });

      // Add custom styles for the newsletter form
      const newsletterFormStyles = `
      .newsletter-form {
        margin-top: 20px;
        text-align: center;
      }
      .newsletter-form input[type="email"] {
        padding: 5px;
        margin-right: 10px;
      }
      .newsletter-form button {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        border: none;
        padding: 5px 10px;
        cursor: pointer;
      }
    `;
      const newsletterFormStyleElement = document.createElement("style");
      newsletterFormStyleElement.textContent = newsletterFormStyles;
      document.head.appendChild(newsletterFormStyleElement);
    </script>
    <?php
// Fermer la connexion
$conn->close();
?>
  </body>
</html>
