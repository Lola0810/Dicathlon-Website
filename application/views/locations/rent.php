<div role="dialog">
	<?php echo validation_errors(); ?>
	<!-- section contenant les erreurs du formulaire -->
</div>
<?php echo form_open("") ?>
	<h1>Nouvelle location</h1>

	<div>
		<label class="required" for="date_debut">Date de début</label>
		<input type="date" name="date_debut" id="date_debut" required>
	</div>

	<div>
		<label class="required" for="date_retour_prevue">Date prévisionnelle de fin</label>
		<input type="date" name="date_retour_prevue" id="date_retour_prevue" required>
	</div>

	<button type="submit">Louer</button>
</form>
