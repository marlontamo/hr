<tr class="record">my
	<td class="hidden-xs">
        &nbsp;
	</td>
    <td>
    	<span class="text-success"> 
    		{{ date('F d, Y', strtotime($payroll_date)) }}
    	</span>
    	<br>
    	<span class="text-muted small">
    		{{ date('l', strtotime($payroll_date)) }} 
    	<span>
    </td>
    <td>
    	<span class="text-muted"> 
    		{{ date('F j', strtotime($date_from)) }} to {{ date('F j, Y', strtotime($date_to)) }}
    	</span>
    </td>

	<td>
		<div class="btn-group">
			<a id="my_payslip" class="btn btn-xs text-muted" href="javascript:check_passwords( {{$record_id }}, '{{ date('Y-m-d', strtotime($payroll_date)) }}'  )"><i class="fa fa-file-text-o"></i> Payslip</a>
            <a id="my_payslip" class="btn btn-xs text-muted" href="javascript:check_details( {{$record_id }}, '{{ date('Y-m-d', strtotime($payroll_date)) }}'  )"><i class="fa fa-list-ul"></i> Details</a>
	    </div>
    </td>
</tr>