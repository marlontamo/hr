<tr class="record">
    <td>
    	<span class="text-success"> 
    		{{ $description }}
    	</span>
    	<br>    	
    	<span class="text-muted small"> 
    		{{ date('F d, Y', strtotime($entry_date)) }} / {{ $loan_status }}
        </span>
    </td>
    <td>
    	<span class="text-muted"> 
    		{{ number_format($lprincipal, '2', '.', ',') }}
    	</span>
    </td>
    <td>
    	<span class="text-muted"> 
    		{{ number_format($linterest, '2', '.', ',') }}
    	</span>
    </td>
    <td>
    	<span class="text-info"> 
    		{{ number_format($lamount, '2', '.', ',') }}
    	</span>
    </td>

	<td>
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View </a>
	    </div>
        <!-- <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div> -->
    </td>
</tr>