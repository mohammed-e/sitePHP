<?php $this->titre = 'Accueil'; ?>

<img id="imageAccueil" src="public/image/CAPANR.png" alt="Réseau CAPANR">
<h3 id="grosTitre">Accueil</h3>

<?php
//  Récupération et affichage de toutes les informations
if($infos != null):
	foreach($infos as $cle => $info)
	{
		$titreInfo = $info->getTitre();
		$corpsInfo = $info->getCorps();

		echo '<div class="card bg-light">';
			echo '<div class="card-body">';
				echo '<h4 class="card-title">'.$titreInfo.'</h4>';
				echo '<p class="card-text">'.nl2br($corpsInfo).'</p>';
			echo '</div>';
		echo '</div>';
	}

endif;

?>
