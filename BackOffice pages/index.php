<?php
echo "

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>navigation bar</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700i' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>

    <link href='assets/vendor/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
    <link href='assets/vendor/boxicons/css/boxicons.min.css' rel='stylesheet'>

    <link href='assets/css/styledroite.css' rel='stylesheet'>
    <link href='assets/css/stylegauche.css' rel='stylesheet'>




</head>

<body>



<!-- Debut menu de gauche -->
<header class='header' >
    <nav class='navigation'>
        <section class='logo'></section>
        <section class='navigation__icon'>
            <span class='topBar'></span>
            <span class='middleBar'></span>
            <span class='bottomBar'></span>
        </section>
        <ul class='navigation__ul'>
            <li><a href='BackOffice.php?cible=Gestion des Inscriptions' title='Gestion des Inscriptions'>Gestion des Inscriptions</a></li>
            <li><a href='BackOffice.php?cible=Parcours Etudiant' title='Parcours Etudiant'>Parcours Etudiant</a></li>
            <li><a href='BackOffice.php?cible=Détail des Cours' title='Détail des Cours'>Détails des Cours</a></li>
            <li><a href='BackOffice.php?cible=Liste des Cours' title='Liste des Cours'>Liste des cours</a></li>
            <li><a href='BackOffice.php?cible=Notation' title='Notation'>notation</a></li>
            <li><a href='BackOffice.php?cible=Notation EMA' title='Notation EMA'>notation ema</a></li>
            <li><a href='BackOffice.php?cible=Envoi de mails' title='Envoi de mails'><>Envoi d'Email</a></li>
            <li><a href='BackOffice.php?cible=Edition des Pages' title='Edition des Pages'>Envoi des pages</a></li>
            <li><a href='BackOffice.php?cible=Gestion des messages' title='Gestion des messages'>Gestion des messages</a></li>
            <li><a href='BackOffice.php?cible=Cas Particuliers' title='Inscription des étudiants non-UFR & personnels.'>Cas particuliers</a></li>
            <li><a href='BackOffice.php?cible=Ajout des cours' title='Ajout des cours'>Ajout des cours</a></li>
            <li><a href='BackOffice.php?cible=Gestion de la base' title='Gestion de la base'>Gestion de la base</a></li>
            <li><a href='BackOffice.php?cible=Statistiques' title='Extractions et Statistiques'>Statistiques</a></li>
        </ul>
        <section class='logo_en_bas' >
            <img src='assets/img/logo_sport.jpg'>
        </section>
        <section class='logo_en_bas2' >
            <img src='assets/img/logo_sport2.jpg'>
        </section>
        <section class='logo_en_bas3' >
            <img src='assets/img/logo_sport3.jpg'>
        </section>
    </nav>
</header>
<!-- Fin menu de gauche -->

