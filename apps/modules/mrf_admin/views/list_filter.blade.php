<div class="portlet">

	<style>
		.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
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
            	<span id="ml-{{$month_key}}" data-month-value="{{$month_key}}" class="event-block label <?php echo ( date('m',strtotime($current_date)) == date('m',strtotime($month_key)) ? 'label-success' : 'label-default') ?> month-list">
            		{{$month_value}}
            	</span>
            @endforeach

            <span id="yr-fltr-next" data-year-value="{{$next_year['value']}}" class="event-block label label-info year-filter">
            	{{$next_year['value']}}
            </span>
        </div>
    </div>
	<div class="portlet-title" style="margin-bottom:3px;">
		<div class="caption">{{ lang('common.status') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted margin-bottom-10">Filter by applicant status.</span>
		<div class="margin-top-10">
			<span class="filter-status event-block label label-success" filter_value="">All</span>
			@foreach( $rec_status as $rec_stat )
	        	<span href="javascript:void(0)" class="filter-status event-block label label-default" filter_value="{{$rec_stat['recruit_status_id']}}">{{ $rec_stat['recruit_status'] }}</span>
	        @endforeach
		</div>
	</div>

	<div class="portlet-title margin-top-20" style="margin-bottom:3px;">
		<div class="caption">{{ lang('mrf_admin.type') }}</div>
	</div>
	<div class="portlet-body">
		<span class="small text-muted">Filter by applicant type.</span>
		<div class="margin-top-10">
			<span class="filter-type event-block label label-success" filter_value="">{{ lang('common.all') }}</span>
			<span class="filter-type event-block label label-default" filter_value="1">{{ lang('mrf_admin.external') }}</span>
			<span class="filter-type event-block label label-default" filter_value="2">{{ lang('mrf_admin.internal') }}</span>
			<span class="filter-type event-block label label-default" filter_value="3">{{ lang('mrf_admin.extern_intern') }}</span>
		</div>
	</div>
</div>