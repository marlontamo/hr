<?php
    $code = '';
    if ($time_form_balance_period_from == '0000-00-00' && $time_form_balance_period_to != '0000-00-00'){
        $code = 'Until ' . date('M d, Y', strtotime($time_form_balance_period_to));
    }
    else if ($time_form_balance_period_from != '0000-00-00' && $time_form_balance_period_to != '0000-00-00'){
        $code = date('M d, Y', strtotime($time_form_balance_period_from)) . ' - ' . date('M d, Y', strtotime($time_form_balance_period_to));
    }
?>
<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a href="{{ $edit_url }}" class="text-success">
        {{ $time_form_balance_year }}
        </a>
    </td> 
    <td>
        {{ $time_form_balance_form }}
		<br />
        @if($time_form_balance_period_to != '2099-12-31')
        <span class="help-block" style="font-size:80%">{{ $code }}</span>
        @endif
        <a href="{{ $edit_url }}" class="text-success">
            {{ $time_form_balance_user_id }}
        </a>
    </td>  
    <!-- td>
        {{ $time_form_balance_form }}
    </td -->
    <td class="text-center">
        {{ $time_form_balance_previous }}
    </td>
    <td class="text-center">
        {{ (float) $time_form_balance_current }}
    </td>
    <td class="text-center">
        {{ (float) $time_form_balance_used }}
    </td>
    <td class="text-center">
        {{ (float) $time_form_balance_converted }}
    </td>       
    <td class="text-center">
        {{ (float) $time_form_balance_forfeited }}
    </td>    
    <td class="text-center">
        {{ (float) $time_form_balance_balance }}
    </td>
    
    <td>
      <!--   <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
        </div> -->
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('leave_balance_admin.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('leave_balance_admin.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>