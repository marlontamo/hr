<li class="<?php echo $user['user_id'] == $comment->user_id ? 'out' : 'in'?>" feed_comment_id="<?php echo $comment->feeds_comment_id?>">
	<?php $photo = get_photo( $comment->photo )?>
	<img class="avatar img-responsive" alt="" src="<?php echo $photo['avatar']?>" />
	<div class="message">
		<span class="arrow"></span>
		<span 
			class="name text-success popovers"
			data-placement="top" 
			data-original-title="User" style="cursor: pointer;"><?php echo $comment->full_name?>
		</span>
		<span class="datetime pull-right"><small class="text-muted"><?php echo $comment->timeline?></small></span>
		<br />
		<span class="text-muted small"><?php echo $comment->position?></span>
		<br />
		<span class="body">
		<?php echo $comment->comment?>
		</span>
	</div>
</li>