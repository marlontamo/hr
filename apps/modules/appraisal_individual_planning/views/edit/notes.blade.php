<div class="modal-body padding-bottom-0">
    <div class="chat-form margin-bottom-20 margin-top-0">
        <form id="note-form">
            <input name="status_id" value="{{ $status_id }}" type="hidden">
            <div class="input-cont">   
                <input class="form-control" type="text" placeholder="Write your comments here..." name="notes"/>
            </div>
            <div class="btn-cont"> 
                <span class="arrow"></span>
                <a href="javascript:add_note()" class="btn blue icn-only"><i class="fa fa-comments-o icon-white"></i></a>
            </div>
        <form id="note-form">
    </div>

    <div class="clearfix">
        <ul class="notes chats">
            @foreach( $notes as $note )
                @if($note->user_id == $note->created_by)
                    <li class="out">
                @else
                    <li class="in">
                @endif
                    <img src="{{ $note-photo }}" alt="" class="avatar img-responsive">
                    <div class="message">
                        <span class="arrow"></span>
                        <a class="name text-success" href="#">{{ $note->full_name }}</a>
                        <span class="datetime pull-left"><small class="text-muted">{{ $note->timeline }}</small></span>
                        <br/>
                        <span class="text-muted small">{{ $note->department }}</span>
                        <br/>
                        <span class="body">{{ $note->notes }}</span>
                    </div>
                </li>
            @endforeach 
        </ul>
    </div>
</div>
<script>
    init_notes();
</script>