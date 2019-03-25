<?php $this->titre = 'Actualites'; ?>

<h3 id="grosTitre">Actualités</h3>


<?php

if($info != null):

    $idInfo = $info->getId();
    $titreInfo = $info->getTitre();
    $corpsInfo = $info->getCorps();
    $imageInfo = $info->getImage();

    echo '
    <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 col-11 m-auto">

            <div class="single-news mb-4">

                <div class="col-md-12 mb-5 text-center">
                    <img class="img-fluid" src="'.$imageInfo.'" alt="Sample image">
                </div>

                <div class="news-data text-justify">
                    <h4 class="font-weight-bold dark-grey-text mb-4">'.$titreInfo.'</h4>
                    <h5 class="card-text">'.nl2br($corpsInfo).'</h5>
                </div>

            </div>
        </div>
    </div>';

endif;
?>
