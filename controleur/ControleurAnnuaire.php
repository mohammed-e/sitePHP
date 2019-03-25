<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;


class ControleurAnnuaire {

    private $user;
    private $etab;


    public function __construct() {
        $this->user = new Utilisateur("test@init.com");
        $this->etab = new Etablissement("init");
    }


    // Affiche la liste de tous les membres référents
    public function annuaire() {
        $users = $this->user->getUtilisateurs();
        $etabs = $this->etab->getEtablissements();

        $vue = new Vue("Annuaire");
        $vue->generer(array('users' => $users, 'etabs' => $etabs));
    }



    public function importerExcel() {

        // traitement pour importer le fichier baseUtilisateurs.csv dans la table utilisateurs


        $this->annuaire();
    }




    public function formAnnuaire($routeur, $nomPage = null) {

        /* Recherche dans les pages admin + validations */
        if(isset($_POST['referent'])):

            if(empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['etablissement']) && empty($_POST['service']) && empty($_POST['fonction']) && empty($_POST['mail']) && $_POST['referent'] == 'off'):
                if($nomPage == 'admin') {
                    $routeur->ctrlPortail->adminUtilisateurs();
                }
                elseif($nomPage == 'validerInsc') {
                    $routeur->ctrlPortail->validerInscriptions();
                }
                elseif($nomPage == 'validerExp') {
                    $routeur->ctrlPortail->validerExportations();
                }
                // inutile mais sécurité
                else {
                    $this->annuaire();
                }

            else:
                if(!empty($_POST['nom'])) {
                    $nom = trim($_POST['nom']);
                    $nom = htmlspecialchars($nom);
                    $array['nom'] = $nom;
                }

                if(!empty($_POST['prenom'])) {
                    $prenom = trim($_POST['prenom']);
                    $prenom = htmlspecialchars($prenom);
                    $array['prenom'] = $prenom;
                }

                if(!empty($_POST['etablissement'])) {
                    $etablissement = trim($_POST['etablissement']);
                    $etablissement = htmlspecialchars($etablissement);

                    $etabData = $this->etab->getUnEtablissement($etablissement);
                    $array['etablissement'] = $etabData->getId();
                }

                if(!empty($_POST['service'])) {
                    $service = trim($_POST['service']);
                    $service = htmlspecialchars($service);
                    $array['service'] = $service;
                }

                if(!empty($_POST['fonction'])) {
                    $fonction = trim($_POST['fonction']);
                    $fonction = htmlspecialchars($fonction);
                    $array['fonction'] = $fonction;
                }

                if(!empty($_POST['mail'])) {
                    $mail = trim($_POST['mail']);
                    $mail = htmlspecialchars($mail);
                    $array['mail'] = $mail;
                }

                if($_POST['referent'] == 'on') {
                    $array['referent'] = true;
                }


                $users = $this->user->getUtilisateursCond($array);
                $etabs = $this->etab->getEtablissements();


                if($nomPage == 'admin') {
                    $vue = new Vue("PortailAdminUtilisateurs");
                    $vue->generer(array('users' => $users, 'etabs' => $etabs));
                }
                elseif($nomPage == 'validerInsc') {
                    $vue = new Vue("PortailValiderInscriptions");
                    $vue->generer(array('users' => $users, 'etabs' => $etabs));
                }
                elseif($nomPage == 'validerExp') {
                    $vue = new Vue("PortailValiderExportations");
                    $vue->generer(array('users' => $users, 'etabs' => $etabs));
                }
                // inutile mais sécurité
                else {
                    $vue = new Vue("Annuaire");
                    $vue->generer(array('users' => $users, 'etabs' => $etabs));
                }

            endif;


        /* Recherche dans la page Annuaire */
        else:

            if(empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['etablissement']) && empty($_POST['service']) && empty($_POST['fonction']) && empty($_POST['mail'])):
                    $this->annuaire();


            else:

                if(!empty($_POST['nom'])) {
                    $nom = trim($_POST['nom']);
                    $nom = htmlspecialchars($nom);
                    $array['nom'] = $nom;
                }

                if(!empty($_POST['prenom'])) {
                    $prenom = trim($_POST['prenom']);
                    $prenom = htmlspecialchars($prenom);
                    $array['prenom'] = $prenom;
                }

                if(!empty($_POST['etablissement'])) {
                    $etablissement = trim($_POST['etablissement']);
                    $etablissement = htmlspecialchars($etablissement);

                    $etabData = $this->etab->getUnEtablissement($etablissement);
                    $array['etablissement'] = $etabData->getId();
                }

                if(!empty($_POST['service'])) {
                    $service = trim($_POST['service']);
                    $service = htmlspecialchars($service);
                    $array['service'] = $service;
                }

                if(!empty($_POST['fonction'])) {
                    $fonction = trim($_POST['fonction']);
                    $fonction = htmlspecialchars($fonction);
                    $array['fonction'] = $fonction;
                }

                if(!empty($_POST['mail'])) {
                    $mail = trim($_POST['mail']);
                    $mail = htmlspecialchars($mail);
                    $array['mail'] = $mail;
                }

                $users = $this->user->getUtilisateursCond($array);
                $etabs = $this->etab->getEtablissements();

                $vue = new Vue("Annuaire");
                $vue->generer(array('users' => $users, 'etabs' => $etabs));

                endif;

        endif;

    }

}
