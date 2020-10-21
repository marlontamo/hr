<tr class="record">
    <td>
    	<span class="text-success">{{ $recruitment_request_position }}</span>
		<br>
		<span id="date_set" class="small">{{ $recruitment_request_document_no }}</span>
	</td>
    <td>
        <span class="text-success">{{ $recruitment_request_department_id }}</span>
		<br>
		<span id="date_set" class="small">{{ $recruitment_request_company_id }}</span>
    </td>
    <td class="hidden-xs">
        <span class="text-primary">{{ $recruitment_request_name }}</span>
        <br>
        <span class="small">Requested Date:</span><br>
        <span class="small">{{ $recruitment_request_created_on_mod }}</span>
        <br>
        <span class="small text-success">Approved Date:</span><br>
        <span class="small text-success">{{ $recruitment_request_date_approved }}</span>  
        <?php
            if ($recruitment_request_status == 'Closed'){
        ?>
                <br>
                <span class="small text-success">Delivered Date:</span><br>
                <span class="small text-success">{{ ($recruitment_request_delivery_date != 'January 01, 1970' ? $recruitment_request_delivery_date : "") }}</span>                    
        <?php
            }
        ?>        
    </td>
    <td>
        <?php 
        	switch( $recruitment_request_status )
        	{
        		case 'Draft':
        			$badge = "badge-default";
        			break;
        		case 'For Approval':
        		case 'On-going':
        			$badge = "badge-warning";
        			break;
                case 'Approved':
                case 'Validated':
                case 'Closed':
        			$badge = "badge-success";
        			break;
        		default:
        			$badge = "badge-error";
        			break;

        	}
        ?>
		<span class="badge {{ $badge }}">
            @if(strtolower($recruitment_request_status) == 'validated')
            Ongoing
            @else
            {{ $recruitment_request_status }}
            @endif
        </span>
<!--         <br>
        @if($recruitment_request_status_id > 1)
            @if(strtotime($recruitment_request_hr_remarks_on))
                <span class="small text-muted hidden-xs">{{date('M d, Y H:i:s', strtotime($recruitment_request_hr_remarks_on))}}</span>
            @elseif(strtotime($recruitment_request_modified_on))
                <span class="small text-muted hidden-xs">{{date('M d, Y H:i:s', strtotime($recruitment_request_modified_on))}}</span>
            @else
                <span class="small text-muted hidden-xs">{{date('M d, Y H:i:s', strtotime($recruitment_request_created_on))}}</span>
            @endif
        @endif    -->
    </td>
    <td>
       
        @if($recruitment_request_status == "Disapproved")
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i>  {{ lang('common.edit') }}</a>
                <!-- <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-info"></i> {{ lang('common.view') }}</a> -->
            </div>
        @else
             <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}">
                @if($recruitment_request_status_id == 1)
                   <i class="fa fa-pencil"></i>  {{ lang('common.edit') }}
                @else
                   <i class="fa fa-info"></i> {{ lang('common.view') }}
                @endif
                </a>
            </div>    
        @endif    
        @if(strlen($options)>1)
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
        @endif
    </td>
</tr>
