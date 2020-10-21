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
                    <div class="input-group">
                        <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                        </span>
                        <?php
                            $qry_category = $mod->get_role_category();
                            $db->order_by('users.full_name', 'asc');
                            $db->where('partners.deleted', 0);
                            $db->where('users.active', 1);
                            if ($qry_category != ''){
                                $db->where($qry_category, '', false);
                            }                               
                            $db->join('users', 'users.user_id = partners.user_id');
                            $db->join('users_profile', 'users_profile.user_id = partners.user_id');
                            $db->from('partners');
                            $partners = $db->get();
                        ?>
                        <select name="period_user_id" id="period_user_id" class="form-control select2me col-md-4" data-placeholder="Select partner...">
                            <option value=""></option>
                            <?php
                                foreach( $partners->result() as $partner )
                                {
                                    echo '<option value="'.$partner->user_id.'">'. $partner->full_name . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4"  id="user-hide">
                    <div class="input-group">
                        <span class="input-group-addon">
                        <i class="fa fa-list"></i>
                        </span>
                        <?php 
                            $options = "";
                            if( !empty( $user_id ) )
                            {
                                $options = $mod->_get_user_to_options( $user_id, true );
                            }
                        ?>
                        <select name="pay_dates" id="pay_dates" class="form-control select2me col-md-4" data-placeholder="Select Period..." >
                            {{ $options }}
                        </select>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="portlet-body">
        <!-- Table -->

        <div id="loader_byperiod" class="text-center" style="display: none;">
            <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('admin_timerecord.fetch_rec') }}
        </div>

        <div id="no_record_byperiod" class="well" style="display:none;">
            <p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('admin_timerecord.no_records') }}</p>
            <span><p class="small margin-bottom-0">{{ lang('admin_timerecord.no_tr') }}</p></span>
        </div>

         <table id="list-table_byperiod" class="by_period table-condensed table-hover" style="display: none;">
            <thead>
                <tr>
                    <th width="1%" class="hidden-xs">
                        <span data-original-title="Schedules" data-content="List to remind you of your restdays and holidays" data-placement="right" data-trigger="hover" class="popovers">
                            <i class="fa fa-align-justify"></i>
                        </span></th>

                    <th width="23%">Date</th>
                    <th width="23%" class="hidden-xs">Shift</th>
                    <th width="23%">{{ lang('admin_timerecord.in') }}</th>
                    <th width="23%">{{ lang('admin_timerecord.out') }}</th>
                    <th width="8%" class="hidden-xs">{{ lang('admin_timerecord.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                
            </tbody>
        </table>

        <!-- End Table -->
    </div>
</div>