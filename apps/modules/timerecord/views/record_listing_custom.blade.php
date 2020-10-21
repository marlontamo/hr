@extends('layouts.master')

@section('page_styles')
	@parent
	
	<style>
		.popover {min-width: 400px !important;}
    </style>    
    
@stop

@section('page_content')
	@parent

	<div class="row">

	    <div class="col-md-9">

	        <!-- Listing -->
	        <div class="portlet" id="list">

	            <div class="breadcrumb hidden-lg hidden-md hidden-sm hidden-xs">
	                <div class="block input-icon right">
	                    <i class="fa fa-search"></i>
	                    <input type="text" placeholder="Search..." class="form-control">
	                </div>
	            </div>
				<div class="portlet-body">
					<div >
						<ul class="nav nav-tabs ">
							@if ($permission_tr_personal)
								<li class="active"><a href="{{ get_mod_route('timerecord') }}">{{ lang('common.personal') }}</a></li>
								@if($mod->is_dtru_applicable())
									<li class=""><a href="{{ get_mod_route('timerecord') }}/updating">Updating</a></li>
								@endif
							@endif
							@if ($permission_tr_manage)
								<li class=""><a href="{{ get_mod_route('timerecord_manage') }}">{{ lang('common.manage') }}</a></li>
							@endif
							
						</ul>
					</div>
				</div>

	            <div class="portlet-title margin-top-25">
	                <div class="caption" id="date-title">&nbsp;</div>
	                <div class="actions margin-bottom-10">
	                    <a id="previous_month" data-month="{{$prev_month}}" class="text-muted btn btn-default month-nav">
	                    	<i class="fa fa-chevron-left"></i>
	                    </a>
	                    <a id="next_month" data-month="{{$next_month}}" class="text-muted btn btn-default month-nav">
	                    	<i class="fa fa-chevron-right"></i>
	                    </a>
	                </div>
	            </div>

	            <div class="portlet-body">
	                <!-- Table -->

	                <div id="loader" class="text-center" style="display: none;">
					    <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> Fetching record(s)
					</div>

					<div id="no_record" class="well" style="display:none;">
					    <p class="bold"><i class="fa fa-exclamation-triangle"></i> No record/s found!</p>
					    <span><p class="small margin-bottom-0">No available Time Record/s.</p></span>
					</div>

	                <table id="list-table" class="table table-condensed table-hover" style="display: none;">
	                    <thead>
	                        <tr>
	                            <th width="1%" class="hidden-xs">
							        <span data-original-title="Schedules" data-content="List to remind you of your restdays and holidays" data-placement="right" data-trigger="hover" class="popovers">
							            <i class="fa fa-align-justify"></i>
							        </span></th>


	                            <th width="1%" class="">
							        <span data-original-title="Reminders" data-content="List of items to remind you of needed application to file for disputes." data-placement="right" data-trigger="hover" class="popovers">
							            <i class="fa fa-bell-o"></i>
							        </span></th>

								<th width="1%" class="">&nbsp;</th>
	                            <th width="10%">{{ lang('timerecord.date') }}</th>
	                            <th width="10%">{{ lang('timerecord.in') }}</th>
	                            <th width="10%">{{ lang('timerecord.out') }}</th>
	                            <th width="1%" class="hidden-xs">&nbsp;</th>
	                            <th width="5%"><br />{{ lang('timerecord.hrs_worked') }}</th>
	                            <th width="5%" class="hidden-xs">{{ lang('timerecord.late_hr') }}<br /><span class="small text-muted">hr</span></th>
	                            <th width="5%" class="hidden-xs">{{ lang('timerecord.ut_hr') }}<br /><span class="small text-muted">hr</span></th>
	                            <th width="5%" class="hidden-xs">{{ lang('timerecord.ot_hr') }}<br /><span class="small text-muted">hr</span></th>
	                            <th width="8%" class="hidden-xs">{{ lang('timerecord.actions') }}</th>
	                        </tr>
	                    </thead>

	                    <tbody>
	                    	
	                    </tbody>
	                </table>

	                <!-- End Table -->

	                <!-- MODAL -->

		                <!-- /. VL: modal -->
		                <?php //include "time_form_vl.php" ?>
		                <!-- /.modal -->

		                <!-- /. SL: modal -->
		                <?php //include "time_form_sl.php" ?>
		                <!-- /.modal -->

		                <!-- /. LWOP: modal -->
		                <?php //include "time_form_lwop.php" ?>
		                <!-- /.modal -->

		                <!-- /. EL: modal -->
		                <?php //include "time_form_el.php" ?>
		                <!-- /.modal -->

		                <!-- /. BL: modal -->
		                <?php //include "time_form_bl.php" ?>
		                <!-- /.modal -->

		                <!-- /. P: modal -->
		                <?php //include "time_form_p.php" ?>
		                <!-- /.modal -->

		                <!-- /. M: modal -->
		                <?php //include "time_form_m.php" ?>
		                <!-- /.modal -->

		                <!-- /. BDAY: modal -->
		                <?php //include "time_form_bday.php" ?>
		                <!-- /.modal -->

		                <!-- /. SPLW: modal -->
		                <?php //include "time_form_splw.php" ?>
		                <!-- /.modal -->

		                <!-- /. BT: modal -->
		                <?php //include "time_form_bt.php" ?>
		                <!-- /.modal -->

		                <!-- /. OT: modal -->
		                <?php //include "time_form_ot.php" ?>
		                <!-- /.modal -->

		                <!-- /. UT: modal -->
		                <?php //include "time_form_ut.php" ?>
		                <!-- /.modal -->

		                <!-- /. DTRP: modal -->
		                <?php //include "time_form_dtrp.php" ?>
		                <!-- /.modal -->

		                <!-- /. CWS: modal -->
		                <?php //include "time_form_cws.php" ?>
		                <!-- /.modal -->

	                <!-- END MODAL -->
	            </div>

	        </div>


	    </div>

	    <div class="col-md-3 visible-lg visible-md">
	        <div class="portlet">

	            <style>
	                .event-block {
	                    cursor: pointer;
	                    margin-bottom: 5px;
	                    display: inline-block;
	                    position: relative;
	                }
	            </style>

	            <div class="portlet-title" style="margin-bottom:3px;">
	                <div class="caption">{{ lang('timerecord.calendar_month') }}</div>
	            </div>
	            <div class="portlet-body">

	                <span class="small text-muted margin-bottom-10">
	                	{{ lang('timerecord.show_inclusive_date_month') }}
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

	                    <span id="yr-fltr-next" data-year-value="{{$next_year['value']}}" class="event-block label label-info year-filter">
	                    	{{$next_year['value']}}
	                    </span>
	                </div>
	            </div>


	            <div class="portlet-title margin-top-20" style="margin-bottom:3px;">
	                <div class="caption">{{ lang('timerecord.pay_dates') }}</div>
	            </div>
	            <div class="portlet-body">
	                <span class="small text-muted">{{ lang('timerecord.show_inclusive_date_last5') }}</span>
	                <div id="period-filter-container" class="margin-top-10">
	                </div>
	            </div>

	            <div class="portlet-title margin-top-20" style="margin-bottom:3px;">
	                <div class="caption">{{ lang('timerecord.link') }}</div>
	            </div>
	            <div class="portlet-body">
	                
	                <div class="margin-top-10">
	                    <a href="{{ get_mod_route('my_calendar') }}" class="label label-success">{{ lang('timerecord.my_calendar') }}</a>
	                </div>
	            </div>

	        </div>
	    </div>

	</div>
@stop


@section('view_js')
	@parent

	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}modules/timerecord/lists.js"></script>
@stop
