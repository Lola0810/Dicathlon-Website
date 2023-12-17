<main class="inscription">
	<div class="case-inscription">
	<img src="<?php echo base_url("assets/icons/connexion-fond.svg");?>" alt="">
		<div role="dialog">
			<?php echo validation_errors(); ?>
			<!-- section contenant les erreurs du formulaire -->
		</div>
		<?php echo form_open(''); ?>

		<h2>INSCRIPTION</h2>
			<div>
				<label class="required" for="prenom">Prénom</label>
				<input type="text" id="prenom" name="prenom" value="<?php echo set_value('prenom'); ?>" required>
			</div>
			<div>
				<label class="required" for="nom">Nom de famille</label>
				<input type="text" id="nom" name="nom" value="<?php echo set_value('nom'); ?>" required>
			</div>
			<div>
				<label class="required" for="login">Login</label>
				<input type="text" id="login" name="login" value="<?php echo set_value('login'); ?>" required>
			</div>
			<div>
				<label class="required" for="ddn">Date de naissance</label>
				<input type="date" id="ddn" name="ddn" value="<?php echo set_value('ddn'); ?>" required>
			</div>
			<div>
				<label class="required" for="email">Email</label>
				<input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
			</div>
			<div>
				<label class="required" for="password">Mot de passe</label>
				<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" required>
			</div>

			<button type="submit">
				S'inscrire
			</button>
			<p>
				Déjà un compte ?
				<a href="<?php echo base_url("connexion");?>">Se connecter</a>
			</p>
		</form>
	</div>
</main>