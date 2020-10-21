<!-- Listing -->
<div class="portlet" id="list">
    <div class="portlet-title">
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

    <div class="portlet-title">
    @include('employee_filter')
    </div>

    <div class="portlet-body">
        <!-- Table -->

        <div id="loader_bydate" class="text-center" style="display: none;">
            <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('admin_timerecord.fetch_rec') }}
        </div>

        <div id="no_record_bydate" class="well" style="display:none;">
            <p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('admin_timerecord.no_records') }}</p>
            <span><p class="small margin-bottom-0">{{ lang('admin_timerecord.no_tr') }}</p></span>
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
                    <th width="10%">{{ lang('admin_timerecord.date') }}</th>
                    <th width="10%">{{ lang('admin_timerecord.in') }}</th>
                    <th width="10%">{{ lang('admin_timerecord.out') }}</th>
                    <th width="1%" class="hidden-xs">&nbsp;</th>
                    <th width="5%"><br />{{ lang('admin_timerecord.hrs_worked') }}</th>
                    <th width="5%" class="hidden-xs">{{ lang('admin_timerecord.late_hr') }}<br /><span class="small text-muted"></span></th>
                    <th width="5%" class="hidden-xs">{{ lang('admin_timerecord.ut_hr') }}<br /><span class="small text-muted"></span></th>
                    <th width="5%" class="hidden-xs">{{ lang('admin_timerecord.ot_hr') }}<br /><span class="small text-muted"></span></th>
                    <th width="8%" class="hidden-xs">{{ lang('admin_timerecord.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                
            </tbody>
        </table>

        <!-- End Table -->
    </div>
</div>