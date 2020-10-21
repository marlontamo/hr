<tr class="record">
    <!-- <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td> -->
   <!--  <td>
        <a href="{{ $detail_url }}">
            {{ $time_form_balance_year  }}
        </a>
    </td> -->
    <td>
        <a href="{{ $detail_url }}">
        @if(strtotime($time_form_balance_period_from) && strtotime($time_form_balance_period_to))
        {{ $time_form_balance_period_from }}  &nbsp; - &nbsp; {{ $time_form_balance_period_to }}
        @endif
        </a>
    </td>
     <td>
        {{ $time_form_balance_form }}
    </td>

    <td>
        {{ $time_form_balance_current }}
    </td>
    <td>
        {{ $time_form_balance_used }}
    </td>
    <td>
        {{ $time_form_balance_balance }}
    </td>
    
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
        </div>
    </td>
</tr>