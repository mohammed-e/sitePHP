<div class="container register" id="lienFormContact">
    <div class="row">

        <div class="col-md-3 register-left">
            <i class="far fa-envelope fa-3x"></i>
            <h3>Une question ?</h3>
            <p>Contactez-nous !</p>
        </div>

        <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Formulaire de contact</h3>
                    <form method="post" action="?action=formContact">
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Nom *" name="nom" required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Prénom *" name="prenom" required/>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Mail *" name="mail" required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="sujet" id="titreMessage" class="form-control" placeholder="Titre du message *" required/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" placeholder="Message *" required></textarea>
                                </div>
                            </div>

                            <div class="text-center col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btnRegister" value="Envoyer"/>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
