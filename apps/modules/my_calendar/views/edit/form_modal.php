<div class="modal-content" <?php echo isset($width) ? 'style="width:'. $width . '"' : ''?>>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title"><?php echo $title?></h4>
		<span class="text-muted padding-3 small"><?php echo $forms_title_date ; ?></span>
	</div>
	<?php echo $content; ?>
</div>