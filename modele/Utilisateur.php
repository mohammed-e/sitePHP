<?php
namespace INFO2\CAPANR;

use Doctrine\ORM\Mapping as ORM;
require_once __DIR__.'/Droit.php';
use INFO2\CAPANR\Droit;
require_once __DIR__.'/Etablissement.php';
use INFO2\CAPANR\Etablissement;


/**
* @ORM\Entity
* @ORM\Table(name="utilisateurs")
*/
class Utilisateur {

    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string")
    */
    private $mail;

    /**
    * @ORM\Column(type="string")
    */
    private $nom;

    /**
    * @ORM\Column(type="string")
    */
    private $prenom;

    /**
    * @ORM\Column(type="string")
    */
    private $mdp;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $telephone;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $fonction;

    /**
    * @ORM\Column(type="boolean")
    */
    private $referent = false;

    /**
    * @ORM\Column(type="boolean")
    */
    private $valide = false;

    /**
    * @ORM\Column(type="boolean")
    */
    private $exporte = false;


    private $connecte = false;


    /**
    * @ORM\ManyToOne(targetEntity=Droit::class, inversedBy="ayantDroit")
    * @ORM\JoinColumn(name="droit", referencedColumnName="codeDroit", nullable=false)
    */
    private $droit;

    /**
    * @ORM\ManyToOne(targetEntity=Etablissement::class, inversedBy="membres")
    * @ORM\JoinColumn(name="etablissement", referencedColumnName="id", nullable=false)
    */
    private $etablissement;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $service;



/*************/


    public function __construct(string $mail) {
        $this->mail = $mail;
    }


    public function getId() {
       return $this->id;
    }

    public function getMail() : string {
        return $this->mail;
    }

    public function getNom() : string {
        return $this->nom;
    }

    public function getPrenom() : string {
        return $this->prenom;
    }

    public function getMdp() : string {
        return $this->mdp;
    }

    public function getTelephone() : string {
        return $this->telephone;
    }

    public function getFonction() : string {
        return $this->fonction;
    }

    public function getReferent() {
        return $this->referent;
    }

    public function getValide() {
        return $this->valide;
    }

    public function getExporte() {
        return $this->exporte;
    }

    public function getConnecte() {
        return $this->connecte;
    }

    public function getDroit() {
        return $this->droit;
    }

    public function getEtablissement() {
        return $this->etablissement;
    }

    public function getService() {
        return $this->service;
    }


    public function setId($newId) {
        $this->id = $newId;
    }

    public function setMail(string $newMail)
    {
        $this->mail = $newMail;
    }

    public function setNom(string $newNom)
    {
        $this->nom = $newNom;
    }

    public function setPrenom(string $newPrenom)
    {
        $this->prenom = $newPrenom;
    }

    public function setMdp(string $newMdp)
    {
        $this->mdp = $newMdp;
    }

    public function setTelephone(string $newTelephone)
    {
        $this->telephone = $newTelephone;
    }

    public function setFonction(string $newFonction)
    {
        $this->fonction = $newFonction;
    }

    public function setReferent($newRef)
    {
        $this->referent = $newRef;
    }

    public function setValide($newValide)
    {
        $this->valide = $newValide;
    }

    public function setExporte($newExporte)
    {
        $this->exporte = $newExporte;
    }

    public function setConnecte($newCo)
    {
        $this->connecte = $newCo;
    }

    public function setDroit($newDroit)
    {
        $this->droit = $newDroit;
    }

    public function setEtablissement($newEtablissement)
    {
        $this->etablissement = $newEtablissement;
    }

    public function setService($newService)
    {
        $this->service = $newService;
    }



    // Renvoie un utilisateur selon son mail (clé primaire)
    public function getUtilisateur(string $mail) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $user = $userRepo->findOneBy(["mail" => $mail]);
        return $user;
    }


    // Renvoie la liste de tous les utilisateurs
    public function getUtilisateurs() {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $users = $userRepo->findAll();
        return $users;
    }

    // Renvoie une liste d'utilisateurs selon un ensemble de critères
    public function getUtilisateursCond($cond) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $userRepo = $entityManager->getRepository(Utilisateur::class);
        $users = $userRepo->findBy($cond);
        return $users;
    }


    // Renvoi la liste des administrateurs ayant le droit de valider une inscription
    public function getAdminValidation() {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';

        $query = $entityManager->createQuery("SELECT u FROM INFO2\CAPANR\Utilisateur u JOIN u.droit d WHERE d.codeDroit LIKE '1%'");
        $users = $query->getResult();

        return $users;
    }


    // Renvoi la liste des administrateurs ayant le droit de répondre à une demande de contact
    public function getAdminContact() {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';

        $query = $entityManager->createQuery("SELECT u FROM INFO2\CAPANR\Utilisateur u JOIN u.droit d WHERE d.codeDroit LIKE '_1%'");
        $users = $query->getResult();

        return $users;
    }


    // Instancie un objet Utilisateur
    public function setUtilisateur(string $nom, string $prenom, string $mdp, string $telephone, string $fonction, $service, $referent, $valide, $exporte, $modifieMdp) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->telephone = $telephone;
        $this->fonction = $fonction;
        $this->service = $service;
        $this->referent = $referent;
        $this->valide = $valide;
        $this->exporte = $exporte;
        $this->modifieMdp = $modifieMdp;
    }

}
