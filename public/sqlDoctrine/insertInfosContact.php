<?php

$entityManager = require_once __DIR__.'/../../lib/doctrine2/bootstrap.php';
require_once __DIR__.'/../../modele/Information.php';
use INFO2\CAPANR\Information;

// Instanciation des infos
$info = new Information();

$info->setInfoContact("Contact", "Pour adhérer, veuillez remplir le formulaire d'adhésion (rubrique Nous rejoindre).
Pour toute autre demande, veuillez contacter le comité d'animation via ce formulaire : nous vous répondrons dès que possible.");

$entityManager->persist($info);
$entityManager->flush();
