<?php $this->titre = 'Contact'; ?>

<h3 id="grosTitre">Nous contacter</h3>

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


// Affichage du formulaire de contact
require_once __DIR__.'/form/vueFormContact.php';

?>
