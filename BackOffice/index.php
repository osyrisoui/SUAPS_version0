<?php
# 01-06-2005 PG => mise en place de la gestion des centres et des droits
# 02-06-2005 PG => modif de l'adresse de redirection si on ne récupère pas les var de session
# 06-06-2005 PG => Passage de l'offre de formation en variable de session 
# 23-06-2005 PG => Enlevé le test sur la variable d'environnement adminuel => vérif faite dans la base
# 25-08-2005 PG => Affiche l'année et le semestre de l'offre courante, sinon l'année et le semestre selon la date 
# 01-09-2005 PG => utf8_decode du displayname

session_start();
$first_CAS = "";
if (!isset ($_SESSION["nocas"])) {
    // ici je dois faire du cas (on n'est paps passé par index_nocas.php)
    # 25-11-2008 PG => ne fait du cas que au premier tour
    if (!isset ($_SESSION["casuid"])) {
        // si la variable casuid n'est pas initialisée
        #require_once "../utils/auth_cas.php";
        include dirname(__DIR__) . "/utils/auth_cas.php";
        $CasUid = phpCAS::getUser();
        $_SESSION["casuid"] = $CasUid;
        $first_CAS = "oui";
        //echo "<h1>CAS</h1>";
    } else {
        //$CasUid =$_SESSION[casuid];
        //echo "<h1>$CasUid lu en session</h1>";
    }
} else {
    //echo "<h1>auth LDAP</h1>";
}
# 12/05/2020 PG => utilisation de __DIR__
require(dirname(__DIR__) . "/utils/variables_globales.php");
include dirname(__DIR__) . "/utils/outils_apogee.php";
include dirname(__DIR__) . "/utils/outils_bd.php";
include dirname(__DIR__) . "/utils/outils_ldap.php";
include dirname(__DIR__) . "/utils/outils_xhtml.php";
include dirname(__DIR__) . "/utils/outils_mail.php";
include dirname(__DIR__) . "/utils/outils_bd_BackOffice.php";
require(dirname(__DIR__) . "/utils/class.php");
# 12-11-2009 PG ouverture syslog
opensyslog();
if (isset($_SESSION["casuid"])) {
    @syslog(LOG_WARNING, "Connexion BO : " . $_SESSION["casuid"]);
}


#
#  init variables
#
$selecteddebug_1 = $selecteddebug_2 = $selecteddebug_3 = $selecteddebug_4 = $selecteddebug_5 = "";
$selectedtours = $selectedtesttours = "";
$Offres = array();
$id_offre = "";
$bouton_html_historique = "";

###########
##  Recup des variables
##########
foreach ($_POST as $VARName => $VARVal) {
    #echo "variables trouvées : $VARName => $VARVal<br>";
    $TabChaine = explode("_", $VARName);
    $variable = array_shift($TabChaine);
    $x = array_pop($TabChaine);
    $valeur = implode(" ", $TabChaine);
    if ($x == "x") {
        $$variable = $valeur;
        debug("création de la variable :$variable : " . $$variable, 5);
    }
}

# 18-06-2008 PG => gestion de la variable de session historique
#
#  id_offre
#
if (isset($Historique)) {
    $_SESSION ["Historique"] = $Historique;
}

if (isset($_POST["id_offre"])) {
    if (!isset($_SESSION["id_offre"])) {
        $_SESSION["id_offre"] = $_POST["id_offre"];
        debug("creation de id offre en session: " . $_SESSION["id_offre"], 5);
    } else {
        if ($_SESSION["id_offre"] != $_POST["id_offre"]) {
            $_SESSION["id_offre"] = $_POST["id_offre"];
            debug("reecriture de id offre S: " . $_SESSION["id_offre"] . " P : " . $_POST["id_offre"], 5);
        }
    }
}
# init de la variable locale
if (isset($_SESSION["id_offre"])) {
    $id_offre = $_SESSION["id_offre"];
}

