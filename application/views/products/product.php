<main class="produit">
	<?php if(@$user["type_utilisateur"] === "admin") { ?>
		<?php echo form_open('', [], ["type" => "delete_product"]); ?>
			<button>Supprimer le produit</button>
		</form>
	<?php } ?>

	<a href="<?php echo base_url("produits");?>">
		<button class="button">Retour aux produits</button>
	</a>

	<div class="container-produit">
		<img src="<?php echo base_url("assets/img/tapis.jpg")?>" alt="Tapis">
		<div class="description">
			<h1><?php echo $product["type"] ?></h1>
			<h2>Etat: <?php echo $product["etat"] ?></h3>
			<h2><?php echo $product["prix_location"] ?>€</h4>
			<h3>Marque: <?php echo $product["marque"]?></h3>
			<span></span>
			<h3>Description du produit</h3>
			<p><?php echo $product["description"] ?></p>


			<?php if(isset($_SESSION["user"])) { ?>
			<a href="<?php echo base_url("produits/louer/");?><?php echo $product["id"] ?>">
 				<button class="button">Louer ce produit</button>
			</a>
			<?php } else { ?>
			<a href="<?php echo base_url("connexion");?>">
				<button class="button" disabled>Louer ce produit</button>
				<p>Connectez-vous pour réserver ce produit.</p>
			</a>
			<?php } ?>
		</div>
	</div>
	
</main>
