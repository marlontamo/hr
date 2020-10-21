<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
	</style>

	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('sub_account_charts.types') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">{{ lang('sub_account_charts.filter_by_sub_account') }}</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			@foreach( $account_types as $account_type )
	        	<span href="javascript:void(0)" class="filter-type event-block label label-default" filter_value="{{ $account_type->account_id }}">{{ $account_type->account_name }}</span>
	        @endforeach
		</div>
	</div>

</div>