#
#  id_activite
#
$id_activite = "";
if (isset ($_POST["id_activite"])) {
    if (isset($_SESSION['id_activite'])) {
        if ($_POST["id_activite"] != $_SESSION["id_activite"]) {
            $_SESSION["id_activite"] = $_POST["id_activite"];
            debug("reecriture de id activite S: " . $_SESSION["id_activite"] . " P : " . $_POST["id_activite"], 1);
        }
    } else {
        $_SESSION["id_activite"] = $_POST["id_activite"];
    }
}
# init de la variable locale
if (isset ($_SESSION["id_activite"])) {
    $id_activite = $_SESSION["id_activite"];
}

###########################################
#   FONCTIONS SPECIFIQUES DE LA PAGE
###########################################

function IncludeContenuPageBO($FichierPage)
{
    // IncludeContenuPageBO("PagesBackOffice/$page->contenu");
    // Inclusion de la page
    if (include("PagesBackOffice/$FichierPage->contenu")) {
        debug("chargement du contenu de la page", 5);
        debug("fichier de la page : ", 5);
        debug($FichierPage->contenu, 5);
    } else {
        debug("pas de contenu : chargement de l'accueil", 'syslog');
        include("PagesBackOffice/BackOfficeAccueil.php");
    }
}

###########################################
#             MAIN                  
###########################################

###
#  Debuggage
########
debug("_POST", 1);
debug($_POST, 1);
debug("_GET", 1);
debug($_GET, 1);
debug("_SESSION", 1);
debug($_SESSION, 1);

## selection du centre
selection_Centre();

#
# choix de la base mysql
#
if (isset($_POST["base"])) {
    #echo "changement de base: $base<br>";
    $_SESSION["base"] = $_POST["base"];
    $base = $_SESSION["base"];
} elseif (isset ($_SESSION["base"])) {
    $base = $_SESSION["base"];
} else {
    # 12/11/2009 PG => on force la base de test avec le code de test
    if (preg_match("/test/i", $_SERVER["HTTP_HOST"])) {
        $base = "testtours";
    } else {
        $base = "tours";
    }
    $_SESSION["base"] = $base;
}
# Choix du style de la balise body pour l'image de fond
if ($base=="tours") {
    $selectedtours = "selected";
    $bodyClass = "";
} else {
    $selectedtesttours = "selected";
    $bodyClass = "class='test'";
}

#
# connexion a la base mysql
#
bd_connect_mysql($base);

# 25-11-2008 PG => ne fait du cas que au premier tour
#if ( ($_POST["login"] && $_POST["passwd"]) || $_SESSION[casuid] ) {
if ((isset($_POST["login"]) && isset($_POST["passwd"])) || $first_CAS == "oui") {
###
# CONNEXION ET MISE EN SESSION UNIQUEMENT AU PREMIER PASSAGE
###       
    if ($first_CAS == "oui") {
        $login = $_SESSION["casuid"];
    } else {
        $login = $_POST["login"];
        # 29/05/2020 PG => uniquement si on est pas passé par CAS
        #
        # authentification sur l'annuaire ldap
        #
        connexionUtilisateur($login, $_POST["passwd"]);
    }
    #
    # authentification sur ldap ou récupération d'attributs ldap après récup uid cas
    # TODO 12/06/2020 ne faire ça que si on ne vient pas de CAS
    $mdp = "";
    # si on vient de index_nocas.php alors on fait du bind ldap sinon on netransmet que le login
    if (isset($_POST["passwd"])) $mdp = $_POST['passwd'];
    connexionUtilisateur($login, $mdp);

    # on peut passer des arguments par get sur le front office (pour se mettre à la place des étudiants)
# 27-06-2006 PG => mis $_SESSION[getOK] pour eviter le register global (permet de passer sur le FO depuis le BO
    $_SESSION["getOK"] = "oui";
#	session_register("getOK");
}

