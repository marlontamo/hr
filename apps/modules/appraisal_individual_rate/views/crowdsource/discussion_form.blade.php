<div class="modal-body padding-bottom-0">
    @if( $show_form == "true"  )
    <div class="chat-form margin-bottom-20 margin-top-0 @if($status_id=='-1') hidden @endif">
        <form id="note-form">
            <input id="note_to" name="note_to" value="{{$contributor_id}}" type="hidden">
            <input id="appraisal_id" name="appraisal_id" value="{{$appraisal_id}}" type="hidden">
            <input id="user_id" name="user_id" value="{{$user_id}}" type="hidden">
            <input id="created_by" name="created_by" value="{{$user_id}}" type="hidden">
            <input id="section_id" name="section_id" value="{{$section_id}}" type="hidden">
            <div class="input-cont">   
                <input class="form-control" type="text" placeholder="Write your obervation/feedback here..." name="note" id="note"/>
            </div>
            <div class="btn-cont"> 
                <span class="arrow"></span>
                <a href="#" class="btn blue icn-only" id="cs_discussion_button"><i class="fa fa-comments-o icon-white"></i></a>
            </div>
            <span style="margin-top: 10px;" class="pull-left small text-muted">Click Submit To to send back crowdsource.</span>
            
            @if( sizeof($contributor)  )
            <span style="margin-top: 6px;" class="pull-right"> 
                <a class="btn btn-sm green icn-only" id="send_back_crowdsource"> Submit To: {{ $contributor->full_name }}</a>
            </span>
            @endif
        </form>
    </div>
    @endif
    <div class="clearfix">
        <ul class="notes chats observation_feedback">
            @if( $discussions )
                @foreach( $discussions as $discussion )
                    @if($discussion->user_id == $discussion->created_by)
                    <?php $time_position = 'left'; ?>
                        <li class="out">
                    @else
                    <?php $time_position = 'right'; ?>
                        <li class="in">
                    @endif
                        <img src="{{ base_url().$discussion->photo }}" alt="" class="avatar img-responsive">
                        <div class="message">
                            <span class="arrow"></span>
                            <a class="name text-success" href="#">{{ $discussion->full_name }}</a>
                            <span class="datetime pull-{{$time_position}}"><small class="text-muted">{{ $discussion->created_on }}</small></span>
                            <br/>
                            <span class="text-muted small">{{ $discussion->department }}</span>
                            <br/>
                            <span class="body">{{ $discussion->note }}</span>
                        </div>
                    </li>
                @endforeach
            @else
                <li>
                    <div id="no_record" class="well">
                        <p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
                        <span><p class="small margin-bottom-0"></p></span>
                    </div>
                </li> 
            @endif
        </ul>
    </div>
</div>
<script>
    // init_notes();
</script>