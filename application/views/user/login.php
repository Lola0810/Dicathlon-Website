<main class="connexion">
	<div class="case-connexion">
		<img src="<?php echo base_url("assets/icons/connexion-fond.svg");?>" alt="">
		<div>
			<?php echo validation_errors(); ?>
			<!-- section contenant les erreurs du formulaire -->
		</div>
		<?php echo form_open(''); ?>

		<h2>CONNEXION</h2>
			<div>
				<label class="required" for="login">Login</label>
				<input type="text" id="login" name="login" value="<?php echo set_value('login'); ?>" required>
			</div>
			<div>
				<label class="required" for="password">Mot de passe</label>
				<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" required>
			</div>

			<button type="submit">
				Se connecter
			</button>
			<p>
				Aucun compte ?
				<a href="<?php echo base_url("inscription");?>">S'inscrire</a>
			</p>
		</form>
	</div>
</main>