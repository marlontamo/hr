<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employment Type</label>
				<div class="col-md-7"><?php									                            		$db->select('employment_type_id,employment_type');
	                            			                            		$db->order_by('employment_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_employment_type'); 	                            $payroll_leave_conversion_employment_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_leave_conversion_employment_type_id_options[$option->employment_type_id] = $option->employment_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_leave_conversion[employment_type_id]',$payroll_leave_conversion_employment_type_id_options, $record['payroll_leave_conversion.employment_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_leave_conversion-employment_type_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
				<div class="col-md-7"><?php									                            		$db->select('company_id,company_code');
	                            			                            		$db->order_by('company_code', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company'); 	                            $payroll_leave_conversion_company_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_leave_conversion_company_id_options[$option->company_id] = $option->company_code;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_leave_conversion[company_id]',$payroll_leave_conversion_company_id_options, $record['payroll_leave_conversion.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_leave_conversion-company_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Form Type</label>
				<div class="col-md-7"><?php									                            		$db->select('form_id,form');
	                            			                            		$db->order_by('form', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('time_form'); 	                            $payroll_leave_conversion_form_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_leave_conversion_form_id_options[$option->form_id] = $option->form;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_leave_conversion[form_id]',$payroll_leave_conversion_form_id_options, $record['payroll_leave_conversion.form_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_leave_conversion-form_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Covertible</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_leave_conversion[convertible]" id="payroll_leave_conversion-convertible" value="{{ $record['payroll_leave_conversion.convertible'] }}" placeholder="Enter Covertible" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Forfeited</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_leave_conversion[forfeited]" id="payroll_leave_conversion-forfeited" value="{{ $record['payroll_leave_conversion.forfeited'] }}" placeholder="Enter Forfeited" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Non-Taxable</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_leave_conversion[nontax]" id="payroll_leave_conversion-nontax" value="{{ $record['payroll_leave_conversion.nontax'] }}" placeholder="Enter Non-Taxable" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Taxable</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_leave_conversion[taxable]" id="payroll_leave_conversion-taxable" value="{{ $record['payroll_leave_conversion.taxable'] }}" placeholder="Enter Taxable" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_leave_conversion[description]" id="payroll_leave_conversion-description" placeholder="Enter Description" rows="4">{{ $record['payroll_leave_conversion.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>