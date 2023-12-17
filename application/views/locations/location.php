<?php if($_SESSION["user"]["type_utilisateur"] === "client") { ?>
<?php echo form_open('', [], ["type" => "delete_location"]); ?>
	<button>Annuler la location</button>
</form>
<?php } ?>

<?php if(in_array($user["type_utilisateur"], ["admin", "agent"]) && @$location["date_retour_effective"] === NULL) { ?>
	<?php echo form_open('', [], ["type" => "getback_location"]); ?>
		<button>Marquer comme rendu</button>
	</form>
<?php } ?>

<?php var_dump($location); ?>
