<?php

$entityManager = require_once __DIR__.'/../../lib/doctrine2/bootstrap.php';
require_once __DIR__.'/../../modele/Information.php';
use INFO2\CAPANR\Information;

// Instanciation des infos
$info = new Information();
$info2 = new Information();
$info3 = new Information();

$info->setInfoAccueil("Qui sommes-nous ?", "Un réseau de diverses compétences en ingénierie de projet au sein des établissements publics d'enseignement et de recherche piloté par un comité d'animation.");
// Gestion de la persistance
$entityManager->persist($info);
$entityManager->flush();
// Vérification du résultats
// echo "Identifiant de l'utilisateur créé : ", $info->getId();


$info2->setInfoAccueil("Les missions de CAP ANR", "Mutualiser les compétences, bonnes pratiques et savoir faire en ingénierie de projet pour accompagner au mieux les chercheurs et enseignants chercheurs dans leurs projets ANR.
	- Le Réseau CAP ANR permet d'échanger sur les thématiques suivantes :
	- Répondre aux AAP;
	- Suivre les étapes de négociation budgétaire;
	- Elaborer et négocier les accords de consortium;
	- Suivre l'engagement contractuel des projets (administratif et financier);
	- Mutaliser l'information.");
$entityManager->persist($info2);
$entityManager->flush();


$info3->setInfoAccueil("Pourquoi intégrer CAP ANR ?", "En devenant membre, j'intègre une communauté, je bénéficie de l'expérience et de l'expertise du réseau CAP ANR dont:
	- Une plateforme collaborative où chaque membre du réseau peut questionner les autres membres et peut également répondre aux questions;
	- CAP ANR est reconnu par la CPU;
	- CAP ANR a noué des liens privilégiés avec l'ANR qui lui consacre 2 réunions par an et qui répond directement à ses sollicitations.
	- La mise en place de groupes de travail sur des points précis (Ex : accord de consortium)
	Intégrer le réseau permet aussi de partager son expérience avec les autres membres. Rejoignez-nous !");
// Gestion de la persistance
$entityManager->persist($info3);
$entityManager->flush();
