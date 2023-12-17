<section>
	<?php foreach($locations as $location) { ?>
		<article>
			<?php var_dump($location); ?>
			<a href="<?php echo base_url("location/".$location["id"]) ?>">
				<button>Voir la location</button>
			</a>
		</article>
	<?php } ?>
</section>
