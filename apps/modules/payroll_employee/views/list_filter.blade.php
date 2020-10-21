<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Companies</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter partner list by company.</span>
		<div class="margin-top-10">
			<span class="list-filter event-block label label-success" filter_value="">All</span>
			@foreach( $companies as $company )
			<span class="list-filter event-block label label-default" filter_by="ww_payroll_partners.company_id" filter_value="{{ $company->company_id }}">{{ $company->company_code }}</span>
	        @endforeach
		</div>
	</div>

</div>