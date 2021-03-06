<tr class="record">
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $system_sms_queue_to }}</a>
        <br>
    	@if( !empty($system_sms_queue_timein) )
        	<span class="text-muted small">{{ $system_sms_queue_timein }}</span>
        @endif
    </td>
    <td>
        <span >{{ $system_sms_queue_subject }}</span>
    </td>
    <td>
    	@if( $system_sms_queue_status == 'sent' )
			<span class="badge badge-success">{{ ucwords( $system_sms_queue_status ) }}</span>
    	@else
			<span class="badge badge-warning">{{ ucwords( $system_sms_queue_status ) }}</span>
    	@endif
    </td>
    <td>
    	@if( !empty($system_sms_queue_sent_on) )
	        {{ date( 'M-d', strtotime( $system_sms_queue_sent_on ) ) }}
	        <span class="text-muted small">
	            {{ date( 'D', strtotime( $system_sms_queue_sent_on ) ) }}
	        </span>
	        <br>
	        <span class="text-muted small">
	        	{{ date( 'Y', strtotime( $system_sms_queue_sent_on ) ) }}
	        </span>
        @endif
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $quickview_url }}"><i class="fa fa-search"></i> View</a>
        </div>
        <!-- @if( !empty($options) )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
                <ul class="dropdown-menu pull-right">
                    {{ $options }}
                </ul>
            </div>
        @endif -->
    </td>
</tr>