#if ($_SESSION[login] && $_SESSION[mdp] && $_SESSION[adminuel]) {
if ((isset($_SESSION["login"]) && isset($_SESSION["mdp"])) || isset($_SESSION["casuid"])) {
###
# SI ON EST CONNECTE passage N+1  ou CAS
###       	

# 14-09-2007 PG => modif pour se passer de index.php après le CAS
## Si le centre existe en post et que l'on est SA on le prend sinon on prend la variable de session, si elle n'est pas OK on regarde l'url
    if (isset($_POST["centre"]) && isset($_SESSION["profil"])) {
        if (PouvoirIsSA($_SESSION["profil"])) {
            #echo "recup du centre dans la variable POST";
            $_SESSION["centre"] = $_POST["centre"];
            $_SESSION["centrealt"] = $_POST["centre"];
        }
    } elseif (isset($_SESSION["centrealt"])) {
        #echo "recup du centre dans la variable SESSION centre alternatif";
        $_SESSION["centre"] = $_SESSION["centrealt"];
    } else {
        #echo "recup du centre dans l'url $_SESSION[centre]";
        if (preg_match("/suaps/i", $_SERVER["HTTP_HOST"])) $_SESSION["centre"] = "SUAPS";
        if (preg_match("/uel/i", $_SERVER["HTTP_HOST"])) $_SESSION["centre"] = "SEVE";
    }

#
#  choix de la css
######

    $cssfile = "style/" . select_CentreGestionCSS($_SESSION["centre"]);

################ Selection du Niveau de DEBUG #############
# 23-05-2006 PG => correction pour register_globals=off
# si le niveau de debug passe est différent de celui en session
    if (isset($_POST["debug_level"])) {
        if (isset($_SESSION["debug_level"])) {
            if ($_POST["debug_level"] != $_SESSION["debug_level"]) {
                $_SESSION["debug_level"] = $_POST["debug_level"];
            }
        } else {
            $_SESSION["debug_level"] = $_POST["debug_level"];
        }
    }
    if (isset ($_SESSION["debug_level"])) {
        # on récupère le niveau de debug dans la variable de session
        $debug_level = $_SESSION["debug_level"];
        $varname = "selecteddebug_$debug_level";
        $$varname = "selected";
        #echo "$varname =>  ".$$varname."<br>";
    }
# 28/05/2020 PG Ajout isset
    if (isset($_SESSION["profil"])) {
        if (PouvoirIsSA($_SESSION["profil"])) {
            $celluledebug = "
                 <select name=\"debug_level\"  onChange=\"document.form2.submit()\">
                    <option value=\"off\" >debug off</option>
                    <option value=\"1\" $selecteddebug_1>niveau 1</option>
                    <option value=\"2\" $selecteddebug_2>niveau 2</option>
                    <option value=\"3\" $selecteddebug_3>niveau 3</option>
                    <option value=\"4\" $selecteddebug_4>niveau 4</option>
                    <option value=\"5\" $selecteddebug_5>niveau 5</option>
                  </select>
    ";
        }
    }
################ fin DEBUG #############

################ choix centre #############
# 28/05/2020 PG Ajout isset
    if (isset($_SESSION["profil"])) {
        if (PouvoirIsSA($_SESSION["profil"])) {
            $AfficheCentreHTML = ListeDeroulantePG("centre", selectCentres(), $_SESSION["centre"], "OnChange=\"this.form.submit()\"");
        } else {
            $AfficheCentreHTML = "";
        }
    }
################ fin choix centre #############

################ Choix de la base de données ######
# 28 jan 2009 PG => demo
    if ($_SESSION["login"] == "testsuaps") {
        $SelectBase = ChampFormulaire('hidden', 'base', 'demo', '');
    } else {
        $SelectBase = $AfficheCentreHTML
            . "<select name=\"base\"  onChange=\"document.form2.submit()\">"
            . "<option value=\"tours\"  $selectedtours;>Base De Prod.</option>"
            . "<option value=\"testtours\" $selectedtesttours>Base De test</option>"
            . "</select>"
            . $celluledebug;
    }
################ fin Choix de la base ######

################ Offres de formations ###########
# 18-06-2008 PG => historique
# gestion de l'historique des offres de formation

    if (isset ($_SESSION["Historique"])) {
        if ($_SESSION["Historique"] == "on") {
            $bouton_html_historique = BoutonImage("Historique", "off", "images/history_clear.png", "16", "Desactiver Historique", "");
            $Offres = selectAlloffres();
        }
    } else {
        $bouton_html_historique = BoutonImage("Historique", "on", "images/history.png", "16", "Activer Historique", "");
        $Offres = selectAlloffres(CalculAnneeScolaire());
    }
# on ajoute une ligne en début de liste
    array_unshift($Offres, array("-", "------------------------"));
################  fin Offres ###########

############### Calcul du semestre de l'offre ##########
    if (isset ($_SESSION["id_offre"])) {
        if (CalculSemestre($_SESSION["id_offre"]) == "S1") {
            $infoSemestre = CalculAnneeScolaire($_SESSION["id_offre"]) . "<br>Semestre 1";
        }
        if (CalculSemestre($_SESSION["id_offre"]) == "S2") {
            $infoSemestre = CalculAnneeScolaire($_SESSION["id_offre"]) . "<br>Semestre 2";
        }
    } else {
        $infoSemestre ="" ;
    }
############### fin calcul du semestre  ##########

################ debut choix activite #############
    $Activites = array();
# si l'offre est choisie on cherche les activités lies aux cours de l'offre
    if ($id_offre) {
        $Activites = selectActiviteAvecOffre($id_activite, $id_offre);
    }
# on ajoute une ligne en début de liste
    array_unshift($Activites, array("-", "------------------------"));
# 08-09-2005 PG => affiche "toutes les activités pour les droits de type A ou SA SPORT
# 28/05/2020 PG Ajout isset
    if (isset($_SESSION["profil"])) {
        if (PouvoirIsA($_SESSION["profil"])) {
            array_unshift($Activites, array("toutes", "Toutes les " . $GLOBALS["config"]["libelles"]["UEnames"][$_SESSION["centre"]]));
            array_unshift($Activites, array("-", "------------------------"));
        }
    }
################ fin choix activite #############

###### Calcul du bloc html des listes déroulantes offres et activités ####
    $celluleoffres_activite = BlocCentre(
        tableau("sansbordure", "", "",
            ligne("",
                affichecellule("",
                    tableau("", "", "",
                        ligne("",
                            affichecellule("",
                                ListeDeroulanteTitre('id_offre', $Offres, $id_offre, "Choisissez une Offre de Formation", "OnChange=\"this.form.submit()\"", 'non'))
                            . affichecellule("", $bouton_html_historique)
                        )
                    )
                ) .
                affichecellule("",
                    tableau("", "", "",
                        ligne("",
                            affichecellule("",
                                ListeDeroulanteTitre('id_activite', $Activites, $id_activite, "Choisissez une " . $GLOBALS["config"]["libelles"]["UEname"][$_SESSION["centre"]], "OnChange=\"this.form.submit()\"", 'non'))
                        )
                    #)
                    )
                )
            )
        )
    );
###################################
####
####      Page Cible
####
###################################
## Si la cible existe en post on la prend sinon on prend la variable en get
    if (isset($_POST["cible"])) {
        if ($_POST["cible"] != $_SESSION["cible"]) {
            $cible = $_POST["cible"];
            $_SESSION["cible"] = $_POST["cible"];
        }
    } elseif (isset($_GET["cible"])) {
        $cible = $_GET["cible"];
        $_SESSION["cible"] = $_GET["cible"];
    }

    if (isset($_SESSION["cible"])) {
        $cible = $_SESSION["cible"];
    } else {
        $cible = "";
    }

### chargment de l'objet page
#    Recheche en base (table pages)
    $page = new Page($cible);
#    $this->lib_page = $row['lib_page'];
#    $this->titre = $row['titre'];
#    $this->contenu = $row['contenu'];
#    $this->infoBulle = $row['infoBulle'];
#    $this->num_page = $row['num_page'];

    if (isset($page->titre)) {
        $titrePage = $page->titre;
        $BoutonAidePage = BoutonAide($page->titre);
    } else {
        $titrePage = "";
        $BoutonAidePage = "";
    }

    if (isset($_SESSION["cible"])) {
        $infoImprimante = "	<td>
            <a href=\"#?cible=" . $_SESSION["cible"] . "\" onClick=\"window.print()\"> <img width=\"40\" src=\"/BackOffice/images/imprimante.gif\" border=\"0\"> </a>
            </td>
        ";
    } else {
        $infoImprimante = "";
    }
    if (isset($page->titre)) syslog(LOG_WARNING, infosyslog() . "-" . $_SESSION["DisplayName"] . " -" . removeaccents($page->titre));

#### Footer
# 02-07-2008 PG => affichage du nom de noeud
    if (isset ($GLOBALS["config"]["nomNoeud"][$_SERVER["SERVER_ADDR"]])) {
        $divFooter = "
         <div id=\"footer\"> <span>" . $GLOBALS["config"]["nomNoeud"][$_SERVER["SERVER_ADDR"]] . "</span>
         </div>
         ";
    } else {
        $divFooter = "";
    }

##
#
# Affichage du code html  #
#
##

    echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
        'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
    <title> " . $page->titre . " </title>
    
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>
    <link rel='stylesheet' href='$cssfile'>
    <script language='JavaScript' type='text/javaScript' src='style/javascript.js'></script>
    <script type='text/javascript' src='calendrier_js/calendarDateInput.js'></script>

    <link rel='stylesheet' href='/BackOffice/jquery/jquery-ui.css'/>
    <script src='/BackOffice/jquery/jquery-1.8.3.js'></script>
    <script src='/BackOffice/jquery/jquery-ui.js'></script>
    <script src='/BackOffice/jquery/jquery-ui.datepicker-fr.js'></script>
    <script>
        $(function () {
            $('#datepicker1').datepicker();
        });
        $(function () {
            $('#datepicker2').datepicker();
        });
    </script>
    <script src='style/postMessage-resize-iframe-in-parent.js' type='text/javascript'></script>
</head>

<body $bodyClass>
<div id='container'>
    <div id='content'>
        <table width='100%' border='0' cellspacing='0' cellpadding='3' class='sansbordure'>
            <form name='form2' method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                <tr>
                    <td align='center' class='title'
                        cellpadding='2'> $titrePage 
                        &nbsp; $BoutonAidePage </td>
                    <td style='margin:0;padding:0;'> $celluleoffres_activite </td>
                    <td width='10%' align='center' class='titre'>
                        $infoSemestre
                    </td>
                    $infoImprimante
                    <td width='320' align='right' style='margin:0;padding:0;'>
                        <table class='sansbordure'>
                            <tr>
                                <td align='right' style='margin:0;padding:0;'>
                                    <div id='transparency'>Bonjour" . $_SESSION["DisplayName"] . " &nbsp;&nbsp;
                                       <a href='destroy_session_cas_BO.php'> 
                                       <img align='top' src='/images/exit.gif' width='18' border='0'></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align='right'> $SelectBase</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </form>
            <tr>
                <td align='center' colspan='6' style='margin:0;padding:0;'>" . FaitMenuNEW($cible) . "</td>
            </tr>
            <tr>
                <td align='center' colspan='6'>
                ";
                if (!include("PagesBackOffice/$page->contenu")) {
                    debug("pas de contenu : chargement de l'accueil", 'syslog');
                    include("PagesBackOffice/BackOfficeAccueil.php");
                } else {
                    debug("chargement du contenu de la page", 5);
                }

                # 20-06-2008 PG => affichage des erreurs
                if (isset($_SESSION["error"])) {
                    $divError = "
                            <div id='alert'> 
                                <span>" . $_SESSION["error"] . "</span>
                            </div>
                        ";
                    unset ($_SESSION["error"]);
                } else {
                    $divError = "";
                }
    echo "
                </td>
            </tr>
        </table>
        <!--  Div Erreur -->
        $divError
        <!--  fin de la div de contenu de la page -->
        </div>
        $divFooter 
        <!-- fin du container de la page -->
        </div>  
        </body>
    </html>
    ";
} else {
    # On redirige vesr la page d'acceuil si les variables des sessions ne sont pas récupérées
    echo "
                <html>
                <head>
                <META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=/BackOffice/\">
                </head>
                <body>
                </body>
                </html>
        ";
}
