<?php
if(isset($user)) {
?>



<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <i class="far fa-edit fa-3x"></i>
            <h3>Modifier votre profil</h3>
        </div>
        <div class="col-md-9 register-right">


            <!-- Formulaire bénéficiaire -->

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Je ne suis pas référent</h3>
                    <form method="post" action="?action=enregistrerProfil">
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail">Mail</label>
                                    <input type="email" class="form-control" value="<?= $user->getMail() ?>" name="mail" required/>
                                </div>
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" value="<?= $user->getNom() ?>" name="nom" required/>
                                </div>
                                <div class="form-group">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" value="<?= $user->getPrenom() ?>" name="prenom" required/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mdp">Mot de passe</label>
                                    <input type="password" class="form-control" name="mdp"/>
                                </div>
                                <div class="form-group">
                                    <label for="confMdp">Confirmer mot de passe</label>
                                    <input type="password" class="form-control" name="confMdp"/>
                                </div>
                                <div class="form-group">
                                    <label for="tel">Téléphone</label>
                                    <input type="text" minlength="10" maxlength="10" class="form-control" value="<?= $user->getTelephone() ?>" name="tel" required/>
                                </div>
                            </div>

                            <div class="text-center col-md-12">

                                <div class="form-group">
                                    <label for="fonction">Fonction</label>
                                    <select class="form-control" name="fonction" value="<?= $user->getFonction() ?>" required>
                                        <?php
                                        if($user->getFonction() == 'Chercheur'):
                                            echo '<option value="" class="hidden">Fonction</option>
                                            <option selected>Chercheur</option>
                                            <option>Enseignant-chercheur</option>
                                            <option>Administration</option>
                                            <option>Autres</option>';
                                            elseif($user->getFonction() == 'Enseignant-chercheur'):
                                                echo '<option value="" class="hidden">Fonction</option>
                                                <option>Chercheur</option>
                                                <option selected>Enseignant-chercheur</option>
                                                <option>Administration</option>
                                                <option>Autres</option>';
                                                elseif($user->getFonction() == 'Administration'):
                                                    echo '<option value="" class="hidden">Fonction</option>
                                                    <option>Chercheur</option>
                                                    <option>Enseignant-chercheur</option>
                                                    <option selected>Administration</option>
                                                    <option>Autres</option>';
                                                    elseif($user->getFonction() == 'Autres'):
                                                        echo '<option value="" class="hidden">Fonction</option>
                                                        <option>Chercheur</option>
                                                        <option>Enseignant-chercheur</option>
                                                        <option>Administration</option>
                                                        <option selected>Autres</option>';
                                                    else:
                                                        echo '<option value="" class="hidden" selected>Fonction</option>
                                                        <option>Chercheur</option>
                                                        <option>Enseignant-chercheur</option>
                                                        <option>Administration</option>
                                                        <option>Autres</option>';
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>


                                <div class="form-group">
                                    <label for="service">Service de l'établissement</label>
                                    <input type="text" class="form-control" value="<?= $user->getService() ?>" name="service" required/>
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btnRegister" value="Enregistrer"/>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">

                                        <a class="btnRegister btn bg-danger" href="#" data-toggle="modal" data-target="#supprimerCompteBen-modal">
                                            SUPPRIMER
                                        </a>

                                        <div class="modal fade" id="supprimerCompteBen-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog", role="document">
                                                <div class="modal-content loginmodal-container">
                                                    <h1>Voulez-vous vraiment supprimer votre compte ?</h1>
                                                    <div class="modal-body">

                                                        <h5>Attention !<br/>Cette opération est définitive </h5><br>

                                                        <a href="?action=supprimerCompte" class="btn bg-danger text-white">SUPPRIMER</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>
