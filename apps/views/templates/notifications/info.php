<li>  
	<a href="<?php echo $notification_link ?>">
		<span class="label label-sm label-icon label-info"><i class="fa fa-bullhorn"></i></span>
		<?php echo $feed_content?>
		<span class="time pull-right" style="font-weight:normal"><small><?php
        	if( $localize_time ){
            	echo localize_timeline( $createdon, $user['timezone'] );
            }
            else{
               echo $timeline;
            } ?>
		</small></span>
	</a>
</li>