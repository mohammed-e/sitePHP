<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;
require_once __DIR__.'/../modele/Droit.php';
use INFO2\CAPANR\Droit;
require_once __DIR__.'/../modele/Etablissement.php';
use INFO2\CAPANR\Etablissement;


class ControleurConnexion {

    private $user;
    private $droit;
    private $etab;


    public function __construct() {
        $this->user = new Utilisateur("test@init.com");
        $this->droit = new Droit("0000000");
        $this->etab = new Etablissement("init");
    }


    public function formConnexion($routeur) {
        $mail = trim($_POST['idMail']);
        $mail = htmlspecialchars($_POST['idMail']);
        $mdp = trim($_POST['mdp']);
        $mdp = htmlspecialchars($_POST['mdp']);

        $userData = $this->user->getUtilisateur($mail);


        if($userData == null || !$userData->getValide()) {
            echo '<script type="text/javascript">window.alert("L\'identifiant renseigné n\'existe pas");</script>';
        }
        else {
            // Comparaison du mdp envoyé via le formulaire avec celui la bdd
            $estCorrectMdp = password_verify($mdp, $userData->getMdp());

            if ($estCorrectMdp)
            {
                $userData->setConnecte(true);
                $userObj = serialize($userData);
                $_SESSION['user'] = $userObj;

                $droitData = $this->droit->getUnDroit($userData->getDroit()->getCodeDroit());
                $droitData->setCodeDroit($userData->getDroit()->getCodeDroit());
                $etabData = $this->etab->getUnEtablissement($userData->getEtablissement()->getNom());
                $etabData->setNom($userData->getEtablissement()->getNom());

                $droitObj = serialize($droitData);
                $_SESSION['droit'] = $droitObj;
                $etabObj = serialize($etabData);
                $_SESSION['etab'] = $etabObj;

                echo '<script type="text/javascript">window.alert("Bienvenue !");</script>';
            }
            else
            {
                echo '<script type="text/javascript">window.alert("Le mot de passe renseigné ne correspond pas");</script>';
            }
        }

        $routeur->ctrlAccueil->accueil();
    }


    public function deconnexion($routeur) {
        if(isset($_SESSION['user'])) {

            $_SESSION = array();
            session_destroy();

            echo '<script type="text/javascript">window.alert("À bientôt");</script>';
            $routeur->ctrlAccueil->accueil();
        }
    }

}
