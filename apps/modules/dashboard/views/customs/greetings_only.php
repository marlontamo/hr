<?php 

    $image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
    $image_dir_full  = FCPATH.'uploads/users/';

	$class = $recipient_id === $latest[0]['user_id'] ? 'out' : 'in';
    $avatar = basename(base_url( $latest[0]['photo'] ));

    // determine image/photo

    $file_name_thumbnail = $image_dir_thumb . $avatar;
    $file_name_full = $image_dir_full . $avatar;

    if(file_exists($file_name_thumbnail)){
        $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
    }
    else if(file_exists($file_name_full)){
        $avatar = base_url() . "uploads/users/" . $avatar;
    }
    else{
        $avatar = base_url() . "uploads/users/avatar.png";
    }  
?>

<li class="<?php echo $class; ?>">
    <img 
    	class="avatar img-responsive" 
    	alt="" 
    	src="<?php echo $avatar; ?>" />
    <div class="message">

    	<span class="arrow"></span>
    
        <a href="#" class="name text-success">
            <?php echo $latest[0][ 'display_name']; ?>
        </a>

        <span class="datetime <?php echo $class === 'out' ? 'pull-left' : 'pull-right' ?>">
            <small class="text-muted"><?php echo $latest[0]['time_line']; ?></small>
        </span>
    
        <br/><span class="text-muted small"><?php echo $latest[0]['position']; ?></span>
        <br/>
        <br/><span class="body"><?php echo $latest[0]['content']; ?></span>
    </div>
</li>