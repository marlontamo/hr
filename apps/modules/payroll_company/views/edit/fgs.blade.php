<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[company_code]" id="users_company-company_code" value="{{ $record['users_company.company_code'] }}" placeholder="Enter Company Code"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[company]" id="users_company-company" value="{{ $record['users_company.company'] }}" placeholder="Enter Company Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Bank</label>
				<div class="col-md-7"><?php									                            		$db->select('bank_id,bank');
	                            			                            		$db->order_by('bank', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_bank'); 	                            $users_company_bank_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$users_company_bank_id_options[$option->bank_id] = $option->bank;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('users_company[bank_id]',$users_company_bank_id_options, $record['users_company.bank_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>SSS No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[sss]" id="users_company-sss" value="{{ $record['users_company.sss'] }}" placeholder="Enter SSS No."/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Pag-ibig No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[hdmf]" id="users_company-hdmf" value="{{ $record['users_company.hdmf'] }}" placeholder="Enter Pag-ibig No."/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Philhealth No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[phic]" id="users_company-phic" value="{{ $record['users_company.phic'] }}" placeholder="Enter Philhealth No."/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>TIN</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_company[tin]" id="users_company-tin" value="{{ $record['users_company.tin'] }}" placeholder="Enter TIN"/> 				</div>	
			</div>	</div>
</div>