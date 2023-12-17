<a href="/produits">
	<button>Retour aux produits</button>
</a>
<div role="dialog">
	<?php echo validation_errors(); ?>
	<!-- section contenant les erreurs du formulaire -->
</div>
<?php echo form_open("") ?>
	<h1>Nouveau produit</h1>

	<div>
		<label class="required" for="type">Type</label>
		<input type="text" name="type" id="type" required>
	</div>
	<div>
		<label class="required" for="description">Description</label>
		<textarea id="description" name="description" required></textarea>
	</div>
	<div>
		<label class="required" for="marque">Marque</label>
		<input type="text" name="marque" id="marque" required>
	</div>
	<div>
		<label class="required" for="modele">Modèle</label>
		<input type="text" name="modele" id="modele" required>
	</div>
	<div>
		<label class="required" for="prix_location">Prix location</label>
		<input type="number" name="prix_location" id="prix_location" required>
	</div>
	<div>
		<label class="required" for="etat">Etat</label>
		<select id="etat" name="etat">
			<option>Neuf</option>
			<option>Moyen</option>
			<option>Bon</option>
		</select>
	</div>
	<button type="submit">Créer le produit</button>
</form>
