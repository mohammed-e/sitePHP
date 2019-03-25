<?php $this->titre = 'Modifier Profil'; ?>

<h3 id="grosTitre">Modifier profil</h3>

<?php

if(isset($user) && $user->getConnecte()):
    if($user->getReferent()):
        require_once __DIR__.'/form/vueFormPortailModifierProfilReferent.php';
    else:
        require_once __DIR__.'/form/vueFormPortailModifierProfilBeneficiaire.php';
    endif;
endif;

?>
