<?php
namespace INFO2\CAPANR;

require_once __DIR__.'/../modele/Vue.php';
use INFO2\CAPANR\Vue;
require_once __DIR__.'/../modele/Information.php';
use INFO2\CAPANR\Information;


class ControleurActualite {

    private $info;

    public function __construct() {
        $this->info = new Information();
    }

    // Affiche la liste de tous les actualites
    public function actualite() {
        $infos = $this->info->getInfosActualite();
        $vue = new Vue("Actualite");
        $vue->generer(array('infos' => $infos));
    }

    // Affiche une actu en détail
    public function actuDetail($id) {
        $info = $this->info->getUneInfo($id);
        $vue = new Vue("ActuDetail");
        $vue->generer(array('info' => $info));
    }
}
