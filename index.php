<?php

require 'controleur/Routeur.php';
use INFO2\CAPANR\Routeur;
require_once __DIR__.'/modele/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;
require_once __DIR__.'/modele/Droit.php';
use INFO2\CAPANR\Droit;
require_once __DIR__.'/modele/Etablissement.php';
use INFO2\CAPANR\Etablissement;
use Doctrine\Common\Collections\ArrayCollection;



session_start();

$routeur = new Routeur();
$routeur->routerRequete();
