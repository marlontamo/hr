<div class="portlet">
	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div style="margin-bottom:3px;" class="portlet-title">
		<div class="caption">Category</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">Select to filter specific category.</span>
		<div class="margin-top-15">
			<span class="filter-type event-block label label-success" filter_by="" filter_value="">All</span>
			
			@foreach ($competency_categories as $competency_category)
			<span  href="javascript:void(0)" class="filter-type event-block label label-default" filter_by="ww_performance_competency_values.competency_category_id" filter_value="{{$competency_category->competency_category_id}}">{{$competency_category->competency_category}}</span>
			@endforeach

		</div>
	</div>
</div>