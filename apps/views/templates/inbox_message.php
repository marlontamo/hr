<li>  
	<a href="javascript:open_chat(<?php echo $from?>)">
		<span class="photo"><img src="<?php echo base_url( $photo ) ?>" alt=""/></span>
		<span class="subject">
			<span class="from"><?php echo $from_name?></span>
			<span class="time" style="font-weight:normal"><small> <?php
            	if( $localize_time ){
                	echo localize_timeline( $time, $user['timezone'] );
                }
                else{
                   echo $timeline;
                } ?>
			</small></span>
		</span>
		<span class="message">
			<?php
				if(strlen( $message ) < 25)
				{
					echo $message;
				}
				else{
					echo substr( $message, 0, 24).'...';
				}
			?>
		</span>  
	</a>
</li>