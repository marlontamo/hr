<?php 
	//$class = $celebrant['celebrant_id'] === $latest[0]['user_id'] ? 'out' : 'in';
    $class = $recipient_id === $latest[0]['user_id'] ? 'out' : 'in';
	$class2 = $recipient_id === $latest[0]['user_id'] ? 'pull-left' : 'pull-right';
?>

<li class="<?php echo $class; ?>">
    <img 
    	class="avatar img-responsive" 
    	alt="" 
    	src="<?php echo @getimagesize(base_url().$latest[0]['photo']) ? base_url().$latest[0]['photo'] : base_url().'uploads/users/avatar.png' ?>" />
    <div class="message">
    	<span class="arrow"></span>
        <a href="#" class="name text-success">
            <?php echo $latest[0][ 'display_name']; ?>
        </a><span class="datetime <?=$class2?>"><small class="text-muted"><?php echo $latest[0]['time_line']; ?></small></span>
        <br/><span class="text-muted small"><?php echo $latest[0]['position']; ?></span>
        <br/><span class="body"><?php echo $latest[0]['content']; ?></span>
    </div>
</li>