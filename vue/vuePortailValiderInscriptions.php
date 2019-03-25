<?php $this->titre = 'Valider Inscriptions'; ?>

<h3 id="grosTitre">Valider Inscriptions</h3>


<div class="container mt-5">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4>Membres CAP ANR</h4>
                </div>
            </div>
        </div>

		<div class="container">
            <form class="col-lg-12" method="post" action="?action=formAnnuaire&nomPage=validerInsc">
    			<div class="row text-center p-3">
                    <div class="col-lg-6 pb-2">
                        <select class="form-control" name="etablissement">
                            <option value="" class="hidden" selected>Établissement</option>
                            <?php
                                foreach($etabs as $cle => $val) {
                                    $nomEtab = $val->getNom();
                                    echo '<option>'.$nomEtab.'</option>';
                                }
                            ?>
                        </select>
    				</div>

    				<div class="col-lg-4 pb-2">
                        <select class="form-control" name="fonction">
                            <option value="" class="hidden" selected>Fonction</option>
                            <option>Chercheur</option>
                            <option>Enseignant-chercheur</option>
                            <option>Administration</option>
                            <option>Autres</option>
                        </select>
    				</div>

                    <div class="col-lg-2 pb-2">
                        <div class="custom-control custom-switch">
                          <input type="hidden" value="off" name="referent">
                          <input type="checkbox" class="custom-control-input" id="referent" name="referent">
                          <label class="custom-control-label" for="referent">Référent</label>
                        </div>
                    </div>
                </div>

                <div class="row text-center p-2">
                    <div class="col-lg-6 pb-2">
                        <input type="search" class="form-control" placeholder="Nom" name="nom"/>
                    </div>

                    <div class="col-lg-6 pb-2">
                        <input type="search" class="form-control" placeholder="Prénom" name="prenom"/>
                    </div>
                </div>

                <div class="row text-center p-2">
                    <div class="col-lg-6 pb-2">
                        <input type="search" class="form-control" placeholder="Service" name="service"/>
                    </div>

                    <div class="col-lg-6 pb-2">
                        <input type="search" class="form-control" placeholder="Mail" name="mail"/>
                    </div>
                </div>

                <div class="row text-center p-2">
                    <div class="col-lg-12 pb-2">
                        <button class="btn btn-primary text-center" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <table class="table table-responsive-lg table-striped table-hover">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
				<th>Établissement</th>
                <th>Service</th>
				<th>Fonction</th>
                <th>Mail</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $count = 0;
                foreach($users as $cle => $val) {
                    if(!$val->getValide()):
                        $nom = $val->getNom();
                        $prenom = $val->getPrenom();
                        $etabUser = $val->getEtablissement()->getNom();
                        $service = $val->getService();
                        $fonction = $val->getFonction();
                        $mail = $val->getMail();
                        $tel = $val->getTelephone();

                        $ancienDroit = $val->getDroit()->getCodeDroit();

                        echo '<tr>';
                            echo '<td>'.$nom.'</td>';
                            echo '<td>'.$prenom.'</td>';
                            echo '<td>'.$etabUser.'</td>';
                            echo '<td>'.$service.'</td>';
                            echo '<td>'.$fonction.'</td>';
                            echo '<td>'.$mail.'</td>';
                            echo '<td>'.$tel.'</td>';
                            echo '<td>
                                    <div class="btn-group">



                                        <a class="btn btn-light" href="#" data-toggle="modal" data-target="#validerInsc-modal'.$count.'">
                                            <i class="fas fa-check fa-lg"></i>
                                        </a>'.

                                        /* Formulaire d'acceptation */
                                        '<div class="modal fade" id="validerInsc-modal'.$count.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog", role="document">
                                                <div class="modal-content loginmodal-container">
                                                    <h1>Validation inscription</h1><br/>
                                                    <div class="modal-body">
                                                        <h5>Voulez-vous vraiment accepter ce membre dans le réseau CAP ANR ?</h5><br/>
                                                        <h4>'.$prenom.' '.$nom.'</h4>
                                                        <h5 class="text-muted">'.$mail.'</h5><br/>
                                                        <a href="?action=validerOk&mail='.$mail.'" class="btn btn-success">
                                                            <i class="fas fa-check fa-2x"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';


                                            echo '<a class="btn btn-light" href="#" data-toggle="modal" data-target="#supprimerUser-modal'.$count.'bis'.'">
                                                <i class="fas fa-times fa-lg"></i>
                                            </a>'.
                                            /* Formulaire de rejet */
                                            '<div class="modal fade" id="supprimerUser-modal'.$count.'bis'.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog", role="document">
                                                    <div class="modal-content loginmodal-container">
                                                        <h1>Rejet inscription</h1><br/>
                                                        <div class="modal-body">
                                                            <h5>Voulez-vous vraiment rejeter ce membre du réseau CAP ANR ?</h5><br/>
                                                            <h4>'.$prenom.' '.$nom.'</h4>
                                                            <h5 class="text-muted">'.$mail.'</h5><br/>
                                                            <a href="?action=validerRefus&mail='.$mail.'" class="btn btn-danger">
                                                                <i class="fas fa-times fa-2x"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                </td>
                            </tr>';
                    endif;
                    $count = $count+1;
                }
            ?>
        </tbody>
    </table>
</div>
