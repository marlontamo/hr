<li class="in2 border-bottom-hr margin-bottom-3">
	<?php $photo = get_photo( $user['photo'] );?>
	<img class="avatar img-responsive" alt="" src="<?php echo $photo['avatar']?>" style="border-radius:5% !important" />
	<div class="message2">
		<span class="name"><?php echo $user['firstname'].' '.$user['lastname']?></span>
		<br>
		<span class="text-muted position"><?php echo $user_preview->position?> <span class="text-success">at <?php echo $user_preview->company?></span></span></span>

	</div>
</li>
<li class="in2 margin-bottom-3" onclick="lockscreen()">
	<a class="btn btn-primary iconlist"><i class="fa fa-lock"></i></a>
	<div class="listname"><span>Lock Screen</span></div>
</li>
<li class="in2 margin-bottom-3" onclick="logout()">
	<a class="btn btn-primary iconlist"><i class="fa fa-power-off"></i></a>
	<div class="listname"><span>Logout</span></div>
</li>