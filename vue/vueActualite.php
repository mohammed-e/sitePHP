<?php $this->titre = 'Actualites'; ?>

<h3 id="grosTitre">Actualités</h3>

<?php

require_once __DIR__.'/../modele/Rss.php';
use INFO2\CAPANR\Rss;


$feedlist = new Rss('http://www.agence-nationale-recherche.fr/flux-rss/');
?>

<script src="public/js/actus.js"></script>


<div class="tabs">
  <div class="tab-button-outer">
    <ul id="tab-button">
      <li><a href="#tab01">ANR</a></li>
      <li><a href="#tab02">Réseau CAP ANR</a></li>
      <li><a href="#tab03">Autres</a></li>
    </ul>
  </div>
  <div class="tab-select-outer text-center">
    <select id="tab-select">
      <option value="#tab01">ANR</option>
      <option value="#tab02">Réseau CAP ANR</option>
      <option value="#tab03">Autres</option>
    </select>
  </div>



  <div id="tab01" class="tab-contents">
    <?= $feedlist->display(7, "ANR"); ?>
  </div>


  <div id="tab02" class="tab-contents">
    <h3 class="mt-3 mb-5">Réseau CAP ANR</h3>
	<?php
	//  Récupération et affichage de toutes les informations
	if($infos != null):
		foreach($infos as $cle => $info)
		{
			$idInfo = $info->getId();
			$titreInfo = $info->getTitre();
			$corpsInfo = $info->getCorps();

			echo '<a class="h5 text-center text-primary d-block mb-5" href="?action=actuDetail&id='.$idInfo.'">'.nl2br($titreInfo).'</a>';
		}

	endif;
	?>
  </div>


  <div id="tab03" class="tab-contents">
    <h3 class="mt-3 mb-5">Autres</h3> <br />
  </div>

</div>
