<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('payroll_employee_loan.types') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">{{ lang('payroll_employee_loan.filter_by_type') }}</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $loan_types as $loan_type )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $loan_type->loan_id }}">{{ $loan_type->loan }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
		<div class="caption">{{ lang('payroll_employee_loan.status') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">{{ lang('payroll_employee_loan.filter_by_status') }}</span>
		<div class="margin-top-10">
			<span class="filter-status event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $loan_statuses as $loan_status )
	        	<span href="javascript:void(0)" class="filter-status event-block label label-default" filter_value="{{ $loan_status->loan_status_id }}">{{ $loan_status->loan_status }}</span>
	        @endforeach
		</div>
	</div>
</div>