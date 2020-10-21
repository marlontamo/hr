<div class="portlet">
    <div class="portlet-title">
        <div class="caption">Holiday Information</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-group">
            <label class="control-label col-md-3">Holiday</label>
            <div class="col-md-7">
                <input type="text" class="form-control" name="time_holiday[holiday]" id="time_holiday-holiday" value="{{ $record['time_holiday.holiday'] }}" placeholder="Enter Holiday" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Date</label>
            <div class="col-md-7">
                <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" class="form-control" name="time_holiday[holiday_date]" id="time_holiday-holiday_date" value="{{ $record['time_holiday.holiday_date'] }}" placeholder="Enter Date" readonly>
                    <span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Legal</label>
            <div class="col-md-7">
                <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                    <input type="checkbox" value="1" @if( $record[ 'time_holiday.legal'] ) checked="checked" @endif name="time_holiday[legal][temp]" id="time_holiday-legal-temp" class="dontserializeme toggle" />
                    <input type="hidden" name="time_holiday[legal]" id="time_holiday-legal" value="<?php echo $record['time_holiday.legal'] ? 1 : 0 ?>" />
                </div>
                <small class="help-block">Note: Legal rate is much higher than Special holiday.</small>
            </div>
        </div>
    </div>
</div>
<div class="portlet">
    <div class="portlet-title">
        <div class="caption">For Special Holiday</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-group">
            <label class="control-label col-md-3">Location</label>
            <div class="col-md-7">
                <?php 

                    $db->select('location_id,location'); 
                    $db->where('deleted', '0'); 
                    $options = $db->get('users_location'); 
                    $time_holiday_location_location_id_options = array(); 

                    foreach($options->result() as $option) { 
                        $time_holiday_location_location_id_options[$option->location_id] = $option->location; 
                    } 
                ?>
                
                <div class="input-group">
                    <span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
                    {{ form_dropdown('time_holiday_location[location_id][]',$time_holiday_location_location_id_options, explode(',', $record['time_holiday.locations']), 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="time_holiday_location-location_id"') }}
                </div>
                <small class="help-block">Choose if selected location were affected.</small>
            </div>
        </div>
    </div>
</div>