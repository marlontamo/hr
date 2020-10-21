<input type="hidden" name="form_code" id="form_code" value="OT">
<div class="form-group">
    <label class="control-label col-md-4"><?php echo lang('form_application_admin.ot_date') ?><span class="required">* </span></label>
    <div class="col-md-6">                          
        <div class="input-group date date-picker" data-date-format="MM dd, yyyy">                                       
                <input type="text" size="16" class="form-control" name="time_forms[focus_date]" id="time_forms-focus_date" value="" />
                <span class="input-group-btn">
                    <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                </span>
        </div>              
    </div>  
</div>  
<div class="form-group">
	<label class="control-label col-md-4">From<span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date " data-date-format="MM dd, yyyy - HH:ii p">                                       
			<input type="text" size="16" class="form-control" name="time_forms[date_from]" id="time_forms-datetime_from" value="" />
			<span class="input-group-btn">
				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-4">To<span class="required">* </span></label>
	<div class="col-md-6">							
		<div class="input-group date form_datetime">                                       
			<input type="text" size="16" class="form-control" name="time_forms[date_to]" id="time_forms-datetime_to" value="" />
			<span class="input-group-btn">
				<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
	</div>	
</div>

<script>
    $("#time_forms-datetime_from").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    $("#time_forms-datetime_to").datetimepicker({
        format: "MM dd, yyyy - HH:ii p",
        autoclose: true,
        todayBtn: false,
        pickerPosition: "bottom-left",
        minuteStep: 1
    });

    if (jQuery().timepicker) {
        $('.timepicker-default').timepicker({
            autoclose: true
        });
    }

    if (jQuery().datepicker) {
        $('#time_forms-focus_date').parent('.date-picker').datepicker({
            format: "MM dd, yyyy",
            autoclose: true,
            todayBtn: false,
            pickerPosition: "bottom-left",
            minuteStep: 1             
        }).on('changeDate', function(ev) {
            var focus_date = Date.parse($('#time_forms-focus_date').val());  

            if ($('#time_forms-date_to').length > 0){
                var date_from = Date.parse($('#time_forms-date_from').val());
                var date_to = Date.parse($('#time_forms-date_to').val());
            }
            else{
                var currentdate = new Date(); 
                var current_time = currentdate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}); //currentdate.toLocaleTimeString();
                var focus_date_original = $('#time_forms-focus_date').val() + ' - ' + current_time;

                $('#time_forms-datetime_from').val(focus_date_original);
                $('#time_forms-datetime_to').val(focus_date_original);

                var date_from = Date.parse($('#time_forms-datetime_from').val());
                var date_to = Date.parse($('#time_forms-datetime_to').val());
            }

            var no_days_before = dateDiff(focus_date,date_from,'days');
            var no_days_after = dateDiff(focus_date,date_to,'days');

            if ((focus_date < date_from) && no_days_before > 1){
                $('#time_forms-focus_date').val('')
                notify('error', 'Focus date should less than or equal to 1 day');
            }

            if ((focus_date > date_to) && no_days_after > 1){
                $('#time_forms-focus_date').val('')
                notify('error', 'Focus date should less than or equal to 1 day');
            }    

            if ($('form_code').val() == 'DTRP'){
                if ((focus_date < date_to) && no_days_after > 1){
                    $('#time_forms-focus_date').val('')
                    notify('error', 'Focus date should less than or equal to 1 day');
                }   
            }   

        });
    }    
</script>