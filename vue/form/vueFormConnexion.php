<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog", role="document">
        <div class="modal-content loginmodal-container">
            <h1>Connectez-vous</h1><br>
            <div class="modal-body">
                <form method="post" action="?action=formConnexion">
                    <div class="form-group">
                        <input type="text" name="idMail" placeholder="Identifiant" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="mdp" placeholder="Mot de passe" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="login loginmodal-submit" value="Se connecter">
                    </div>
                </form>
            </div>
            <div class="login-help text-center">
                <a href="?action=adhesion#lienFormAdhesion">S'inscrire</a> - <a href="?action=contact#lienFormContact">Mot de passe oublié ?</a>
            </div>
        </div>
    </div>
</div>
