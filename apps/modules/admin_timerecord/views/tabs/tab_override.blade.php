<!-- Listing -->
<div class="portlet" id="list">
    <div class="portlet-title hidden">
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
        <div class="">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                        <input type="text" class="form-control" name="selected_date" id="selected_date" value="{{ $currentDate }}" placeholder="">
                        <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                            $db->order_by('department', 'asc');
                            $departments = $db->get_where('users_department', array('deleted' => 0));
                        ?>
                        <select name="department_id_by_date" class="form-control select2me" data-placeholder="Select...">
                            <option value="">Select department...</option>
                            <?php
                                foreach( $departments->result() as $department )
                                {
                                    echo '<option value="'.$department->department_id.'">'. $department->department . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>    
            </div>
        </div>
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

        <table id="list-table_bydate" class="_bydate table-condensed table-hover" style="display: none;">
            <thead>
                <tr>
                    <th width="1%" class="hidden-xs">
                        <span data-original-title="Schedules" data-content="List to remind you of your restdays and holidays" data-placement="right" data-trigger="hover" class="popovers">
                            <i class="fa fa-align-justify"></i>
                        </span></th>


                    <th width="15%">Name</th>
                    <th width="16%" class="hidden-xs">Shift</th>
                    <th width="17%">{{ lang('admin_timerecord.in') }}</th>
                    <th width="17%">{{ lang('admin_timerecord.out') }}</th>
                    <th width="16%">{{ lang('admin_timerecord.leave_forms') }}</th>                    
                    <th width="14%" class="hidden-xs">{{ lang('admin_timerecord.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                
            </tbody>
        </table>

        <!-- End Table -->
    </div>
</div>