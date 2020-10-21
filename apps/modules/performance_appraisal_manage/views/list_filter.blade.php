<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Year</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter target settings by year.</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">All</span>
			@foreach( $performance_appraisal_year as $appraisal_year )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $appraisal_year->year }}">{{ $appraisal_year->year }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Target Setting Status</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter planning by status.</span>
		<div class="margin-top-10">
			<span class="filter-type-status event-block label label-success" filter_value="">All</span>
	        <span href="javascript:void(0)" class="filter-type-status event-block label label-default" filter_value="1">Open</span>
	        <span href="javascript:void(0)" class="filter-type-status event-block label label-default" filter_value="0">Closed</span>
		</div>
	</div>
</div>