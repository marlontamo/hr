<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title"><?php echo $title; ?></h4>
		<?php if(isset($description)):?>
		<p class="text-muted small"><?php echo $description?></p>
		<?php endif;?>
	</div>

	<?php echo $content?>
</div>