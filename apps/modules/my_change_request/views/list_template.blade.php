<tr class="record">
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $key_label }}</a>
    </td>
    <td>
        <?php
            // switch( $key_code )
            // {
            //     case 'city_town':
            //         $db->limit('1');
            //         $city = $db->get_where('cities', array('city_id' => $key_value))->row();
            //         $key_value = $city->city;
            //         break;
            //     case 'country':
            //         $db->limit('1');
            //         $country = $db->get_where('countries', array('country_id' => $key_value))->row();
            //         $key_value = $country->long_name;
            //         break;
            //     case 'civil_status':
            //         $db->limit('1');
            //         $status = $db->get_where('partners_civil_status', array('civil_status_id' => $key_value))->row();
            //         $key_value = $status->civil_status;
            //         break;
            //     case 'gender':
            //         $key_value = ucfirst( $key_value );
            //         break;
            // }
        ?>

        {{ $key_value }}
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
        {{ date( 'M-d', strtotime( $partners_personal_request_created_on ) ) }}
        <span class="text-muted small">
            {{ date( 'D', strtotime( $partners_personal_request_created_on ) ) }}
        </span>
        <br>
        <span class="text-muted small">{{ date( 'Y', strtotime( $partners_personal_request_created_on ) ) }}</span>
    </td>
    <td>
        @if( $partners_personal_request_status == "Draft" )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" onclick="show_cr_form()"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
        @endif
        
        @if( !empty($options) && $partners_personal_request_status_id < 3)
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                <ul class="dropdown-menu pull-right">
                    {{ $options }}
                </ul>
            </div>
        @endif
    </td>
</tr>