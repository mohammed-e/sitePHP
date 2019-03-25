<?php
namespace INFO2\CAPANR;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
require_once __DIR__.'/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;


/**
* @ORM\Entity
* @ORM\Table(name="droits")
*/
class Droit {


    /**
    * @ORM\Id
    * @ORM\Column(type="string")
    */
    private $codeDroit;

    /**
    * @ORM\Column(type="string")
    */
    private $validationInscriptions;

    /**
    * @ORM\Column(type="string")
    */
    private $reponseContact;

    /**
    * @ORM\Column(type="string")
    */
    private $importationExcel;

    /**
    * @ORM\Column(type="string")
    */
    private $modificationDroits;

    /**
    * @ORM\Column(type="string")
    */
    private $suppressionUtilisateurs;

    /**
    * @ORM\Column(type="string")
    */
    private $editionActus;

    /**
    * @ORM\Column(type="string")
    */
    private $editionInfos;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, cascade={"persist", "remove"}, mappedBy="droit")
     */
    private $ayantDroit;



/*************/


    public function __construct(string $codeDroit) {
        $this->codeDroit = $codeDroit;
        $this->ayantDroit = new ArrayCollection();
    }



    public function getCodeDroit()  : string {
        return $this->codeDroit;
    }

    public function getValidationInscriptions() {
        return $this->validationInscriptions == '1';
    }

    public function getReponseContact() {
        return $this->reponseContact == '1';
    }

    public function getImportationExcel() {
        return $this->importationExcel == '1';
    }

    public function getModificationDroits() {
        return $this->modificationDroits == '1';
    }

    public function getSuppressionUtilisateurs() {
        return $this->suppressionUtilisateurs == '1';
    }

    public function getEditionActus() {
        return $this->editionActus == '1';
    }

    public function getEditionInfos() {
        return $this->editionInfos == '1';
    }

    public function getAyantDroit() {
        return $this->ayantDroit;
    }



    public function setCodeDroit(string $newCodeDroit){
        $this->codeDroit = $newCodeDroit;
    }

    public function setValidationInscriptions(string $newValidationInscriptions){
        $this->validationInscriptions = $newValidationInscriptions;
    }

    public function setReponseContact(string $newReponseContact){
        $this->reponseContact = $newReponseContact;
    }

    public function setImportationExcel(string $newImportationExcel){
        $this->importationExcel = $newImportationExcel;
    }

    public function setModificationDroits(string $newModificationDroits){
        $this->modificationDroits = $newModificationDroits;
    }

    public function setSuppressionUtilisateurs(string $newSuppressionUtilisateurs){
        $this->suppressionUtilisateurs = $newSuppressionUtilisateurs;
    }

    public function setEditionActus(string $newEditionActus){
        $this->editionActus = $newEditionActus;
    }

    public function setEditionInfos(string $newEditionInfos){
        $this->editionInfos = $newEditionInfos;
    }



    public function setDroit(string $code) {
        $this->validationInscriptions = $code[0];
        $this->reponseContact = $code[1];
        $this->importationExcel = $code[2];
        $this->modificationDroits = $code[3];
        $this->suppressionUtilisateurs = $code[4];
        $this->editionActus = $code[5];
        $this->editionInfos = $code[6];
    }


    // Renvoie la liste de tous les droits
    public function getDroits() {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $droitRepo = $entityManager->getRepository(Droit::class);
        $droits = $droitRepo->findAll();
        return $droits;
    }


    public function getUnDroit(string $code) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $droitRepo = $entityManager->getRepository(Droit::class);
        $droit = $droitRepo->find($code);
        return $droit;
    }


    public function ajouterAyantDroit(Utilisateur $user)
    {
        $this->ayantDroit->add($user);
        $user->setDroit($this);
    }


}
