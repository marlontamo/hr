<link href="<?=theme_path()?>plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="<?=theme_path()?>plugins/bootstrap-timepicker/compiled/timepicker.css" rel="stylesheet" type="text/css"/>


<div class="add_more_session_field">
    <div class="portlet">
        <div class="portlet-title">
            <div class="tools">
                <a class="text-muted delete_session" href="javascript:void(0)" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <!-- <form class="form-horizontal session_form" id="session-form"> -->
                <input type="hidden" name="training_calendar_id" value="<?php echo ( isset($training_calendar_id) && !empty($training_calendar_id)) ? $training_calendar_id : ''; ?>" />
                
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Session No.</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="session[session_no][<?php echo $session_count; ?>]" id="session_no" 
                            value="" placeholder="Enter Session No"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Instructor</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="session[instructor][<?php echo $session_count; ?>]" id="instructor" 
                            value="" placeholder="Enter Instructor"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Training Date</label>
                        <div class="col-md-7">
                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control session_date" name="session[session_date][<?php echo $session_count; ?>]" id="session_date" value="" placeholder="Enter Date">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Session Time</label>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">From</label>
                        <div class="col-md-7">
                            <div class="input-group bootstrap-timepicker">                                       
                                <input type="text" class="form-control timepicker-default session-time_start" name="session[sessiontime_from][<?php echo $session_count; ?>]" id="session-time_start"  value="01:00 AM" />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>  
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">To</label>
                        <div class="col-md-7">
                            <div class="input-group bootstrap-timepicker">                                       
                                <input type="text" class="form-control timepicker-default session-time_end" name="session[sessiontime_to][<?php echo $session_count; ?>]" id="session-time_end" value="01:00 AM" />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Break Time</label>
                        <div class="col-md-6">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">From</label>
                        <div class="col-md-7">
                            <div class="input-group bootstrap-timepicker">                                       
                                <input type="text" class="form-control timepicker-default break-time_start" name="session[breaktime_from][<?php echo $session_count; ?>]" id="break-time_start" value="01:00 AM" />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>  
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">To</label>
                        <div class="col-md-7">
                            <div class="input-group bootstrap-timepicker">                                       
                                <input type="text" class="form-control timepicker-default break-time_end" name="session[breaktime_to][<?php echo $session_count; ?>]" id="break-time_end" value="01:00 AM" />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>  
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>



<script src="<?=theme_path()?>plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script src="<?=theme_path()?>plugins/bootstrap-timepicker/js/bootstrap-timepicker.js" type="text/javascript" ></script>
<script type="text/javascript" src="<?=theme_path()?>modules/training_calendar/edit.js"></script>  

