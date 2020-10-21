<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Personnel Requisition Form</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
				<div class="col-md-7"><?php									                            		$db->select('company_id,company');
	                            			                            		$db->order_by('company', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company'); 	                            $recruitment_request_company_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$recruitment_request_company_id_options[$option->company_id] = $option->company;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('recruitment_request[company_id]',$recruitment_request_company_id_options, $record['recruitment_request.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-company_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Department</label>
				<div class="col-md-7"><?php									                            		$db->select('department_id,department');
	                            			                            		$db->order_by('department', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_department'); 	                            $recruitment_request_department_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$recruitment_request_department_id_options[$option->department_id] = $option->department;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('recruitment_request[department_id]',$recruitment_request_department_id_options, $record['recruitment_request.department_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-department_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Requested By</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="recruitment_request[created_by]" id="recruitment_request-created_by" value="{{ $record['recruitment_request.created_by'] }}" placeholder="Enter Requested By" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Requested on</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="recruitment_request[created_on]" id="recruitment_request-created_on" value="{{ $record['recruitment_request.created_on'] }}" placeholder="Enter Requested on" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date Needed</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="recruitment_request[date_needed]" id="recruitment_request-date_needed" value="{{ $record['recruitment_request.date_needed'] }}" placeholder="Enter Date Needed" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="recruitment_request[description]" id="recruitment_request-description" placeholder="Enter Description" rows="4">{{ $record['recruitment_request.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>