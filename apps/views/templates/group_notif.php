<li>  
	<a href="<?php echo site_url( $url ) ?>">
		<?php $photo = get_photo( $photo )?>
		<span class="photo"><img alt="" src="<?php echo $photo['avatar'] ?>"></span>
		<span class="subject">
		<span class="from"><?php echo $type ?></span>
		<span style="font-weight:normal" class="time">
			<small><?php echo $timeline?></small>
		</span>
		</span>
		<span class="message">
		<small>
			<?php 
					echo $notif;
			?>
		</small>
		</span>  
	</a>
</li>