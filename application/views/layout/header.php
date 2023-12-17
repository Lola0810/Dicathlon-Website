<?php 
	if(!isset($_SESSION)) 
		session_start() 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title ?> - Dicathlon </title>
	<link rel="stylesheet" href="<?php echo base_url("css/style.css")?>"/>
</head>

<body>
    <header>
        <nav  class="header"> 
			<img src="<?php echo base_url("assets/icons/Dicathlon.svg")?>" alt="logo Dicathlon">
			<li class="Accueil"><a href="<?php echo base_url()?>">Home</a></li>
			<li class="Produits"><a href="<?php echo base_url("produits")?>">Produits</a></li>
			
			<?php if(isset($_SESSION["user"])) { ?>
				<li class="Profile"><a href="<?php echo base_url("profil")?>">Mon profil</a></li>
				<?php if(@$_SESSION["user"]["type_utilisateur"] === "admin") { ?>
					<li class="Agent"><a href="<?php echo base_url("nouveau-agent")?>">Créer un agent</a></li>
				<?php } ?>
				<li class="Location"><a href="<?php echo base_url("locations")?>">Locations</a></li>

				<li class="Deconnexion"><a href="<?php echo base_url("deconnexion");?>">Déconnexion</a></li>
			<?php } else { ?>
				<li class="Inscription"><a href="<?php echo base_url("inscription")?>">Inscription</a></li>
				<li class="Connexion"><a href="<?php echo base_url("connexion")?>">Connexion</a></li>
			<?php } ?>
		</nav>
    </header>
