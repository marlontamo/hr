<div class="portlet" class="">
	<div class="portlet-body">
		<div class="chat-form margin-bottom-20 margin-top-20">
			<textarea id="feed-comment" feed_id="<?php echo $feed_id?>" class="form-control" placeholder="Something you want to say here..."></textarea>
			<div class="clearfix margin-top-5">
				<div class="text-muted small pull-left">
						<span class="padding-5"><?php echo sizeof( $likes )?> likes</span>
						<span class="padding-5"><?php echo sizeof( $comments )?> comments</span>
					</div>
				<div class="btn btn-success btn-sm pull-right" id="send-comment">Send Comments</div>
			</div>
		</div>

		<div class="clearfix">
			<ul class="chats feed-comments"><?php echo $comments?></ul>
		</div>
	</div>	
</div>