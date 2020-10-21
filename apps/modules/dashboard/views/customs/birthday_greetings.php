	            	<?php 
	            		if(count( $greetings )){

							$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
						    $image_dir_full  = FCPATH.'uploads/users/';

	            			for($i=0; $i < count($greetings); $i++){

	            				$class = $celebrant['celebrant_id'] === $greetings[$i]['user_id'] ? 'out' : 'in';
	            				$avatar = basename(base_url( $greetings[$i]['photo'] ));

								$file_name_thumbnail = $image_dir_thumb . $avatar;
						        $file_name_full = $image_dir_full . $avatar;

							    if(file_exists(urldecode($file_name_thumbnail))){
						            $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
						        }
						        else if(file_exists(urldecode($file_name_full))){
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
			                    		<?php echo $greetings[$i]['display_name']; ?>
			                    	</a>

			                    	<span class="datetime <?php echo $class === 'out' ? 'pull-left' : 'pull-right' ?>">
			                    		<small class="text-muted"><?php echo $greetings[$i]['time_line']; ?></small>
			                    	</span>
			                        
			                        <br/>
			                        
			                        <span class="text-muted small"><?php echo $greetings[$i]['position']; ?></span>
			                        <br/>
			                        <br/>
			                        <span class="body"><?php echo $greetings[$i]['content']; ?></span>
			                    </div>
			                </li>
	               	<?php
	               			}
	            		}
	            		else{
	            	?>
	            			<li class="in no-greetings">
	                    		<?php echo lang('dashboard.bday_noconvo') ?> <br />
	                    		<?php echo lang('dashboard.bday_first') ?>
	                    	</li>
	                <?php 
	            		}
	            	?>



<?php
	$isUsed = false;
	if($isUsed){
?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo $celebrant['celebrant_name']; ?><br>
        	<span class="small">
        		<?php echo date("l d, Y", strtotime($celebrant['birth_date'])); ?>
        		<span class="small text-muted"> - Today</span>
        	</span>
        </h4>
    </div>
    <div class="modal-body">
        <div class="chat-form margin-bottom-20 margin-top-0">
            <div class="input-cont">
                <input
                	id="input-greetings-update" 
                	class="form-control" 
                	type="text"
                	data-birthday="<?php echo date("Y-m-d", strtotime($celebrant['birth_date'])); ?>"
                	data-celebrant-id="<?php echo $celebrant['celebrant_id']; ?>"
                	placeholder="<?php echo lang('dashboard.bday_wish') ?>" />
            </div>
            <div id="btn-greetings-update" class="btn-cont">
            	<span class="arrow"></span>
            	<a href="" class="btn blue icn-only">
            		<i id="icn-greetings-update" class="fa fa-gift icon-white"></i>
            		<!-- <i class="fa fa-spinner icon-spin"></i> -->
            	</a>
            </div>
        </div>
        <div class="clearfix">

        	<!-- <div class="scroller" style="height:400px" data-always-visible="1" data-rail-visible1="1"> -->
        	<div data-always-visible="1" data-rail-visible1="1">
	            <ul class="chats greetings_container">

	            	<?php 
	            		if(count( $greetings )){

	            			for($i=0; $i < count($greetings); $i++){

	            				$class = $celebrant['celebrant_id'] === $greetings[$i]['user_id'] ? 'out' : 'in';
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
			                    	<span class="datetime pull-right">
			                    		<small class="text-muted"><?php echo $greetings[$i]['time_line']; ?></small>
			                    	</span>
			                        <br/>
			                        <span class="text-muted small"><?php echo $greetings[$i]['position']; ?></span>
			                        <br/>
			                        <br/>
			                        <span class="body"><?php echo $greetings[$i]['content']; ?></span>
			                    </div>
			                </li>
	               	<?php
	               			}
	            		}
	            		else{
	            	?>
	            			<li class="in no-greetings">
	                    		<?php echo lang('dashboard.bday_noconvo') ?> <br />
	                    		<?php echo lang('dashboard.bday_first') ?>
	                    	</li>
	                <?php 
	            		}
	            	?>
	            </ul>
        	</div>
        </div>
    </div>

<?php
	}
?>
