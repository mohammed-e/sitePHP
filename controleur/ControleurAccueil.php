<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Information.php';
use INFO2\CAPANR\Information;


class ControleurAccueil {

    private $info;

    public function __construct() {
        $this->info = new Information();
    }

    // Affiche la liste de tous les infos de l'accueil
    public function accueil() {
        $infos = $this->info->getInfosAccueil();
        $vue = new Vue("Accueil");
        $vue->generer(array('infos' => $infos));
    }
}
