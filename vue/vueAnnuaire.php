<?php $this->titre = 'Annuaire';

if(isset($_SESSION['user'])):
    $user = unserialize($_SESSION['user']);
endif;

if(isset($_SESSION['droit'])):
    $droit = unserialize($_SESSION['droit']);
endif;

?>

<h3 id="grosTitre">Annuaire</h3>


<div class="container mt-5">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-lg-7 text-center">
					<h4>Membres CAP ANR</h4>
				</div>
				<div class="col-lg-5 text-center">
                    <?php
                    if(isset($user) && $user->getConnecte() && isset($droit) && $droit->getImportationExcel()):
				        echo '<a href="?action=importerExcel" class="btn btn-success"><i class="fas fa-file-excel"></i> Importer Excel</a>';
                    endif;
                    ?>
				</div>
            </div>
        </div>

		<div class="container">
            <form class="col-lg-12" method="post" action="?action=formAnnuaire">
    			<div class="row text-center p-2 pt-3">
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

    				<div class="col-lg-6 pb-2">
                        <select class="form-control" name="fonction">
                            <option value="" class="hidden" selected>Fonction</option>
                            <option>Chercheur</option>
                            <option>Enseignant-chercheur</option>
                            <option>Administration</option>
                            <option>Autres</option>
                        </select>
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
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($users as $cle => $val) {
                    if($val->getValide() && $val->getReferent()):
                        $nom = $val->getNom();
                        $prenom = $val->getPrenom();
                        $etabUser = $val->getEtablissement()->getNom();
                        $service = $val->getService();
                        $fonction = $val->getFonction();
                        $mail = $val->getMail();
                        $tel = $val->getTelephone();

                        echo '<tr>';
                            echo '<td>'.$nom.'</td>';
                            echo '<td>'.$prenom.'</td>';
                            echo '<td>'.$etabUser.'</td>';
                            echo '<td>'.$service.'</td>';
                            echo '<td>'.$fonction.'</td>';
                            echo '<td>'.$mail.'</td>';
                            echo '<td>'.$tel.'</td>';
                        echo '</tr>';
                    endif;
                }
            ?>
        </tbody>
    </table>
</div>
