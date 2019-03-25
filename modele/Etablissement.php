<?php
namespace INFO2\CAPANR;

use Doctrine\ORM\Mapping as ORM;
require_once __DIR__.'/../lib/doctrine2/vendor/doctrine/collections/lib/Doctrine/Common/Collections/ArrayCollection.php';
use Doctrine\Common\Collections\ArrayCollection;
require_once __DIR__.'/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;


/**
* @ORM\Entity
* @ORM\Table(name="etablissements")
*/
class Etablissement {

    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string")
    */
    private $nom;

    /**
    * @ORM\Column(type="string")
    */
    private $siret;

    /**
    * @ORM\Column(type="string")
    */
    private $adresse;

    /**
    * @ORM\Column(type="string")
    */
    private $codePostal;

    /**
    * @ORM\Column(type="string")
    */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, cascade={"persist", "remove"}, mappedBy="etablissement")
     */
    private $membres;



/*************/

    public function __construct(string $nom) {
        $this->nom = $nom;
        $this->membres = new ArrayCollection();
    }


    public function getId() {
       return $this->id;
    }

    public function getNom() : string {
       return $this->nom;
    }

    public function getNumSiret() : string {
       return $this->siret;
    }

    public function getAdresse() : string {
       return $this->adresse;
    }

    public function getCodePostal() : string {
       return $this->codePostal;
    }

    public function getVille() : string {
       return $this->ville;
    }

    public function getMembres() {
       return $this->membres;
    }


    public function setId($newId) {
        $this->id = $newId;
    }

    public function setNom(string $newNom) {
        $this->nom = $newNom;
    }

    public function setNumSiret(string $newNumSiret) {
        $this->siret = $newNumSiret;
    }

    public function setAdresse(string $newAdresse) {
        $this->adresse = $newAdresse;
    }

    public function setCodePostal(string $newCodePostal) {
        $this->codePostal = $newCodePostal;
    }

    public function setVille(string $newNVille) {
        $this->ville = $newNVille;
    }


    public function setEtablissement(string $siret, string $adresse, string $codePostal, string $ville) {
        $this->siret = $siret;
        $this->adresse = $adresse;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
    }


    // Renvoie la liste de tous les établissements
    public function getEtablissements() {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $etabRepo = $entityManager->getRepository(Etablissement::class);
        $etabs = $etabRepo->findAll();
        return $etabs;
    }


    // Renvoi un établissement en fonction de son nom
    public function getUnEtablissement(string $nom) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $etabRepo = $entityManager->getRepository(Etablissement::class);
        $etab = $etabRepo->findOneBy(["nom" => $nom]);
        return $etab;
    }


    public function ajouterMembres(Utilisateur $user) {
        $this->membres->add($user);
        $user->setEtablissement($this);
    }

}
