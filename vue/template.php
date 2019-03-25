<?php
if(isset($_SESSION['user'])):
    $user = unserialize($_SESSION['user']);
endif;

if(isset($_SESSION['droit'])):
    $droit = unserialize($_SESSION['droit']);
endif;
?>

<html lang="fr">

    <head>
        <title><?php echo $titre ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="lib/bootstrap-4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/fontawesome-5.7.1/css/all.css">
        <link rel="stylesheet" type="text/css" href="public/css/template.css">
        <script src="lib/jquery-3.3.1.min.js"></script>
        <script src="lib/popper.min.js"></script>
        <script src="lib/bootstrap-4.2.1/js/bootstrap.min.js"></script>
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark">
                <a class="navbar-brand" href="index.php">
                    <img src="public/image/logoCAPANR.jpg" alt="CAPANR" id = "logo">
                </a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?action=actualite">Actualités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=annuaire">Annuaire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=adhesion#lienFormAdhesion">Nous rejoindre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?action=contact#lienFormContact">Nous contacter</a>
                        </li>

                        <li class="nav-item">
                        </li>

                        <li class="nav-item dropdown">
                            <?php
                            if(isset($user) && $user->getConnecte()):
                                echo '<a class="nav-link" data-toggle="dropdown disabled" href="?action=portail">Mon Portail</a>';
                                echo '<div class="dropdown-menu dropdown-menu-center">';
                                    echo '<a class="dropdown-item" href="https://extranet.amue.fr">Extranet AMUE</a>';
                                    if(isset($droit) && $droit->getValidationInscriptions()):
                                        echo '<a class="dropdown-item" href="?action=validerInscriptions">Valider inscriptions</a>';
                                    endif;
                                    if(isset($droit) && $droit->getValidationInscriptions()):
                                        echo '<a class="dropdown-item" href="?action=validerExportations">Valider exportations</a>';
                                    endif;
                                    if(isset($droit) && $droit->getModificationDroits()):
                                        echo '<a class="dropdown-item" href="?action=adminUtilisateurs">Administrer utilisateurs</a>';
                                    endif;
                                    if(isset($droit) && $droit->getEditionInfos()):
                                        echo '<a class="dropdown-item" href="?action=editerInfos">Éditer informations et actualités</a>';
                                    endif;
                                    echo '<a class="dropdown-item" href="?action=modifierProfil">Modifier profil</a>';
                                    echo '<div class="dropdown-divider"></div>';
                                    echo '<a class="dropdown-item" href="?action=deconnexion">Déconnexion</a>';
                                echo '</div>';
                            else:
                                echo '<a class="nav-link" href="#" data-toggle="modal" data-target="#login-modal">Connexion</a>';
                                require_once __DIR__.'/form/vueFormConnexion.php';
                            endif;
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                            if(isset($user) && $user->getConnecte()):
                                echo '<a class="nav-link" id="decoMobile" href="?action=deconnexion">Déconnexion</a>';
                            endif;
                            ?>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <?php echo $contenu ?>
    </body>

</html>
