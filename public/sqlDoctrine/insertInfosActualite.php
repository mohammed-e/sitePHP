<?php

$entityManager = require_once __DIR__.'/../../lib/doctrine2/bootstrap.php';
require_once __DIR__.'/../../modele/Information.php';
use INFO2\CAPANR\Information;

// Instanciation des infos
$info = new Information();

$info->setInfoActualite("Lancement du site du réseau CAPANR", "Mensarum enim voragines et varias voluptatum inlecebras, ne longius progrediar, praetermitto illuc transiturus quod quidam per ampla spatia urbis subversasque silices sine periculi metu properantes equos velut publicos signatis quod dicitur calceis agitant, familiarium agmina tamquam praedatorios globos post terga trahentes ne Sannione quidem, ut ait comicus, domi relicto. quos imitatae matronae complures opertis capitibus et basternis per latera civitatis cuncta discurrunt.
", "https://assets.wordpress.envato-static.com/uploads/2017/12/launch.png");

$entityManager->persist($info);
$entityManager->flush();
