<?php

$entityManager = require_once __DIR__.'/../../lib/doctrine2/bootstrap.php';
require_once __DIR__.'/../../modele/Information.php';
use INFO2\CAPANR\Information;

// Instanciation des infos
$info = new Information();
$info2 = new Information();

$info->setInfoAdhesion("Modalité :", "Toute demande d’adhésion au Réseau se fait via le renseignement du Formulaire d'adhésion.
	- Ce Formulaire d’Adhésion permet d’identifier le demandeur, son établissement de rattachement ainsi que le service administratif auquel il est affecté.
	- Les demandeurs sont des personnels administratifs des services centraux des établissements (ou services équivalents) ou des personnels administratifs des unités de recherche (ayant eu l’accord préalable de leur établissement pour être Membre).
	- Le nombre de Membre et d’Etablissements Adhérents n’est pas limitatif.
	- Tous les établissements publics à caractère scientifique peuvent adhérer au Réseau CAP ANR.
	- Les nouveaux Membres sont automatiquement ajoutés à la liste publiée sur le site internet du Réseau.
	- Les Membres du Réseau CAP ANR s’engagent à respecter la Charte de Fonctionnement.");
// Gestion de la persistance
$entityManager->persist($info);
$entityManager->flush();
// Vérification du résultats
// echo "Identifiant de l'utilisateur créé : ", $info->getId();


$info2->setInfoAdhesion("Procédure d'adhésion :", "- Étape 1 : Première Adhésion de l’Établissement souhaitant adhérer au Réseau CAP ANR .
	Nous vous invitons à compléter le formulaire suivant en désignant le référent ANR de votre Etablissement, ce formulaire signé par la personne habilitée à engager l’Etablissement ou son représentant est ensuite renvoyé à l’adresse suivante : capanr@amue.fr
	Lorsque le formulaire d’adhésion est validé, le Référent ANR recevra ses identifiants pour se connecter sur l’espace privatif du Réseau CAP ANR.
	A l’issue de cette étape, l’Etablissement Adhérent pourra inscrire d’autres Membres.

	- Étape 2 : Pour inscrire d'autres bénéficiaires du membre adhérent.
	Nous vous invitons à compléter le formulaire d’adhésion suivant pour ajouter d’autres Membres de l’Etablissement Adhérent :
	Formulaire d'adhésion.
	Lorsque le formulaire d’adhésion est validé, le Membre du Réseau recevra ses identifiants pour se connecter sur l’espace privatif du Réseau CAP ANR.

	- NB : Le maintien de l’accès aux outils d’un Référent ANR ou d’un Membre du Réseau est conditionné par son maintien dans ses fonctions au sein de l’Etablissement Adhérent.
	En cas de cessation de fonctions ou de changement d’affectation, il devra informer le Comité d'Animation. de son départ et, le cas échéant, désigner ou informer le comité d’animation de la désignation de son successeur dans les meilleurs délais.");
// Gestion de la persistance
$entityManager->persist($info2);
$entityManager->flush();
