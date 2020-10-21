<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Movement Types</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter movement list by movement type.</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">All</span>
			@foreach( $partners_movement_type as $movement_type )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $movement_type->type_id }}">{{ $movement_type->type }}</span>
	        @endforeach
		</div>
	</div>
<br>
	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">Due To </div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter movement list by reason.</span>
		<div class="margin-top-10">
			<span class="filter-due event-block label label-success" filter_value="">All</span>
			@foreach( $partners_movement_cause as $movement_cause )
	        	<span href="javascript:void(0)" class="filter-due event-block label label-default" filter_value="{{ $movement_cause->cause_id }}">{{ $movement_cause->cause }}</span>
	        @endforeach
		</div>
	</div>
</div>