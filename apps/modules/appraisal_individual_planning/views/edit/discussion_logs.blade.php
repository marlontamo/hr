<div class="modal-body padding-bottom-0">
    @if($planning->status_id != 4)
        <form id="discussion-form">
            <div class="chat-form margin-bottom-20 margin-top-0 @if($status_id=='-1') hidden @endif">
                <input name="status_id" value="{{ $status_id }}" type="hidden">
                <input name="planning_id" value="{{ $planning_id }}" type="hidden">
                <input name="user_id" value="{{ $user_id }}" type="hidden">
                <div class="input-cont">   
                    <input class="form-control" type="text" placeholder="Write your comments here..." name="discussion_notes" id="discussion_notes"/>
                </div>
                <div class="btn-cont "> 
                    <span class="arrow"></span>
                    <a name="discussion_notes_btn" id="discussion_notes_btn" class="btn blue icn-only"><i class="fa fa-comments-o icon-white"></i></a>
                </div>
                <!-- <div class="input-group-btn"> 
                    <a href="javascript:add_note()" class="btn green icn-only"><i class="fa fa-check icon-white"></i></a>
                </div> -->
                <?php if( !empty( $status_id ) ):?>
                <span class="pull-left small text-muted" style="margin-top: 10px;">Click Submit To to send planning automatically.</span>
                <span class="pull-right" style="margin-top: 6px;"> 
                    <a href="javascript:add_note()" class="btn btn-sm green icn-only" > Submit To: {{$sent_to}}</a>
                </span>
            <?php endif;?>
            </div>
        </form>
    @endif
    <div class="clearfix">
    @if( count($notes) > 0 )
        <ul class="notes chats discussions">
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
        </ul>
    @else
        No Records Found.
    @endif
    </div>
</div>
<script>
    init_notes();
</script>