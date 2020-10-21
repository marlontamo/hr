<li class="<?php echo $current_user === $latest[0]['user_id'] ? 'out' : 'in'; ?>">
    <img class="avatar img-responsive" alt="" src="<?php echo base_url().$latest[0]['avatar']; ?>" />
    <div class="message">
    	<span class="arrow"></span>
    	<span class="<?php echo $current_user === $latest[0]['user_id'] ? 'datetime pull-left' : 'datetime pull-right'; ?>">
    		<small class="text-muted"><?php echo  $latest[0]['createdon']; ?></small>
    	</span>
    	<a href="#" class="name"><?php echo $latest[0]['display_name']; ?></a>
        <br/>
        
        <span class="body"><?php echo $latest[0]['feed_content']; ?></span>
        <br/>
        <span class="label label-sm <?php echo $latest[0]['class'] ?>"><?php echo $latest[0]['message_type'] ?></span>
    </div>
</li>