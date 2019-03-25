<div class="container register" id="lienFormAdhesion">
	<div class="row">
		<div class="col-md-3 register-left">
			<i class="fas fa-pencil-alt fa-3x"></i>
			<h3>Formulaire d'adhésion</h3>
			<p>Rejoignez-nous !</p>
		</div>
		<div class="col-md-9 register-right">
			<ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bénéficiaire</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Référent</a>
				</li>
			</ul>

			<!-- Formulaire bénéficiaire -->

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<h3 class="register-heading">Je ne suis pas référent</h3>
					<form method="post" action="?action=formAdhesion">
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
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Mot de passe *" name="mdp" required/>
								</div>
								<div class="form-group">
									<input type="password" class="form-control"  placeholder="Confirmer mot de passe *" name="confMdp" required/>
								</div>
								<div class="form-group">
									<input type="text" minlength="10" maxlength="10" class="form-control" placeholder="Téléphone *" name="tel" required/>
								</div>
							</div>

							<div class="text-center col-md-12">

								<div class="form-group">
									<select class="form-control" name="fonction" required>
										<option value="" class="hidden" selected>Fonction</option>
										<option>Chercheur</option>
										<option>Enseignant-chercheur</option>
										<option>Administration</option>
										<option>Autres</option>
									</select>
								</div>

								<div class="form-group">
									<select class="form-control" name="etablissement" required>
										<option value="" class="hidden" selected>Établissement</option>
										<?php
										foreach($etabs as $cle => $val) {
											$nomEtab = $val->getNom();
											echo '<option>'.$nomEtab.'</option>';
										}
										?>
									</select>
								</div>

								<div class="form-group">
									<input type="text" class="form-control" placeholder="Service dans l'établissement *" name="service" required/>
								</div>

								<div class="form-group">
									<input type="submit" class="btnRegister" value="S'inscrire"/>
								</div>
							</div>
						</div>
					</form>
				</div>

				<!-- Formulaire référent -->

				<div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<h3  class="register-heading">Je suis référent</h3>
					<form method="post" action="?action=formAdhesion">
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
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Mot de passe *" name="mdp" required/>
								</div>
								<div class="form-group">
									<input type="password" class="form-control"  placeholder="Confirmer mot de passe *" name="confMdp" required/>
								</div>
								<div class="form-group">
									<input type="text" minlength="10" maxlength="10" class="form-control" placeholder="Téléphone *" name="tel" required/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<select class="form-control" name="fonction" required>
										<option value="" class="hidden" selected>Fonction</option>
										<option>Chercheur</option>
										<option>Enseignant-chercheur</option>
										<option>Administration</option>
										<option>Autres</option>
									</select>
								</div>

								<div class="form-group">
									<input type="text" class="form-control" placeholder="Service dans l'établissement *" name="service" required/>
								</div>
							</div>


							<div class="col-md-12">
								<div class="form-group">
									<input type="text" class="form-control-plaintext text-center font-weight-bold" value="MON ÉTABLISSEMENT" readonly/>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Nom *" name="nomEtab" required/>
								</div>
								<div class="form-group">
									<input type="text" minlength="14" maxlength="14" class="form-control" placeholder="N° SIRET *" name="siret" required/>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<input type="text" minlength="5" maxlength="5" class="form-control" placeholder="Code postal *" name="codePostal" required/>
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Ville *" name="ville" required/>
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Adresse *" name="adresse" required/>
								</div>
							</div>

							<div class="text-center col-md-12">
								<div class="form-group">
									<input type="submit" class="btnRegister" value="S'inscrire"/>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
