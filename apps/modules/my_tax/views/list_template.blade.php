<tr class="record">
	<td class="hidden-xs"> &nbsp;
	</td>
    <td>
    	<span class="text-success"> 
    		{{ $year }}
    	</span>
    </td>
    <td>
    	<span class="text-success"> 
    		{{ $month }}
    	</span>
    </td>
    <td>
    	<span class="text-info"> 
            @if($WTax > 0)
                {{ number_format($WTax, 2, '.', ',') }}
            @else
                -
            @endif
    	</span>
    </td>

	<!-- <td>
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View Payslip</a>
	    </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td> -->
</tr>