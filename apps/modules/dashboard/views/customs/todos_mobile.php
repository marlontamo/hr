<?php 
	if( $todos ){
		foreach( $todos as $todo ): ?>
			<li form_id="<?php echo $todo['form_id'] ?>" forms_id="<?php echo $todo['forms_id'] ?>" class="clearfix" href="#pop-ajax-container" >
				<div class="task-title">
					<span class="task-title-sp"><a><?php echo $todo['display_name'] ?></a></span>
					<span class="task-title-sp"><small class="text-muted"><?php
		            	if( $localize_time ){
	                    	echo localize_timeline( $todo['created_on'], $user['timezone'] );
	                    }
	                    else{
	                       echo $todo['createdon'];
	                    } ?>
					</small></span>
					<a class="btn btn-sm green pull-right"><i class="fa fa-search"></i></a>
				</div>

				<?php if(isset($business_group) && sizeof($business_group) > 1){ ?>
	                <div class="task-title">
						<span class="text-success small"><span><?php echo $todo['group']?></span><span>&nbsp;/&nbsp;</span><span><?php echo $todo['company']?></span></span>
					</div>
                <?php }?>
                <div class="small"><?php echo $todo['form'] ?></div>
			</li><?php
		endforeach;
	}
	else{ ?>
		<li class="in" style="margin: 0px 0px 1px 20px;padding: 1px 0px;">
	        <?php echo lang('dashboard.todo_none') ?>
	    </li><?php 
	} 
?>