<!-- Debut menu de droite -->
<header id='header1'>
    <div class='d-flex flex-column'>
        <div class='profile'>
            <img src='assets/img/logo.jpg' alt='' class='img-fluid rounded-circle'>
            <br>
            <h4 class='text-light'><a href='index.html'>~ <span>Application SUAPS</span> ~</a></h4>
        </div>
        <div class='icones'>
            <div class='icone' href='destroy_session_cas_BO.php'><img width='30' src='assets/img/deconnexion.jpg'  border='0'></div>
            <div class='icone' href='/BackOffice/MOE/ME_BO_Detail_cours_1.htm'><img width='30' border='0' src='assets/img/info.gif'></div>
            <div class='icone' href='#?cible=Détail des Cours' onClick='window.print()'> <img width='30' src='assets/img/imprimante.jpg'></div>
        </div>
        <br><hr>

        <nav class='nav-menu'>
            <ul>
                <li><a><span>Choisissez une offre de formation</span></a></li>
                <select name='id_offre' OnChange='this.form.submit()' id='formation'>
                    <option type='text' value='' selected>- Suivant les promotions -</option>
                    <optgroup label='promotion 2019-2020'></optgroup>
                    <option type='text' value='143'>Cours Blois S1</option>
                    <option type='text' value='145'>Cours Blois S2</option>
                    <option type='text' value='142'>Cours Tours S1</option>
                    <option type='text' value='144'>Cours Tours S2</option>
                    <option type='text' value='140'>Stage nature</option>
                    <option type='text' value='141'>Offre CVEC</option>
                    <optgroup label='promotion 2020-2021'></optgroup>
                    <option type='text' value='143'>Cours Blois S1</option>
                    <option type='text' value='143'>Cours Blois S2</option>
                    <option type='text' value='143'>Cours Tours S1</option>
                    <option type='text' value='143'>Cours Tours S2</option>
                    <option type='text' value='143'>Stages</option>
                    <option type='text' value='143'>Evénements</option>
                </select>
                <li><a><span>Choisissez une Activité</span></a></li>
                <select name='id_activite' OnChange='this.form.submit()' id='activite'>
                    <option type='text' value='toutes' selected>- Toutes les activités -</option>
                    <option type='text' value='SUAPS_1'>Badminton</option>
                    <option type='text' value='SUAPS_2'>Tennis</option>
                    <option type='text' value='SUAPS_7'>Boxe Anglaise</option>
                    <option type='text' value='SUAPS_8'>Nage avec Palmes</option>
                    <option type='text' value='SUAPS_9'>Escalade</option>
                    <option type='text' value='SUAPS_10'>Karaté</option>
                    <option type='text' value='SUAPS_11'>Judo</option>
                    <option type='text' value='SUAPS_12'>BNSSA</option>
                    <option type='text' value='SUAPS_13'>Jujitsu - Self Défense</option>
                    <option type='text' value='SUAPS_17'>Fitness - Remise en Forme</option>
                    <option type='text' value='SUAPS_19'>Aïkido</option>
                    <option type='text' value='SUAPS_20'>Escrime</option>
                    <option type='text' value='SUAPS_26'>Boxe Française - Savate</option>
                    <option type='text' value='SUAPS_27'>Musculation</option>
                    <option type='text' value='SUAPS_28'>Natation</option>
                    <option type='text' value='SUAPS_29'>Tennis de Table</option>
                    <option type='text' value='SUAPS_31'>Taïso Self Défense</option>
                    <option type='text' value='SUAPS_32'>Athlétisme</option>
                    <option type='text' value='SUAPS_34'>Activités Aquatiques Multisports</option>
                    <option type='text' value='SUAPS_36'>Roller</option>
                    <option type='text' value='SUAPS_39'>Aquagym</option>
                    <option type='text' value='SUAPS_40'>Ultimate-Frisbee</option>
                    <option type='text' value='SUAPS_42'>Plongée</option>
                    <option type='text' value='SUAPS_43'>Rugby</option>
                    <option type='text' value='SUAPS_45'>Arts du Cirque (Jonglerie)</option>
                    <option type='text' value='SUAPS_47'>Squash</option>
                    <option type='text' value='SUAPS_48'>Volley-Ball</option>
                    <option type='text' value='SUAPS_50'>Modern'Jazz</option>
                    <option type='text' value='SUAPS_51'>Gymnastique Sportive</option>
                    <option type='text' value='SUAPS_54'>Basket-Ball</option>
                    <option type='text' value='SUAPS_56'>Golf</option>
                    <option type='text' value='SUAPS_57'>Danse Contemporaine</option>
                    <option type='text' value='SUAPS_64'>Randonnée pédestre</option>
                    <option type='text' value='SUAPS_70'>Football</option>
                    <option type='text' value='SUAPS_71'>Handball</option>
                    <option type='text' value='SUAPS_73'>Stage danse - rythmons nos week-ends</option>
                    <option type='text' value='SUAPS_75'>Théâtre Impro</option>
                    <option type='text' value='SUAPS_76'>Kizomba Afro House - Semba</option>
                    <option type='text' value='SUAPS_80'>Bloc Escalade</option>
                    <option type='text' value='SUAPS_81'>YogaDanse</option>
                    <option type='text' value='SUAPS_82'>Marche nordique</option>
                    <option type='text' value='SUAPS_86'>Stage bien-être - détente à la BU</option>
                    <option type='text' value='SUAPS_87'>Aquaphobe</option>
                    <option type='text' value='SUAPS_88'>Stage padel tennis</option>
                    <option type='text' value='SUAPS_89'>Stage beach volley</option>
                    <option type='text' value='Trail'>Trail</option>
                    <option type='text' value='AtelierDanseCreation'>Danse Création Vidéo</option>
                    <option type='text' value='Breakdance'>Break dance</option>
                    <option type='text' value='Capoeira'>Capoeira</option>
                    <option type='text' value='ContactImprovisation'>Danse Contact</option>
                    <option type='text' value='Courseapied'>Course à pied</option>
                    <option type='text' value='DanseAfricaine'>Danse Africaine</option>
                    <option type='text' value='DanseIndienne'>Danse Indienne</option>
                    <option type='text' value='Danseorientale'>Danse orientale</option>
                    <option type='text' value='DanseRocknRoll'>Rock n' Roll</option>
                    <option type='text' value='DanseTahitienne'>Danse Tahitienne</option>
                    <option type='text' value='Fitnessavecmachines'>Fitness avec machines</option>
                    <option type='text' value='HipHop'>Hip Hop</option>
                    <option type='text' value='IntervalTraining'>Interval Training</option>
                    <option type='text' value='KravMaga'>Krav Maga</option>
                    <option type='text' value='Lesgrandsevenements:SoireeBien-Etre'>Les grands évènements : Soirée Bien-Être</option>
                    <option type='text' value='LindyHop'>Lindy Hop</option>
                    <option type='text' value='MultisportsHandi-Valides'>Multisports Handi-Valides</option>
                    <option type='text' value='Nuitssportivesetevenements'>Les grands évènements</option>
                    <option type='text' value='OxygYinonsnosweekUends'>Stage bien-être - oxygénons nos week-ends</option>
                    <option type='text' value='Petanque'>Pétanque</option>
                    <option type='text' value='PETECA'>Pétéca</option>
                    <option type='text' value='Pratiquedouce'>Pratiques de Bien-Être</option>
                    <option type='text' value='PrYiparationmentale'>Préparation mentale</option>
                    <option type='text' value='RPM(RevolutionparMinute)'>Cardio Bike</option>
                    <option type='text' value='SportsLoisirDimanches'>Sport Loisir Week-End</option>
                    <option type='text' value='StreetJazz'>Street Jazz</option>
                </select>

                <br><br><br/><hr><br>

                <li class='active'><a><i class='bx bx-home'></i> <span>Votre Page = Parcours Etudiant</span></a></li>

                <br><br><br><br><br><br><br><br><hr>

                <li><a><i class='bx bx-user'></i> <span >Niveau de débug</span></a></li>
                <select name='niveau_debug' id='niv_debug'>
                    <option value='Off'>Debugg Off</option>
                    <option value='1'>Niveau 1</option>
                    <option value='2'>Niveau 2</option>
                    <option value='3' selected>Niveau 3</option>
                    <option value='4'>Niveau 4</option>
                    <option value='5'>Niveau 5</option>
                </select>
                <li><a><i class='bx bx-book-content'></i> Base de travail</a></li>
                <select name='base'  onChange='document.form2.submit()'>
                    <option value='tours'  ;>Base De Prod.</option>
                    <option alue='testtours' selected>Base de Test</option>
                </select>

            </ul>
        </nav>
    </div>
</header>

<!-- Fin menu de droite -->

<!-- Start space Script -->
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
<script>

"
?>
.

    $(function() {
        $('.navigation__icon').click(function() {
            $('.navigation').toggleClass('navigation-open');
        });
    });

    $(function () {
        $('#datepicker1').datepicker();
    });
    $(function () {
        $('#datepicker2').datepicker();
    });

.
<?php
echo "
?>
</script>
</script>
<!-- Fin space Script -->
</body>
</html>

"
?>