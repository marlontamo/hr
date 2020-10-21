@foreach($approvers as $approver)
	<tr>
    	<td colspan="2" align="right" ><span class="text-right"><strong>{{ $approver['display_name'] }}</strong>:</span> </td>
    	<td colspan="4">
    		{{ $approver['comment'] }}								              
    	</td>
	</tr>
@endforeach