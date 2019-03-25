<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/ControleurAccueil.php';
require_once __DIR__.'/ControleurAdhesion.php';
require_once __DIR__.'/ControleurActualite.php';
require_once __DIR__.'/ControleurAnnuaire.php';
require_once __DIR__.'/ControleurContact.php';
require_once __DIR__.'/ControleurPortail.php';
require_once __DIR__.'/ControleurConnexion.php';
require_once __DIR__.'/../modele/Vue.php';

use INFO2\CAPANR\ControleurAccueil;
use INFO2\CAPANR\ControleurAdhesion;
use INFO2\CAPANR\ControleurActualite;
use INFO2\CAPANR\ControleurAnnuaire;
use INFO2\CAPANR\ControleurContact;
use INFO2\CAPANR\ControleurPortail;
use INFO2\CAPANR\ControleurConnexion;
use INFO2\CAPANR\Vue;


class Routeur {

    public $ctrlAccueil;
    public $ctrlAdhesion;
    public $ctrlActualite;
    public $ctrlAnnuaire;
    public $ctrlContact;
    public $ctrlPortail;
    public $ctrlConnexion;

    public function __construct() {
        $this->ctrlAccueil = new ControleurAccueil();
        $this->ctrlAdhesion = new ControleurAdhesion();
        $this->ctrlActualite = new ControleurActualite();
        $this->ctrlAnnuaire = new ControleurAnnuaire();
        $this->ctrlContact = new ControleurContact();
        $this->ctrlPortail = new ControleurPortail();
        $this->ctrlConnexion = new ControleurConnexion();
    }

    // Traite une requête entrante
    public function routerRequete() {
        try {
            if(isset($_SESSION['user'])):
                $user = unserialize($_SESSION['user']);
            endif;
            if(isset($_SESSION['droit'])):
                $droit = unserialize($_SESSION['droit']);
            endif;

            if(isset($_GET['action'])):
                $actionPage = htmlspecialchars($_GET['action']);

                if($actionPage == 'adhesion'):
                    $this->ctrlAdhesion->adhesion();
                elseif($actionPage == 'formAdhesion'):
                    $this->ctrlAdhesion->formAdhesion();

                elseif($actionPage == 'actualite'):
                    $this->ctrlActualite->actualite();
                elseif($actionPage == 'actuDetail'):
                    $this->ctrlActualite->actuDetail($_GET['id']);

                elseif($actionPage == 'annuaire'):
                    $this->ctrlAnnuaire->annuaire();
                elseif($actionPage == 'importerExcel'):
                    $this->ctrlAnnuaire->importerExcel();
                elseif($actionPage == 'formAnnuaire'):
                    if(isset($_GET['nomPage'])):
                        $this->ctrlAnnuaire->formAnnuaire($this, $_GET['nomPage']);
                    else:
                        $this->ctrlAnnuaire->formAnnuaire($this);
                    endif;

                elseif($actionPage == 'contact'):
                    $this->ctrlContact->contact();
                elseif($actionPage == 'formContact'):
                    $this->ctrlContact->formContact();


                elseif($actionPage == 'portail' && isset($user) && $user->getConnecte()):
                    $this->ctrlPortail->portail();

                elseif($actionPage == 'modifierProfil' && isset($user) && $user->getConnecte()):
                    $this->ctrlPortail->modifierProfil();
                elseif($actionPage == 'enregistrerProfil' && isset($user) && $user->getConnecte()):
                    $this->ctrlPortail->enregistrerProfil();
                elseif($actionPage == 'supprimerCompte' && isset($user) && $user->getConnecte()):
                    $this->ctrlPortail->supprimerCompte($this);

                elseif($actionPage == 'validerInscriptions' && isset($user) && $user->getConnecte() && $droit->getValidationInscriptions()):
                    $this->ctrlPortail->validerInscriptions();
                elseif($actionPage == 'validerOk' && isset($user) && $user->getConnecte() && $droit->getValidationInscriptions()):
                    $this->ctrlPortail->validerOk($_GET['mail']);
                elseif($actionPage == 'validerRefus' && isset($user) && $user->getConnecte() && $droit->getValidationInscriptions()):
                    $this->ctrlPortail->validerRefus($_GET['mail']);

                elseif($actionPage == 'validerExportations' && isset($user) && $user->getConnecte() && $droit->getValidationInscriptions()):
                    $this->ctrlPortail->validerExportations();
                elseif($actionPage == 'validerExp' && isset($user) && $user->getConnecte() && $droit->getValidationInscriptions()):
                    $this->ctrlPortail->validerExp($_GET['mail']);

                elseif($actionPage == 'editerInfos' && isset($user) && $user->getConnecte() && $droit->getEditionInfos()):
                    $this->ctrlPortail->editerInfos();

                elseif($actionPage == 'adminUtilisateurs' && isset($user) && $user->getConnecte() && $droit->getModificationDroits()):
                    $this->ctrlPortail->adminUtilisateurs();
                elseif($actionPage == 'modifierDroitsUtilisateur' && isset($user) && $user->getConnecte() && $droit->getModificationDroits()):
                    $this->ctrlPortail->modifierDroitsUtilisateur($_GET['mail']);
                elseif($actionPage == 'supprimerUtilisateur' && isset($user) && $user->getConnecte() && $droit->getSuppressionUtilisateurs()):
                    $this->ctrlPortail->supprimerUtilisateur($_GET['mail']);

                elseif($actionPage == 'formConnexion'):
                    $this->ctrlConnexion->formConnexion($this);
                elseif($actionPage == 'deconnexion' && isset($user) && $user->getConnecte()):
                    $this->ctrlConnexion->deconnexion($this);

                else:
                    throw new \Exception("Action non valide");
                endif;
            else:
                $this->ctrlAccueil->accueil();
            endif;
        }
        catch (\Throwable $err) {
            $this->erreur($err);
        }
    }

    // Affiche une erreur
    public function erreur($err = null) {
        $vue = new Vue("Erreur");

        if($err != null) {
            $errMsg = $err->getMessage();
            $errFile = ' - file '.$err->getFile();
            $errLine = ' at line '.$err->getLine();
            $msgErreur = $errMsg.$errFile.$errLine ;

            $vue->generer(array('msgErreur' => $msgErreur));
        }
    }
}
