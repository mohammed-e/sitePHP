<?php $this->titre = 'Valider Exportations';

if(isset($_SESSION['droit'])):
    $droit = unserialize($_SESSION['droit']);
endif;
?>

<h3 id="grosTitre">Valider Exportations</h3>


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
            <form class="col-lg-12" method="post" action="?action=formAnnuaire&nomPage=validerExp">
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
                    if($val->getValide() && !$val->getExporte()):
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

                                        <a class="btn btn-light" href="#" data-toggle="modal" data-target="#validerExp-modal'.$count.'">
                                            <i class="fas fa-check fa-lg"></i>
                                        </a>'.

                                        /* Formulaire d'exportation */
                                        '<div class="modal fade" id="validerExp-modal'.$count.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog", role="document">
                                                <div class="modal-content loginmodal-container">
                                                    <h1>Validation export</h1><br/>
                                                    <div class="modal-body">
                                                        <h5>Avez-vous terminé l\'export de ce membre sur l\'extranet AMUE ?</h5><br/>
                                                        <h4>'.$prenom.' '.$nom.'</h4>
                                                        <h5 class="text-muted">'.$mail.'</h5><br/>
                                                        <a href="?action=validerExp&mail='.$mail.'" class="btn btn-success">
                                                            <i class="fas fa-check fa-2x"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';


                                        if(isset($droit) && $droit->getSuppressionUtilisateurs()):
                                            echo '<a class="btn btn-light" href="#" data-toggle="modal" data-target="#supprimer-modal2'.$count.'bis'.'">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </a>'.
                                            /* Formulaire de suppression */
                                            '<div class="modal fade" id="supprimer-modal2'.$count.'bis'.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog", role="document">
                                                    <div class="modal-content loginmodal-container">
                                                        <h1>Voulez-vous vraiment supprimer ce membre ?</h1><br>
                                                        <div class="modal-body">

                                                            <h5>Le membre suivant va être supprimé:</h5><br/>
                                                            <h4>'.$prenom.' '.$nom.'</h4>
                                                            <h5 class="text-muted">'.$mail.'</h5>

                                                            <h5><br/>Attention !<br/>Cette opération est définitive </h5><br/>

                                                            <a href="?action=supprimerUtilisateur&mail='.$mail.'" class="btn btn-danger">
                                                                <i class="fas fa-trash-alt fa-2x"></i>
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        endif; echo '
                                </td>
                            </tr>';
                    endif;
                    $count = $count+1;
                }
            ?>
        </tbody>
    </table>
</div>
