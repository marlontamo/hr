<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('late_exemption.late_exemption_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('late_exemption.company') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('company_id,company');
                            		$db->order_by('company', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('users_company'); 	                            
                            		$late_exemption_company_id_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $late_exemption_company_id_options[$option->company_id] = $option->company;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_late_exemption[company_id]',$late_exemption_company_id_options, $record['payroll_late_exemption.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="late_exemption-company_id"') }}
                </div> 				
            </div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('late_exemption.e_type') }}</label>
			<div class="col-md-7"><?php									                            		
									$db->select('employment_type_id,employment_type');
                            		$db->order_by('employment_type', '0');
                            		$db->where('deleted', '0');
                            		$options = $db->get('partners_employment_type'); 	                            
                            		$late_exemption_employment_type_options = array('' => 'Select...');
                    				foreach($options->result() as $option)
                    				{
                    			        $late_exemption_employment_type_options[$option->employment_type_id] = $option->employment_type;
                    			    } ?>							
			    <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_late_exemption[employment_type_id]',$late_exemption_employment_type_options, $record['payroll_late_exemption.employment_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="late_exemption-employment_type_id"') }}
                </div> 				
            </div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('late_exemption.late_exemption') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_late_exemption[lates_exemption]" id="late_exemption-lates_exemption" value="{{ $record['payroll_late_exemption.lates_exemption'] }}" placeholder="{{ lang('late_exemption.late_exemption') }}"/> 				
			</div>	
		</div>					
	</div>
</div>