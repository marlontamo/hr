<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('partners.types') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">{{ lang('partners.filter_by_emp_type') }}</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $employment_types as $employment_type )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $employment_type->employment_type_id }}">{{ $employment_type->employment_type }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('partners.company') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">{{ lang('partners.filter_by_company') }}</span>
		<div class="margin-top-10">
			<span class="filter-company event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $companys as $company )
	        	<span href="javascript:void(0)" class="filter-company event-block label label-default" filter_value="{{ $company->company_id }}">{{ $company->company }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
		<div class="caption">{{ lang('partners.status') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">{{ lang('partners.filter_by_emp_status') }}</span>
		<div class="margin-top-10">
			<span class="filter-status event-block label label-default" filter_value="">{{ lang('common.all') }}</span>
			<span class="filter-status event-block label label-success" filter_value="1">{{ lang('partners.active') }}</span>
			<span class="filter-status event-block label label-default" filter_value="0">{{ lang('partners.inactive') }}</span>
		</div>
	</div>
</div>