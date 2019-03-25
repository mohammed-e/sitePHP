<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Information.php';
use INFO2\CAPANR\Information;
require_once __DIR__.'/../modele/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;
require_once __DIR__.'/../modele/Etablissement.php';
use INFO2\CAPANR\Etablissement;
require_once __DIR__.'/../modele/Droit.php';
use INFO2\CAPANR\Droit;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../lib/phpMailer/vendor/autoload.php';



class ControleurAdhesion {

    private $info;
    private $user;
    private $etab;
    private $droit;

    public function __construct() {
        $this->info = new Information();
        $this->etab = new Etablissement("init");
        $this->droit = new Droit("0000000");
        $this->user = new Utilisateur("test@init.com");
    }

    // Affiche la liste de tous les infos de la rubrique Nous rejoindre
    public function adhesion() {
        $infos = $this->info->getInfosAdhesion();
        $etabs = $this->etab->getEtablissements();
        $vue = new Vue("Adhesion");
        $vue->generer(array('infos' => $infos, 'etabs' => $etabs));
    }


    public function formAdhesion() {
        /* On récupère et nettoie les champs de l'utilisateur */
        $nom = trim($_POST['nom']);
        $nom = htmlspecialchars($nom);
        $prenom = trim($_POST['prenom']);
        $prenom = htmlspecialchars($prenom);
        $email = trim($_POST['mail']);
        $email = htmlspecialchars($email);
        $mdp = trim($_POST['mdp']);
        $mdp = htmlspecialchars($mdp);
        $confMdp = trim($_POST['confMdp']);
        $confMdp = htmlspecialchars($confMdp);
        $tel = trim($_POST['tel']);
        $tel = htmlspecialchars($tel);
        $fonction = trim($_POST['fonction']);
        $fonction = htmlspecialchars($fonction);
        if(isset($_POST['etablissement'])) {
            $etablissement = trim($_POST['etablissement']);
            $etablissement = htmlspecialchars($etablissement);
        }
        $service = trim($_POST['service']);
        $service = htmlspecialchars($service);

        $mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        if(!($mdp === $confMdp)) {
            echo '<script type="text/javascript">window.alert("Les mots de passe saisis ne sont pas identiques");</script>';
            $this->adhesion();
            exit();
        }


        /* On vérifie que le mail n'est pas déjà utilisé */
        $userData = $this->user->getUtilisateur($email);
        if($userData != null) {
            echo '<script type="text/javascript">window.alert("Le mail renseigné existe déjà");</script>';
        }
        else {

            $user = new Utilisateur($email);
            $user->setUtilisateur($nom, $prenom, $mdp_hache, $tel, $fonction, $service, false, false, false, false);

            $droit = $this->droit->getUnDroit("0000000");
            $droitDefaut = $entityManager->merge($droit);

            if(isset($_POST['nomEtab']) && isset($_POST['siret']) && isset($_POST['codePostal']) && isset($_POST['ville']) && isset($_POST['adresse'])):
                /* On récupère et nettoie les champs de l'etablissement */
                $nomEtab = trim($_POST['nomEtab']);
                $nomEtab = htmlspecialchars($nomEtab);
                $siret = trim($_POST['siret']);
                $siret = htmlspecialchars($siret);
                str_replace(" ", "", $siret);
                $codePostal = trim($_POST['codePostal']);
                $codePostal = htmlspecialchars($codePostal);
                $ville = trim($_POST['ville']);
                $ville = htmlspecialchars($ville);
                $adresse = trim($_POST['adresse']);
                $adresse = htmlspecialchars($adresse);

                /* On vérifie que l'etablissement n'existe pas déjà */
                $etabData = $this->etab->getUnEtablissement($nomEtab);
                if($etabData != null) {
                    echo '<script type="text/javascript">window.alert("L\'établissement renseigné existe déjà");</script>';
                }
                else {
                    $user->setReferent(true);
                    /* On crée le nouvel établissement */
                    $etab = new Etablissement($nomEtab);
                    $etab->setEtablissement($siret, $adresse, $codePostal, $ville);
                    $etab->ajouterMembres($user);

                    $etablissement = $nomEtab; // Pour le mail

                    $droitDefaut->ajouterAyantDroit($user);

                    $entityManager->persist($etab);
                    $entityManager->flush();
                }

            else:
                $etab = $this->etab->getUnEtablissement($etablissement);
                $etabExiste = $entityManager->merge($etab);

                $etabExiste->ajouterMembres($user);
                $droitDefaut->ajouterAyantDroit($user);

                $entityManager->flush();
            endif;


            /* On récupère les destinataires */
            $users = $this->user->getAdminValidation();
            foreach ($users as $destinataire) {
                $to = $destinataire->getMail();

                /* On envoie le mail */
                $mail = new PHPMailer(true);
                // $mail->SMTPDebug = 4;
                // $mail->Debugoutput = 'html';
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                try {
                   /* SMTP parameters. */
                   $mail->isSMTP();
                   $mail->isSendMail();
                   $mail->Host = 'smtp.gmail.com';
                   $mail->SMTPAuth = true;
                   $mail->SMTPSecure = 'ssl';
                   $mail->Username = 'contact.capanr@gmail.com';
                   $mail->Password = 'Nobrouj:1A';
                   $mail->Port = 465;

                   /* Disable some SSL checks. */
                   // $mail->SMTPOptions = array(
                   //    'ssl' => array(
                   //    'verify_peer' => false,
                   //    'verify_peer_name' => false,
                   //    'allow_self_signed' => true
                   //    )
                   // );

                   $mail->setFrom('contact.capanr@gmail.com', 'Adhésion CAP ANR');
                   $mail->addAddress($to);
                   $mail->Subject = "Demande d'adhésion site CAP ANR";
                   $mail->Body = "Vous venez de recevoir une demande d'adhésion de la part d'un visiteur du site CAP ANR.\n\n- Informations -\n\nNom : ".$nom."\nPrénom : ".$prenom."\nAdresse mail : ".$email."\nÉtablissement : ".$etablissement."\nService : ".$service."\nFonction : ".$fonction."\n\n- Procédure à suivre -\n\n1) Rendez-vous sur le site du réseau CAP ANR puis connectez-vous.\n2) Cliquez sur 'Valider inscriptions' dans 'Mon portail'.\n3) Cherchez l'utilisateur en question dans la liste qui apparaît puis validez-le si souhaité.\n4) Si vous validez l'utilisateur, rendez-vous sur l'extranet de l'AMUE et procédez à son exportation manuel. Cliquez sur 'Valider exportations' dans 'Mon portail' pour consulter la liste de tous les utilisateurs en attente. N'oubliez pas de les supprimer de la liste une fois exportés.\n\n\n-NB-\n\nSi cet utilisateur nécessite la création d'un compte spécifique pour se connecter à l'extranet de l'AMUE, veuillez utilisez le même mot de passe qu'il a renseigné pour le site CAP ANR : ".$mdp;


                   // $mail->Body = '<html>
                   //
                   //                </html>';
                   // $mail->AltBody = "Vous venez de recevoir une demande de contact d'un visiteur du site CAP ANR.\n\n- Informations -\n\nNom : ".$nom."\nPrénom : ".$prenom."\nAdresse mail : ".$email."\n\n- Demande -\n\nSujet : ".$sujet."\n\n".$message;

                   /* Finally send the mail. */
                   $mail->send();
                }
                catch (Exception $e)
                {
                   echo $e->errorMessage();
                }
                catch (\Exception $e)
                {
                   echo $e->getMessage();
                }

            }

            echo '<script type="text/javascript">window.alert("Votre demande a bien été envoyée");</script>';
        }

        $this->adhesion();
    }
}
