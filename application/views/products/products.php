<main class="catalogue">
	<div class="container-card">
		<?php if($user && in_array($user["type_utilisateur"], ["admin", "agent"])) { ?>
			<a href="<?php echo base_url("produits/nouveau");?>">
				<button class="button">Nouveau produit</button>
			</a>
		<?php } ?>

		<?php foreach($products as $product) { ?>
			<div class="card">
				<img src="<?php echo base_url("assets/img/tapis.jpg");?>" alt="Tapis">
				<h2><?php echo $product["type"] ?></h1>
				<h3><?php echo $product["prix_location"]; ?>€</h3>
				<a href="<?php echo base_url("produit/")?><?php echo $product["id"]; ?>">
					<button class="bouton-card">Voir le produit</button>
				</a>
		</div>
		<?php } ?>
	</div>
</main>