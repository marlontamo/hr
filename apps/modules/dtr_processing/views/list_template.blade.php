<tr class="record">
	<td>
		<a class="text-success" data-toggle="modal" href="#process" id="period_year">{{ $period_year }}</a>
		<br>
		<span class="small text-muted" id="period_month">{{ $period_month }}</span>
	</td>
	<td>
		<span class="small text-muted" id="count">{{ $proces_status }}</span>
	</td>
	<td>
		<a class="text-success" data-toggle="modal" href="#process" id="period_from">{{ $payroll_date }}</a>
		<br>
		<span class="small text-muted" id="company_name">{{ $company }}</span>
	</td>
	<td class="hidden-xs">
		<span id="period_from">{{ $date_from }} <span class="small text-muted" id="period_from_dayname">{{ $date_from_day }}</span></span>
		<br>
		<span class="small text-muted" id="period_month">{{ $date_from_year }}</span>
	</td>
	<td class="hidden-xs">
		<span id="period_to">{{ $date_to }} <span class="small text-muted" id="period_to_dayname">{{ $date_to_day }}</span></span>
		<br>
		<span class="small text-muted" id="period_month">{{ $date_to_year }}</span>
	</td>
	<td>
        @if( $options != "" )
			<div class="btn-group">
	            <a class="btn btn-xs text-muted" href="{{ $quickedit_url }}"><i class="fa fa-pencil"></i> Edit</a>
	        </div>
	        <div class="btn-group">
	            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
	            <ul class="dropdown-menu pull-right">
	                {{ $options }}
	            </ul>
	        </div>
        @endif
	    </td>
</tr>