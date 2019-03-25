<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Information.php';
use INFO2\CAPANR\Information;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/../lib/phpMailer/vendor/autoload.php';


class ControleurContact {

    private $info;
    private $user;

    public function __construct() {
        $this->info = new Information();
        $this->user = new Utilisateur("test@init.com");
    }

    // Affiche la liste de tous les infos de l'accueil
    public function contact() {
        $infos = $this->info->getInfosContact();
        $vue = new Vue("Contact");
        $vue->generer(array('infos' => $infos));
    }


    public function formContact() {
        /* On récupère les champs */
        $nom = trim($_POST['nom']);
        $nom = htmlspecialchars($nom);
        $prenom = trim($_POST['prenom']);
        $prenom = htmlspecialchars($prenom);
        $email = trim($_POST['mail']);
        $email = htmlspecialchars($email);
        $sujet = trim($_POST['sujet']);
        $sujet = htmlspecialchars($sujet);
        $message = trim($_POST['message']);
        $message = htmlspecialchars($message);

        /* On récupère les destinataires */
        $users = $this->user->getAdminContact();
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

               $mail->setFrom('contact.capanr@gmail.com', 'Contact CAP ANR');
               $mail->addAddress($to);
               $mail->Subject = 'Demande de contact site CAP ANR';
               $mail->Body = "Vous venez de recevoir une demande de contact de la part d'un visiteur du site CAP ANR.\n\n- Informations -\n\nNom : ".$nom."\nPrénom : ".$prenom."\nAdresse mail : ".$email."\n\n- Demande -\n\nSujet : ".$sujet."\n\n".$message;
               $mail->addReplyTo($email, $prenom.' '.$nom);

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
        /* Redirection */
        $this->contact();
    }
}
