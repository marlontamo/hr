<tr class="record">
    <!-- <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td> -->
    <td>
        <a href="{{ $detail_url }}">
            {{ $time_form_balance_year  }}
        </a>
    </td>
     <td>
        {{ $time_form_balance_form }}
    </td>
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
    @if($time_form_balance_balance < 0 )
        0.000
    @else
        {{ $time_form_balance_balance }}
    @endif
    </td>
    
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
        </div>
    </td>
</tr>