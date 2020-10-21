<div class="modal-header">
    <h4 class="modal-title" id="dlg-title"><?php echo $celebrant['celebrant_name']?><br>
    	<span class="small">
    		<?php echo date("l d, Y"); ?>
    		<span class="small text-muted"> - Today</span>
    	</span>
    </h4>
</div>
<div class="modal-body">
    <div class="chat-form margin-bottom-20 margin-top-0">
        <div class="input-cont">
            <input id="input-greetings-update" class="form-control" type="text" data-birthday="<?php echo date("Y-m-d", strtotime( $celebrant['birth_date'] ))?>" data-celebrant-id="<?php echo $celebrant['celebrant_id']?>" placeholder="Write a birthday wish..." />
        </div>
        <div id="btn-greetings-update" class="btn-cont">
        	<span class="arrow"></span>
        	<a href="" class="btn blue icn-only" style="padding: 9px 14px">
        		<i id="icn-greetings-update" class="fa fa-gift icon-white"></i>
        	</a>
        </div>
    </div>
    <div class="clearfix">
		<div data-always-visible="1" data-rail-visible1="1">
            <ul id="birthday-greetings" class="chats greetings_container"><?php
            	if(count( $greetings )){
            		for($i=0; $i < count($greetings); $i++){
            			$photo = get_photo( $greetings[$i]['photo'] );	
            			$class = $celebrant['celebrant_id'] === $greetings[$i]['user_id'] ? 'out' : 'in'; ?>
            			<li class="<?php echo $class; ?>">
            				<img class="avatar img-responsive" alt="" src="<?php echo $photo['avatar']; ?>" />
            				<div class="message">
            					<span class="arrow"></span>
            					<a href="#" class="name text-success"><?php echo $greetings[$i]['display_name']; ?></a>
            					<span class="datetime <?php echo $class === 'out' ? 'pull-left' : 'pull-right' ?>">
									<small class="text-muted"><?php echo $greetings[$i]['time_line']; ?></small>
								</span>

								<br/>

								<span class="text-muted small"><?php echo $greetings[$i]['position']; ?></span>
								<br/>
								<br/>
								<span class="body"><?php echo $greetings[$i]['content']; ?></span>
            				</div>
            			</li><?php
            		}
            	}
            	else{ ?>
					<li class="in no-greetings">
						<?php echo lang('dashboard.bday_noconvo') ?> <br />
						<?php echo lang('dashboard.bday_first') ?>
					</li><?php 
            	}?>
            </ul>
    	</div>
    </div>
</div>