<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>{{ $training_calendar_topic}}</td>
    <td>{{ $training_subject}}</td>
    <td>{{ date('F d, Y', strtotime($start_date)) }} </td>
    <td>{{ date('F d, Y', strtotime($end_date))}}</td>
    <td>{{ date('H:i a', strtotime($sessiontime_from)) }} - {{ date('H:i a', strtotime($sessiontime_to)) }}</td>
    <td>{{ $instructor}}</td>
    <td>
         <a class="btn btn-xs text-muted revalida_participants" href="#" id="revalida_participants" calendar_id="<?php echo $record_id; ?>"><i class="fa fa-search"></i> Participants</a>
    </td>
</tr>

<script type="text/javascript">
$(document).ready(function(){
    $(".revalida_participants").on('click', function() {
        var calendar_id = $(this).attr('calendar_id');
        document.location = 'training_revalida_participants/feedback_list/'+calendar_id;
    });
});
</script>