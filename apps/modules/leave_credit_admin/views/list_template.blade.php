<tr class="record">
    <!-- <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td> -->
    <td>
        <a href="{{ $detail_url }}" >
        @if(strtotime($time_form_balance_period_from) && strtotime($time_form_balance_period_to))
        {{ $time_form_balance_period_from }}  &nbsp; - &nbsp; {{ $time_form_balance_period_to }}
        @else
        {{ $time_form_balance_year }}
        @endif
        </a>
    </td>
    <td >
            <span class="text-success">
                {{ $time_form_balance_user_id  }}
            </span>
    </td>

    @if( !in_array($form_code, array('VL', 'ADDL', 'SL')) )
         <td>
            {{ $time_form_balance_form }}
            <br>
            <span class="text-info small"> 
            
            </span>
        </td>
        <td>
            {{ $time_form_balance_used }}
        </td>
    @else
   <!--  <td>
        @if( strtotime($effectivity_date) && in_array($form_code, array('VL')) )
            {{ date('d M', strtotime($effectivity_date)) }} <br>
            <span class="small text-info">
                {{ date('Y', strtotime($effectivity_date)) }}
                - 
                {{ date('Y', strtotime( '+1 year', strtotime($effectivity_date) )) }}
            </span>
        @endif
    </td> -->

        <td>
            {{ $time_form_balance_current }}
        </td>
        <td>
            {{ $time_form_balance_used }}
        </td>
        <td>
        @if( !in_array($form_code, array('VL')) )
            @if($time_form_balance_balance < 0 )
                0.000
            @else
                {{ $time_form_balance_balance }}
            @endif
        @else
            {{ $time_form_balance_balance }}
        @endif
        </td>
    @endif
    
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
        </div>
    </td>
</tr>