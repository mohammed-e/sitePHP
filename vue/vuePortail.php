<?php $this->titre = 'Portail';

if(isset($_SESSION['user'])):
    $user = unserialize($_SESSION['user']);
endif;

if(isset($_SESSION['droit'])):
    $droit = unserialize($_SESSION['droit']);
endif;

?>

<h3 id="grosTitre">Mon Portail</h3>


<div class="container text-xs-center">
    <div class="row m-5">
        <div class="col-lg-4 text-center p-3">
        </div>

        <div class="col-lg-4 text-center p-3">
        </div>

        <div class="col-lg-4 text-center p-3">
        </div>
    </div>

    <div class="row m-5">
        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte()):
                echo '<a href="https://extranet.amue.fr" class="btn btn-squared-default">';
                    echo '<i class="fas fa-share-square fa-3x"></i>';
                    echo 'Extranet AMUE';
                echo '</a>';
            endif;
            ?>
        </div>

        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte() && isset($droit) && $droit->getEditionInfos()):
                echo '<a href="?action=editerInfos" class="btn btn-squared-default">';
                    echo '<i class="fas fa-edit fa-3x"></i>';
                    echo 'Éditer informations et actualités';
                echo '</a>';
            endif;
            ?>
        </div>

        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte()):
                echo '<a href="?action=modifierProfil" class="btn btn-squared-default">';
                    echo '<i class="fas fa-cog fa-3x"></i>';
                    echo ' Modifier profil';
                echo '</a>';
            endif;
            ?>
        </div>
    </div>

    <div class="row m-5">
        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte() && isset($droit) && $droit->getValidationInscriptions()):
                echo '<a href="?action=validerInscriptions" class="btn btn-squared-default">';
                    echo '<i class="fas fa-user-check fa-3x"></i>';
                    echo 'Valider inscriptions';
                echo '</a>';
            endif;
            ?>
        </div>

        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte() && isset($droit) && $droit->getValidationInscriptions()):
                echo '<a href="?action=validerExportations" class="btn btn-squared-default">';
                    echo '<i class="fas fa-file-export fa-3x"></i>';
                    echo ' Valider exportations';
                echo '</a>';
            endif;
            ?>
        </div>

        <div class="col-lg-4 text-center p-3">
            <?php
            if(isset($user) && $user->getConnecte() && isset($droit) && $droit->getModificationDroits()):
                echo '<a href="?action=adminUtilisateurs" class="btn btn-squared-default">';
                    echo '<i class="fas fa-user-friends fa-3x"></i>';
                    echo ' Administrer utilisateurs';
                echo '</a>';
            endif;
            ?>
        </div>
    </div>
</div>
