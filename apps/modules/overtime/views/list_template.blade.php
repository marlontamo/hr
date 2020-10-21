<tr class="record">
    <td>
    	{{ date("M-d",strtotime($date)) }}
    	<span class="text-muted small">
    		{{ date("D",strtotime($date)) }}
    	</span><br>
        <span class="text-muted small">
        	{{ date("Y",strtotime($date)) }}
        </span>
    </td>
    <td>
    	{{ date("h:i A",strtotime($time_from)) }}
    	<br>
        <span class="text-muted small">
    	{{ date("M-d",strtotime($time_from)) }}
        </span>
    </td>
    <td>
    	{{ date("h:i A",strtotime($time_to)) }}
    	<br>
        <span class="text-muted small">
    	{{ date("M-d",strtotime($time_to)) }}
        </span>
    </td>
    <td class="text-right">
    	{{ $actual }}
    </td>
    <td class="text-right">
    	{{ $break }}
    </td>
    <td class="text-right">
    	{{ $hrs }}
    </td>
    <td class="text-right">
    	{{ $meal }}
    </td>
    <td class="text-right">
    	{{ $transpo }}
    </td>
</tr>