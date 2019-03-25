<?php
namespace INFO2\CAPANR;

use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity
* @ORM\Table(name="informations")
*/
class Information {

    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string", nullable=true)
    */
    private $titre;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    private $corps;

    /**
    * @ORM\Column(type="text", nullable=true)
    */
    private $image;

    /**
    * @ORM\Column(type="string")
    */
    private $type;


/*************/


    public function getId() : int {
        return $this->id;
    }

    public function getTitre() : string {
        return $this->titre;
    }

    public function getCorps() : string {
        return $this->corps;
    }

    public function getImage() : string {
        return $this->image;
    }

    public function getType() : string {
        return $this->type;
    }


    public function setId(int $newId) {
        $this->id = $newId;
    }

    public function setTitre(string $newTitre) {
        $this->titre = $newTitre;
    }

    public function setCorps(string $newCorps) {
        $this->corps = $newCorps;
    }

    public function setImage(string $newImage) {
        $this->image = $newImage;
    }

    public function setType(string $newType) {
        $this->type = $newType;
    }


    // Renvoie la liste de toutes les informations selon leur type
    public function getInfos(string $ref) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $infoRepo = $entityManager->getRepository(Information::class);
        $listeInfos = $infoRepo->findBy(["type" => $ref]);
        return $listeInfos;
    }

    // Renvoie la liste de toutes les informations de type accueil
    public function getInfosAccueil() {
        $listeInfos = $this->getInfos("accueil");
        return $listeInfos;
    }

    // Renvoie la liste de toutes les informations de type actualite
    public function getInfosActualite() {
        $listeInfos = $this->getInfos("actualite");
        return $listeInfos;
    }

    // Renvoie la liste de toutes les informations de type adhesion
    public function getInfosAdhesion() {
        $listeInfos = $this->getInfos("adhesion");
        return $listeInfos;
    }

    // Renvoie la liste de toutes les informations de type contact
    public function getInfosContact() {
        $listeInfos = $this->getInfos("contact");
        return $listeInfos;
    }


    public function getUneInfo(int $id) {
        $entityManager = require __DIR__.'/../lib/doctrine2/bootstrap.php';
        $infoRepo = $entityManager->getRepository(Information::class);
        $info = $infoRepo->findOneBy(["id" => $id]);
        return $info;
    }



    // Instancie un objet Information quelconque
    public function setInfo(string $ref, string $title = null, string $content = null, string $image = null) {
        $this->type = $ref;
        $this->titre = $title;
        $this->corps = $content;
        $this->image = $image;
    }

    // Instancie un objet Information de type accueil
    public function setInfoAccueil(string $title = null, string $content = null, string $image = null) {
        $this->setInfo("accueil", $title, $content, $image);
    }

    // Instancie un objet Information de type actualite
    public function setInfoActualite(string $title = null, string $content = null, string $image = null) {
        $this->setInfo("actualite", $title, $content, $image);
    }

    // Instancie un objet Information de type adhesion
    public function setInfoAdhesion(string $title = null, string $content = null, string $image = null) {
        $this->setInfo("adhesion", $title, $content, $image);
    }

    // Instancie un objet Information de type contact
    public function setInfoContact(string $title = null, string $content = null, string $image = null) {
        $this->setInfo("contact", $title, $content, $image);
    }
}
