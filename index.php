<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catherine MESSIER Designer & Finition INC.</title>
    <link rel="stylesheet" href="css/Style.css">
    <script src="js/contact-form.js" defer></script>
</head>
<body>

    <?php include "Pages/templates/header.php"; ?>

    <!-- Section principale avec grand titre et description -->
    <section class="hero">
        <div class="hero-content">
          <img src="image/Logo_CM_2_transparent_Gradient_2.png" alt="Logo Catherine Messier Designer & Finition INC." class="hero-logo">
          <p class="hero-desc">Description rapide de l'entreprise et des services.</p>
          <button class="hero-btn">En savoir plus</button>
        </div>
    </section>

    <!-- Section des services -->
    <section class="services">
        <h2>Nos Services</h2>
        <div class="service-container">
            <div class="service-box">
                <img src="image/Logo_CM_2_transparent_Gradient_2.png" alt="Design intérieur résidentiel">
                <h3>Design intérieur résidentiel</h3>
                <p>Conception et optimisation d’espaces de vie, choix de matériaux, couleurs et mobilier adaptés à vos besoins et à votre style.</p>
            </div>
            <div class="service-box">
                <img src="image/Logo_CM_2_transparent_Gradient_2.png" alt="Finition de surfaces">
                <h3>Finition de surfaces</h3>
                <p>Application professionnelle de peinture, vernis, enduits décoratifs et revêtements pour murs, plafonds et boiseries.</p>
            </div>
            <div class="service-box">
                <img src="image/Logo_CM_2_transparent_Gradient_2.png" alt="Conseil personnalisé">
                <h3>Conseil personnalisé</h3>
                <p>Accompagnement sur mesure pour vos projets, de la planification à la réalisation, avec des solutions créatives et adaptées.</p>
            </div>
            <div class="service-box">
                <img src="image/Logo_CM_2_transparent_Gradient_2.png" alt="Gestion de projet">
                <h3>Gestion de projet</h3>
                <p>Coordination complète des travaux, suivi des intervenants et respect des délais pour un résultat professionnel et sans souci.</p>
            </div>
        </div>
    </section>

    <?php include "Pages/templates/mailform.php"; ?>

    <?php include "Pages/templates/footer.php"; ?>
</body>
</html>
