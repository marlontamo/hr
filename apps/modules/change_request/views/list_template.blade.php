<tr class="record">
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $partners_personal_request_employee_id }}</a>
        <br>
        <span class="text-muted small">{{ $partners_personal_request_id_number }}</span>
    </td>
    <td>
        {{ date( 'M-d', strtotime( $partners_personal_request_created_on ) ) }}
        <span class="text-muted small">
            {{ date( 'D', strtotime( $partners_personal_request_created_on ) ) }}
        </span>
        <br>
        <span class="text-muted small">{{ date( 'Y', strtotime( $partners_personal_request_created_on ) ) }}</span>
    </td>
    <td>
        <span class="label label-info">{{ $partners_personal_request_changes }}</span>
    </td>
    <td>
        <?php
            switch( $partners_personal_request_status )
            {
                
                case "For Approval":
                    $badge = 'badge-warning';
                    break;
                case "Approved":
                    $badge = 'badge-success';
                    break;
            	case "Declined":
            		$badge = 'badge-danger';
                    break;
            	case "Draft":
            	default:
                    $badge = 'badge-default';
                    break;
                   
            }
        ?>
        <span class="badge {{ $badge }}">{{ $partners_personal_request_status }}</span>
    </td>
    <td>
        <div class="btn-group">
            {{ $view_url }}
        </div>
        @if( !empty($options) )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                <ul class="dropdown-menu pull-right">
                    {{ $options }}
                </ul>
            </div>
        @endif
    </td>
</tr>