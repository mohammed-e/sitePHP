<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;
require_once __DIR__.'/../modele/Etablissement.php';
use INFO2\CAPANR\Etablissement;

use Doctrine\Common\Collections\ArrayCollection;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../lib/phpMailer/vendor/autoload.php';


class ControleurPortail {

    private $user;
    private $etab;


    public function __construct() {
        $this->user = new Utilisateur("test@init.com");
        $this->etab = new Etablissement("init");
        $this->droit = new Droit("0000000");
    }


    public function portail() {
        $vue = new Vue("Portail");
        $vue->generer(null);
    }


    public function modifierProfil() {
        $vue = new Vue("PortailModifierProfil");

        if(isset($_SESSION['user'])):
            $user = unserialize($_SESSION['user']);
        endif;

        if(isset($_SESSION['etab'])):
            $etab = unserialize($_SESSION['etab']);
        endif;

        $vue->generer(array('user' => $user, 'etab' => $etab));
    }


    public function enregistrerProfil() {

        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        if(isset($_SESSION['user'])):
            $user = unserialize($_SESSION['user']);
        endif;

        if(isset($_SESSION['etab'])):
          $etab = unserialize($_SESSION['etab']);
        endif;

        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $user->getMail()]);

        $etabRepo = $entityManager->getRepository(Etablissement::class);
        $etabData = $etabRepo->findOneBy(["nom" => $etab->getNom()]);

        $etabSession = $this->etab->getUnEtablissement($userData->getEtablissement()->getNom());


        /* On récupère et nettoie les champs de l'utilisateur */
        $nom = trim($_POST['nom']);
        $nom = htmlspecialchars($nom);
        $prenom = trim($_POST['prenom']);
        $prenom = htmlspecialchars($prenom);
        $email = trim($_POST['mail']);
        $email = htmlspecialchars($email);
        if(isset($_POST['mdp'])) {
            $mdp = trim($_POST['mdp']);
            $mdp = htmlspecialchars($mdp);
            $mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);
        }
        if(isset($_POST['confMdp'])) {
            $confMdp = trim($_POST['confMdp']);
            $confMdp = htmlspecialchars($confMdp);
        }
        $tel = trim($_POST['tel']);
        $tel = htmlspecialchars($tel);
        $fonction = trim($_POST['fonction']);
        $fonction = htmlspecialchars($fonction);
        $service = trim($_POST['service']);
        $service = htmlspecialchars($service);

        $userData->setMail($email);
        $userData->setNom($nom);
        $userData->setPrenom($prenom);
        $userData->setTelephone($tel);
        $userData->setFonction($fonction);
        $userData->setService($service);

        if(!empty($_POST['mdp'])) {
            if($mdp === $confMdp) {
                $userData->setMdp($mdp_hache);
            }
            else {
                echo '<script type="text/javascript">window.alert("Les mots de passe saisis ne sont pas identiques");</script>';
                $this->modifierProfil();
                exit();
            }
        }

        if($user->getReferent()):
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

            /* MAJ établissement */
            $etabData->setNom($nomEtab);
            $etabData->setEtablissement($siret, $adresse, $codePostal, $ville);

            $etabSession->setNom($nomEtab);
            $etabSession->setEtablissement($siret, $adresse, $codePostal, $ville);

            $etabObj = serialize($etabSession);
            $_SESSION['etab'] = $etabObj;

        endif;


        $entityManager->flush();


        /* MAJ variables SESSION */
        $userData->setConnecte(true);
        $userObj = serialize($userData);
        $_SESSION['user'] = $userObj;


        $this->portail();
    }


    public function supprimerCompte($routeur) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        if(isset($_SESSION['user'])):
            $user = unserialize($_SESSION['user']);
        endif;
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $user->getMail()]);

        /* Suppression des ArrayCollections */
        $etabMaj = $userData->getEtablissement();
        $etabMaj->getMembres()->removeElement($userData);
        $droitMaj = $userData->getDroit();
        $droitMaj->getAyantDroit()->removeElement($userData);

        /* Suppression BDD */
        $entityManager->remove($userData);
        $entityManager->flush();


        $routeur->ctrlConnexion->deconnexion($routeur);
    }


    public function validerInscriptions() {
        $users = $this->user->getUtilisateurs();
        $etabs = $this->etab->getEtablissements();

        $vue = new Vue("PortailValiderInscriptions");
        $vue->generer(array('users' => $users, 'etabs' => $etabs));
    }


    public function validerOk($id) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $id]);
        $userData->setValide(true);
        $entityManager->flush();


        /* Envoie du mail de bienvenue */

        $to = $id;

        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = 4;
        // $mail->Debugoutput = 'html';
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        try {
           /* SMTP parameters. */
           $mail->isSMTP();
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

           $mail->setFrom('contact.capanr@gmail.com', 'Réseau CAP ANR');
           $mail->addAddress($to);
           $mail->Subject = "Votre inscription a été validée";
           $mail->Body = "Bienvenue ".$userData->getPrenom().' '.$userData->getNom()." !\n\n\nVous êtes désormais membre du réseau CAP ANR.\nVous pouvez vous connecter dès à présent sur le site en utilisant votre identifiant et le mot de passe que vous avez choisi.\n\nIdentifiant : ".$userData->getMail()."\n\nEn espérant vous revoir bientôt\n\n\nL'équipe CAP ANR";


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

        $this->validerInscriptions();
    }


    public function validerRefus($id) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $id]);

        /* Envoie du mail de refus */

        $to = $id;

        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = 4;
        // $mail->Debugoutput = 'html';
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        try {
           /* SMTP parameters. */
           $mail->isSMTP();
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

           $mail->setFrom('contact.capanr@gmail.com', 'Réseau CAP ANR');
           $mail->addAddress($to);
           $mail->Subject = "Votre inscription a été refusée";
           $mail->Body = "Bonjour ".$userData->getPrenom().' '.$userData->getNom().",\n\n\nVotrre demande d'inscription au réseau CAP ANR a été refusée. Pour plus d'information, vous pouvez contacter les gestionnaires du réseau via le formulaire de contact sur le site.\n\nMerci de votre compréhension.\n\n\nL'équipe CAP ANR";


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

        $etabMaj = $userData->getEtablissement();
        $etabMaj->getMembres()->removeElement($userData);

        $entityManager->remove($userData);
        $entityManager->flush();

        $this->validerInscriptions();
    }


    public function validerExportations() {
        $users = $this->user->getUtilisateurs();
        $etabs = $this->etab->getEtablissements();

        $vue = new Vue("PortailValiderExportations");
        $vue->generer(array('users' => $users, 'etabs' => $etabs));
    }

    public function validerExp($id) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $id]);
        $userData->setExporte(true);
        $entityManager->flush();

        $this->validerExportations();
    }


    public function editerInfos() {
        $vue = new Vue("PortailEditerInfos");
        $vue->generer(null);
    }


    public function adminUtilisateurs() {
        $users = $this->user->getUtilisateurs();
        $etabs = $this->etab->getEtablissements();

        $vue = new Vue("PortailAdminUtilisateurs");
        $vue->generer(array('users' => $users, 'etabs' => $etabs));
    }

    public function modifierDroitsUtilisateur($id) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $id]);

        $code = $userData->getDroit()->getCodeDroit();


        if($_POST['droitValidInsc'] == 'on') {
            $code[0] = '1';
        }
        else {
            $code[0] = '0';
        }

        if($_POST['droitRepContact'] == 'on') {
            $code[1] = '1';
        }
        else {
            $code[1] = '0';
        }

        if($_POST['droitImpExcel'] == 'on') {
            $code[2] = '1';
        }
        else {
            $code[2] = '0';
        }

        if($_POST['droitModifDroits'] == 'on') {
            $code[3] = '1';
        }
        else {
            $code[3] = '0';
        }

        if($_POST['droitSuppUser'] == 'on') {
            $code[4] = '1';
        }
        else {
            $code[4] = '0';
        }

        if($_POST['droitEditActus'] == 'on') {
            $code[5] = '1';
        }
        else {
            $code[5] = '0';
        }

        if($_POST['droitEditInfos'] == 'on') {
            $code[6] = '1';
        }
        else {
            $code[6] = '0';
        }

        $droitRepo = $entityManager->getRepository(Droit::class);
        $oldDroit = $userData->getDroit();
        $newDroit = $droitRepo->find($code);


        if($newDroit != null) {
            if($oldDroit->getCodeDroit() != $newDroit->getCodeDroit()) {
                $oldDroit->getAyantDroit()->removeElement($userData);

                $newDroit->ajouterAyantDroit($userData);
            }
        }
        else {
            $oldDroit->getAyantDroit()->removeElement($userData);

            $createdDroit = new Droit($code);
            $createdDroit->setDroit($code);
            $createdDroit->ajouterAyantDroit($userData);
            $entityManager->persist($createdDroit);
        }

        $entityManager->flush();

        $this->adminUtilisateurs();
    }


    public function supprimerUtilisateur($id) {
        $entityManager = require_once __DIR__.'/../lib/doctrine2/bootstrap.php';

        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $userData = $userRepo->findOneBy(["mail" => $id]);


        /* Envoie du mail de suppression */

        $to = $id;

        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = 4;
        // $mail->Debugoutput = 'html';
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        try {
           /* SMTP parameters. */
           $mail->isSMTP();
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

           $mail->setFrom('contact.capanr@gmail.com', 'Réseau CAP ANR');
           $mail->addAddress($to);
           $mail->Subject = "Votre compte a été supprimé";
           $mail->Body = "Bonjour ".$userData->getPrenom().' '.$userData->getNom().",\n\n\nVotrre compte du réseau CAP ANR a été supprimé. Pour plus d'information, vous pouvez contacter les gestionnaires du réseau via le formulaire de contact sur le site.\n\nMerci de votre compréhension.\n\n\nL'équipe CAP ANR";


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

        /* Suppression des ArrayCollections */
        $etabMaj = $userData->getEtablissement();
        $etabMaj->getMembres()->removeElement($userData);
        $droitMaj = $userData->getDroit();
        $droitMaj->getAyantDroit()->removeElement($userData);

        /* Suppression BDD */
        $entityManager->remove($userData);
        $entityManager->flush();


        $this->adminUtilisateurs();
    }

}
