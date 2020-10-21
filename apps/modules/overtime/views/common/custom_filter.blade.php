<style>
    .event-block {
        cursor: pointer;
        margin-bottom: 5px;
        display: inline-block;
        position: relative;
    }
</style>
<div class="portlet-title" style="margin-bottom:3px;">
	<div class="caption">Calendar Month</div>
</div>
<div class="portlet-body">

	<span class="small text-muted margin-bottom-10">
		Show inclusive date per calendar month
	</span>

	<div id="sf-container" class="margin-top-10">
		<span id="yr-fltr-prev" data-year-value="{{$prev_year['value']}}" class="event-block label label-info year-filter">
			{{$prev_year['value']}}
		</span>

		<!-- </a> -->

		<!-- ml stands for month list -->
		@foreach($month_list as $month_key => $month_value)
		<span id="ml-{{$month_key}}" data-month-value="{{$month_key}}" class="event-block label label-default month-list">
			{{$month_value}}
		</span>
		@endforeach
		<input type="hidden" value="" data-date="" id="selected_filterMonth" name="selected_filterMonth" >
		<span id="yr-fltr-next" data-year-value="{{$next_year['value']}}" class="event-block label label-info year-filter">
			{{$next_year['value']}}
		</span>
	</div>
</div>


<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
	<div class="caption">Pay dates</div>
</div>
<div class="portlet-body">
	<span class="small text-muted">Show inclusive date for the last 5 pay dates</span>
	<div id="period-filter-container" class="margin-top-10">
		@foreach($periodList as $period_key => $period_value)
			<span 
				id="ppf-{{ $period_value['record_id'] }}"
				data-record-id=" {{ $period_value['record_id'] }}"
				data-ppf-value-from="{{ $period_value['from'] }}" 
				data-ppf-value-to="{{ $period_value['to'] }}"  
				class="event-block label label-default external-event period-filter">
				{{ $period_value['payroll_date'] }}
			</span>
		@endforeach
	</div>
</div>

