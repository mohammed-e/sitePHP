<?php

$entityManager = require_once __DIR__.'/../../lib/doctrine2/bootstrap.php';
require_once __DIR__.'/../../modele/Utilisateur.php';
use INFO2\CAPANR\Utilisateur;
require_once __DIR__.'/../../modele/Etablissement.php';
use INFO2\CAPANR\Etablissement;
require_once __DIR__.'/../../modele/Droit.php';
use INFO2\CAPANR\Droit;



$user = new Utilisateur("superadm.capanr@yandex.com");
$user2 = new Utilisateur("userlambda.capanr@yandex.com");
$user3 = new Utilisateur("userlambda2.capanr@yandex.com");
$user4 = new Utilisateur("userlambda3.capanr@yandex.com");
$user5 = new Utilisateur("userlambda4.capanr@yandex.com");
$droit = new Droit("1111111");
$droit2 = new Droit("0000000");
$droit3 = new Droit("0011000");
$etab = new Etablissement("UNIV PARIS XIII PARIS-NORD VILLETANEUSE");
$etab2 = new Etablissement("UNIVERSITE DE PARIS VIII PARIS VINCENNES");



$mdp = "Nobrouj:01";
$mdp_hache = password_hash($mdp, PASSWORD_DEFAULT);
$user->setUtilisateur("Experience", "Gold", $mdp_hache, "0610203040", "Administration", "Administratif", true, true, true, false);

$mdp2 = "Nobrois:02";
$mdp_hache2 = password_hash($mdp2, PASSWORD_DEFAULT);
$user2->setUtilisateur("Man", "Zipper", $mdp_hache2, "0611223344", "Chercheur", "Labo", true, true, false, false);

$mdp3 = "tmtc3";
$mdp_hache3 = password_hash($mdp3, PASSWORD_DEFAULT);
$user3->setUtilisateur("Pistols", "Six", $mdp_hache3, "0611223355", "Chercheur", "Labo", false, false, false, false);

$mdp4 = "tmtc4";
$mdp_hache4 = password_hash($mdp4, PASSWORD_DEFAULT);
$user4->setUtilisateur("World", "The", $mdp_hache4, "0611223366", "Enseignant-Chercheur", "Amphis", false, false, false, false);

$mdp5 = "tmtc5";
$mdp_hache5 = password_hash($mdp5, PASSWORD_DEFAULT);
$user5->setUtilisateur("Chariot", "Silver", $mdp_hache5, "0611223377", "Autres", "Crous", false, false, false, false);


$droit->setDroit("1111111");
$droit->ajouterAyantDroit($user);

$droit2->setDroit("0000000");
$droit2->ajouterAyantDroit($user3);
$droit2->ajouterAyantDroit($user4);
$droit2->ajouterAyantDroit($user5);

$droit3->setDroit("0011000");
$droit3->ajouterAyantDroit($user2);



$etab->setEtablissement("19931238000017", "99 AV JEAN BAPTISTE CLEMENT", "93430", "VILLETANEUSE");
$etab->ajouterMembres($user);
$etab->ajouterMembres($user3);
$etab->ajouterMembres($user4);

$etab2->setEtablissement("19931827000014", "2 RUE DE LA LIBERTE", "93200", "SAINT-DENIS");
$etab2->ajouterMembres($user2);
$etab2->ajouterMembres($user5);



$entityManager->persist($droit);
$entityManager->persist($etab);
$entityManager->persist($droit2);
$entityManager->persist($etab2);
$entityManager->persist($droit3);
$entityManager->flush();
