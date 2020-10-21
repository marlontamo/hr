<form id="discussion-form">
	<div class="panel panel-info">
		<!-- Default panel contents -->
		<div class="panel-heading">
			<h4 class="panel-title">{{ lang('erequest.discussion_log') }}</h4>
		</div>
		<div class="panel-body">
	        <input name="status_id" value="{{ $record['request_status_id'] }}" type="hidden">
	        <input name="request_id" value="{{ $record_id }}" type="hidden">
	        <input name="user_id" value="{{ $record['resources_request.user_id'] }}" type="hidden">
			<div class="chat-form margin-bottom-20 margin-top-0 @if($record['view']=='detail') hidden @endif">
				<div class="input-cont">   
					<input type="text" placeholder="{{ lang('erequest.write_comments') }}..." class="form-control" name="discussion_notes" id="discussion_notes">
				</div>
				<div class="btn-cont"> 
					<span class="arrow"></span>
					<a class="btn blue icn-only" name="discussion_notes_btn" id="discussion_notes_btn"><i class="fa fa-comments-o icon-white"></i></a>
				</div>
			</div>
			
	        <ul class="notes chats discussions">
	        	@if(!empty($notes))
	            @foreach( $notes as $note )
	                @if($note->user_id == $note->created_by)
	                <?php $time_position = 'left'; ?>
	                    <li class="out">
	                @else
	                <?php $time_position = 'right'; ?>
	                    <li class="in">
	                @endif
	                    <img src="{{ base_url().$note->photo }}" alt="" class="avatar img-responsive">
	                    <div class="message">
	                        <span class="arrow"></span>
	                        <a class="name text-success" href="#">{{ $note->full_name }}</a>
	                        <span class="datetime pull-{{$time_position}}"><small class="text-muted">{{ $note->timeline }}</small></span>
	                        <br/>
	                        <span class="text-muted small">{{ $note->department }}</span>
	                        <br/>
	                        <span class="body">{{ $note->notes }}</span>
	                    </div>
	                </li>
	            @endforeach
	            @endif
	        </ul>
		</div>
	</div>
</form>