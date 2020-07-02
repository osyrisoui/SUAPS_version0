<?php

echo "

<!DOCTYPE html>
<html lang=\'en\'>
<head>
    <meta charset=\'UTF-8\'>
    <title>navigation bar</title>
    <link href=\'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700i\' rel=\'stylesheet\'>
    <link href=\'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i\' rel=\'stylesheet\'>

    <link href=\'assets/vendor/bootstrap/css/bootstrap.min.css\' rel=\'stylesheet\'>
    <link href=\'assets/vendor/boxicons/css/boxicons.min.css\' rel=\'stylesheet\'>

    <link href=\'assets/css/styledroite.css\' rel=\'stylesheet\'>
    <link href=\'assets/css/stylegauche.css\' rel=\'stylesheet\'>


</head>

<body>
                                 <!-- Debut menu de gauche -->
<header class=\'header\' >
    <nav class=\'navigation\'>
        <section class=\'logo\'></section>
        <section class=\'navigation__icon\'>
            <span class=\'topBar\'></span>
            <span class=\'middleBar\'></span>
            <span class=\'bottomBar\'></span>
        </section>
        <ul class=\'navigation__ul\'>
            <li><a href=\'\'>Gestion des Inscriptions</a></li>
            <li><a href=\'\'>Parcours Etudiant</a></li>
            <li><a href=\'\'>Détails des Cours</a></li>
            <li><a href=\'\'>Liste des cours</a></li>
            <li><a href=\'\'>notation</a></li>
            <li><a href=\'\'>notation ema</a></li>
            <li><a href=\'\'>Envoi d Email</a></li>
            <li><a href=\'\'>Envoi des pages</a></li>
            <li><a href=\'\'>Gestion des messages</a></li>
            <li><a href=\'\'>Cas particuliers</a></li>
            <li><a href=\'\'>Ajout des cours</a></li>
            <li><a href=\'\'>Gestion de la base</a></li>
            <li><a href=\'\'>Statistiques</a></li>
        </ul>
        <section class=\'logo_en_bas\' >
            <img src=\'assets/img/logo_sport.jpg\'>
        </section>
        <section class=\'logo_en_bas2\' >
            <img src=\'assets/img/logo_sport2.jpg\'>
        </section>
        <section class=\'logo_en_bas3\' >
            <img src=\'assets/img/logo_sport3.jpg\'>
        </section>
    </nav>
</header>
                                 <!-- Fin menu de gauche -->

                                 <!-- Debut menu de droite -->
<header id=\'header1\'>
    <div class=\'d-flex flex-column\'>
        <div class=\'profile\'>
            <img src=\'assets/img/logo.jpg\' alt=\'\' class=\'img-fluid rounded-circle\'>
            <br>
            <h4 class=\'text-light\'><a href=\'index.html\'>~ <span>Application SUAPS</span> ~</a></h4>
            <br>
        </div>

        <br><hr><br><br>

        <nav class=\'nav-menu\'>
            <ul>
                <li><a><span>Choisissez une offre de formation</span></a></li>
                <select name=\'choix_formation\' id=\'formation\'>
                    <optgroup label=\'promotion 2019-2020\'></optgroup>
                        <option value=\'Cours Blois S1\'>Cours Blois S1</option>
                        <option value=\'Cours Blois S2\'>Cours Blois S2</option>
                        <option value=\'Cours Tours S1\'>Cours Tours S1</option>
                        <option value=\'Cours Tours S2\'>Cours Tours S2</option>
                        <option value=\'\'>Stage nature</option>
                        <option value=\'\'>Offre CVEC</option>
                    <optgroup label=\'promotion 2020-2021\'></optgroup>
                        <option value=\'Cours Blois S1\'>Cours Blois S1</option>
                        <option value=\'Cours Blois S2\'>Cours Blois S2</option>
                        <option value=\'Cours Tours S1\'>Cours Tours S1</option>
                        <option value=\'Cours Tours S2\'>Cours Tours S2</option>
                        <option value=\'Stages\'>Stages</option>
                        <option value=\'Evénements\'>Evénements</option>
                </select>
                <li><a><span>Choisissez une Activité</span></a></li>

                <br><br/><hr><br><br><br>

                <li class=\'active\'><a><i class=\'bx bx-home\'></i> <span>Votre Page = Parcours Etudiant</span></a></li>

                <br><br><br><hr><br><br>

                <li><a><i class=\'bx bx-user\'></i> <span >Niveau de débug</span></a></li>
                <select name=\'niveau_debug\' id=\'niv_debug\'>
                    <option value=\'Debug Off\'>Debugg Off</option>
                    <option value=\'Niveau 1\'>Niveau 1</option>
                    <option value=\'Niveau 2\'>Niveau 2</option>
                    <option value=\'Niveau 3\'>Niveau 3</option>
                    <option value=\'Niveau 4\'>Niveau 4</option>
                    <option value=\'Niveau 5\'>Niveau 5</option>
                </select>
                <li><a><i class=\'bx bx-book-content\'></i> Base de travail</a></li>
                <select name=\'base_de_travail\' id=\'base_travail\'>
                    <option value=\'Base de Prod.\'>Base de Prod.</option>
                    <option value=\'Base de Test\'>Base de Test</option>
            </ul>
        </nav>
    </div>
</header> 

                                 <!-- Fin menu de droite -->

                                 <!-- Start space Script -->
<script src=\'https://code.jquery.com/jquery-3.3.1.js\'></script>
<script>
"
?>.

    $(function() {
        $(\'.navigation__icon\').click(function() {
            $(\'.navigation\').toggleClass('navigation-open');
        });
    });
.
<?php
echo "

</script>

                                 <!-- Fin space Script -->

</body>
</html>

"
?>
