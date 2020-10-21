<div class="modal-body padding-bottom-0">
    <div class="chat-form margin-bottom-20 margin-top-0 {{$hidden}}">
        <form id="note-form">
            <input id="message_type" name="message_type" value="Feedback" type="hidden">
            <input id="user_id" name="user_id" value="{{$user_id}}" type="hidden">
            <div class="input-cont">   
                <input class="form-control" type="text" placeholder="Write your obervation/feedback here..." name="observation_message" id="observation_message"/>
            </div>
            <div class="btn-cont"> 
                <span class="arrow"></span>
                <a href="#" class="btn blue icn-only" id="observation_button"><i class="fa fa-comments-o icon-white"></i></a>
            </div>
        </form>
    </div>

    <div class="clearfix">
        <ul class="notes chats observation_feedback">
            @foreach( $observations as $observation )
                <li class="in">
                    <img src="{{ base_url().$observation->photo }}" alt="" class="avatar img-responsive">
                    <div class="message">
                        <span class="arrow"></span>
                        <a class="name text-success" href="#">{{ $observation->full_name }}</a>
                        <span class="datetime pull-right"><small class="text-muted">{{ $observation->timeline }}</small></span>
                        <br/>
                        <span class="text-muted small">{{ $observation->department }}</span>
                        <br/>
                        <span class="body">{{ $observation->feed_content }}</span>
                    </div>
                </li>
            @endforeach 
        </ul>
    </div>
</div>
<script>
    // init_notes();
</script>