    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $celebrant['celebrant_name']; ?><br>
        	<span class="small">
        		<?php echo date("F d, Y", strtotime($celebrant['birth_date'])); ?>
        		<span class="small text-muted"> -  <?=date("l", strtotime($celebrant['birth_date']))?></span>
        	</span>
        </h4>
    </div>
    <div class="modal-body">
    <?php if ($celebrant['greet']):?>
        <div class="chat-form margin-bottom-20 margin-top-0" style='overflow: visible;'>
            <div class="input-cont">
                <input
                	id="input-greetings-update" 
                	class="form-control" 
                	type="text"
                	data-birthday="<?php echo date("Y-m-d", strtotime($celebrant['birth_date'])); ?>"
                	data-celebrant-id="<?php echo $celebrant['celebrant_id']; ?>"
                	placeholder="Greet <?php echo $celebrant['celebrant_name']; ?> it's his/her birthday!" />
            </div>
            <div id="btn-greetings-update" class="btn-cont">
            	<span class="arrow"></span>
            	<a href="" class="btn blue icn-only">
            		<i id="icn-greetings-update" class="fa fa-gift icon-white"></i>
            		<!-- <i class="fa fa-spinner icon-spin"></i> -->
            	</a>
            </div>
        </div>
    <?php endif;?>
        <div class="clearfix">

        	<!-- <div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1"> -->
        	<div data-always-visible="1" data-rail-visible1="1">
	            <ul class="chats greetings_container">

	            	<?php 
	            		if(count( $greetings )){

	            			for($i=0; $i < count($greetings); $i++){
	            				
	            				$class = $celebrant['celebrant_id'] == $greetings[$i]['user_id'] ? 'out' : 'in';
	            				$class2 = $celebrant['celebrant_id'] == $greetings[$i]['user_id'] ? 'pull-left' : 'pull-right';
	            	?>

			                <li class="<?php echo $class; ?>">
			                    <img 
			                    	class="avatar img-responsive" 
			                    	alt="" 
			                    	src="<?php echo @getimagesize(base_url().$greetings[$i]['photo']) ? base_url().$greetings[$i]['photo'] : base_url().'uploads/users/avatar.png' ?>" />
			                    
			                    <div class="message">
			                    	<span class="arrow"></span>
			                    	<a href="#" class="name text-success">
			                    		<?php echo $greetings[$i]['display_name']; ?>
			                    	</a>
			                    	<span class="datetime <?=$class2?>">
			                    		<small class="text-muted">
			                    			<?php
							            	if( $localize_time ){
						                    	echo localize_timeline( $greetings[$i]['createdon'], $user['timezone'] );
						                    }
						                    else{
						                    	echo $greetings[$i]['time_line'];
						                    } ?>
			                    			

			                    		</small>
			                    	</span>
			                        <br/>
			                        <span class="text-muted small"><?php echo $greetings[$i]['position']; ?></span>
			                        <br/>
			                        <span class="body"><?php echo $greetings[$i]['content']; ?></span>
			                    </div>
			                </li>
	               	<?php
	               			}
	            		}
	            		else{
	            	?>
	            			<li class="in">
	                    		<?php echo lang('birthdays.no_conversation') ?> <br />
	                    		<?php if ($celebrant['greet']):?>
	                    			<?php echo lang('birthdays.be_first') ?>
	                    		<?php endif;?>
	                    	</li>
	                <?php 
	            		}
	            	?>
	            </ul>
        	</div>
        </div>
    </div>