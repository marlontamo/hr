<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Info </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
			<div class="col-md-7">							
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="payroll_leave_conversion_period[payroll_date]" id="payroll_leave_conversion_period-payroll_date" value="{{ $record['payroll_leave_conversion_period.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Apply To</label>
			<div class="col-md-7"><?php									                            		
				$db->select('apply_to_id,apply_to');
                $db->order_by('apply_to', '0');
                $db->where('deleted', '0');
                $options = $db->get('payroll_apply_to');
                $payroll_leave_conversion_period_apply_to_id_options = array('' => 'Select...');
        		foreach($options->result() as $option)
        		{
    				$payroll_leave_conversion_period_apply_to_id_options[$option->apply_to_id] = $option->apply_to;
    			} ?>							
    			<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_leave_conversion_period[apply_to_id]',$payroll_leave_conversion_period_apply_to_id_options, $record['payroll_leave_conversion_period.apply_to_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
            </div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Remarks</label>
			<div class="col-md-7">
				<textarea class="form-control" name="payroll_leave_conversion_period[remarks]" id="payroll_leave_conversion_period-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_leave_conversion_period.remarks'] }}</textarea>
			</div>	
		</div>
	</div>
</div>