<tr class="record">
 <!--    <td class="hidden-xs">
        <div>
            
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td> -->
    <td>
        <a href="{{ $detail_url }}" class="text-success">
            {{ $time_form_balance_year  }}
        </a>
        @if($time_form_balance_period_to != '2099-12-31')
         <span class="help-block" style="font-size:80%">{{ ($time_form_balance_period_from == '0000-00-00') ? 'Until' : date('M d, Y', strtotime($time_form_balance_period_from)) . ' - ' }} {{   date('M d, Y', strtotime($time_form_balance_period_to)) }}</span>
        @endif

    </td>
     <td>
        {{ $time_form_balance_form }}
    </td>
    <td>
        {{ $time_form_balance_previous }}
    </td>
    <td >
        {{ (float) $time_form_balance_current }}
    </td>
    <td >
        {{ (float) $time_form_balance_used }}
    </td>
    <td >
        {{ (float) $time_form_balance_converted }}
    </td>        
    <td >
        {{ (float) $time_form_balance_forfeited }}
    </td>    
    <td >
        {{ (float) $time_form_balance_balance }}
    </td>
    
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('leave_balance.view') }}</a>
        </div>
    </td>
</tr>