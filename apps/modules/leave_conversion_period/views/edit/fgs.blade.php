<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Info</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Year</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_leave_conversion_period[year]" id="payroll_leave_conversion_period-year" value="{{ $record['payroll_leave_conversion_period.year'] }}" placeholder="Enter Year to  Convert"/>
			</div>	
		</div>
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
                $payroll_leave_conversion_period_leave_conversion_period_id_options = array('' => 'Select...');
        		if($options && $options->num_rows() > 0){
	        		foreach($options->result() as $option)
	        		{
	        			$payroll_leave_conversion_period_leave_conversion_period_id_options[$option->apply_to_id] = $option->apply_to;
	    			}

	    		} ?>							
	    		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_leave_conversion_period[apply_to_id]',$payroll_leave_conversion_period_leave_conversion_period_id_options, $record['payroll_leave_conversion_period.apply_to_id'], 'class="form-control select2me" data-placeholder="Select..." ') }}
                </div>
            </div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"></label>
			<div class="col-md-7">
				<?php
					$options = "";
					if( !empty( $record_id ) )
					{
						$options = $mod->_get_applied_to_options( $record_id, true );
					}
				?>
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    <select name="payroll_leave_conversion_period[applied_to][]" id="payroll_leave_conversion_period-applied_to" class="form-control select2me" data-placeholder="Select..." multiple>
                    	{{ $options }}
                    </select>
                </div>
            </div>	
		</div>	


		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Leave</label>
			<div class="col-md-7"><?php
				
				$options = $db->query("SELECT form_id, form FROM {$db->dbprefix}time_form WHERE deleted = 0 AND form_code IN ('SL','VL')");
                $payroll_leave_conversion_period_form_id_options = array('' => 'Select...');
        		if($options && $options->num_rows() > 0){
	        		foreach($options->result() as $option)
	        		{
	        			$payroll_leave_conversion_period_form_id_options[$option->form_id] = $option->form;
	    			}

	    		} ?>							
	    		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_leave_conversion_period[form_id]',$payroll_leave_conversion_period_form_id_options, $record['payroll_leave_conversion_period.form_id'], 'class="form-control select2me" data-placeholder="Select..." ') }}
                </div>
            </div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Non-Taxable</label>
			<div class="col-md-7"><?php
				
				$options = $db->query("SELECT transaction_id, transaction_label 
						FROM {$db->dbprefix}payroll_transaction pt
						LEFT JOIN {$db->dbprefix}payroll_transaction_class ptc on pt.transaction_class_id = ptc.transaction_class_id
						WHERE pt.deleted = 0 AND ptc.transaction_class_code = 'LEAVES' AND pt.transaction_type_id = 2
							AND ( pt.transaction_code like '%SL%' OR pt.transaction_code like '%VL%' ) ");
                $payroll_leave_conversion_period_nontax_leave_id_options = array('' => 'Select...');
        		if($options && $options->num_rows() > 0){
	        		foreach($options->result() as $option)
	        		{
	        			$payroll_leave_conversion_period_nontax_leave_id_options[$option->transaction_id] = $option->transaction_label;
	    			}

	    		} ?>							
	    		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_leave_conversion_period[nontax_leave_id]',$payroll_leave_conversion_period_nontax_leave_id_options, $record['payroll_leave_conversion_period.nontax_leave_id'], 'class="form-control select2me" data-placeholder="Select..." ') }}
                </div>
            </div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Taxable</label>
			<div class="col-md-7"><?php
				
				$options = $db->query("SELECT transaction_id, transaction_label 
						FROM {$db->dbprefix}payroll_transaction pt
						LEFT JOIN {$db->dbprefix}payroll_transaction_class ptc on pt.transaction_class_id = ptc.transaction_class_id
						WHERE pt.deleted = 0 AND ptc.transaction_class_code = 'LEAVES' AND pt.transaction_type_id = 1
							AND ( pt.transaction_code like '%SL%' OR pt.transaction_code like '%VL%' ) ");
                $payroll_leave_conversion_period_taxable_leave_id_options = array('' => 'Select...');
        		if($options && $options->num_rows() > 0){
	        		foreach($options->result() as $option)
	        		{
	        			$payroll_leave_conversion_period_taxable_leave_id_options[$option->transaction_id] = $option->transaction_label;
	    			}

	    		} ?>							
	    		<div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_leave_conversion_period[taxable_leave_id]',$payroll_leave_conversion_period_taxable_leave_id_options, $record['payroll_leave_conversion_period.taxable_leave_id'], 'class="form-control select2me" data-placeholder="Select..." ') }}
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