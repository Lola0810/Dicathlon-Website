<h1>Mon profil</h1>

<div role="dialog">
	<?php echo validation_errors(); ?>
	<!-- section contenant les erreurs du formulaire -->
</div>
<?php echo form_open('', [], ["type" => "edit_account"]); ?>
	<div>
		<label class="required" for="prenom">Prénom</label>
		<input type="text" id="prenom" name="prenom" value="<?php echo $user["prenom"]; ?>">
	</div>
	<div>
		<label class="required" for="nom">Nom de famille</label>
		<input type="text" id="nom" name="nom" value="<?php echo $user["nom"]; ?>">
	</div>
	<div>
		<label class="required" for="login">Login</label>
		<input type="text" id="login" name="login" value="<?php echo $user["login"] ?>" disabled>
	</div>
	<div>
		<label class="required" for="ddn">Date de naissance</label>
		<input type="date" id="ddn" name="ddn" value="<?php echo $user["ddn"]; ?>">
	</div>
	<div>
		<label class="required" for="email">Email</label>
		<input type="email" id="email" name="email" value="<?php echo $user["email"]; ?>">
	</div>

	<button type="submit">Modifier</button>
</form>

<?php if($user["type_utilisateur"] !== "agent" OR $user["type_utilisateur"] !== "admin") { ?>
	<?php echo form_open('/profil', [], ["type" => "delete_account"]); ?>
		<button>Supprimer mon compte</button>
	</form>
<?php } ?>
