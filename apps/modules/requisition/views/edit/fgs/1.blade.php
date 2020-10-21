<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Purchase Request</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Project Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="requisition[project_name]" id="requisition-project_name" value="{{ $record['requisition.project_name'] }}" placeholder="Enter Project Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Priority</label>
				<div class="col-md-7"><?php									                            		$db->select('priority_id,priority');
	                            			                            		$db->order_by('priority', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('requisition_priority'); 	                            $requisition_priority_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$requisition_priority_id_options[$option->priority_id] = $option->priority;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('requisition[priority_id]',$requisition_priority_id_options, $record['requisition.priority_id'], 'class="form-control select2me" data-placeholder="Select..." id="requisition-priority_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Approval From</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $requisition_approver_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$requisition_approver_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('requisition[approver]',$requisition_approver_options, $record['requisition.approver'], 'class="form-control select2me" data-placeholder="Select..." id="requisition-approver"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>