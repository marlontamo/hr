<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Employee Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,display_name');
	                            			                            		$db->order_by('display_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $partners_movement_action_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_movement_action_user_id_options[$option->user_id] = $option->display_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_movement_action[user_id]',$partners_movement_action_user_id_options, $record['partners_movement_action.user_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Due To</label>
				<div class="col-md-7"><?php									                            		$db->select('cause_id,cause');
	                            			                            		$db->order_by('cause', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_movement_cause'); 	                            $partners_movement_due_to_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_movement_due_to_id_options[$option->cause_id] = $option->cause;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_movement[due_to_id]',$partners_movement_due_to_id_options, $record['partners_movement.due_to_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Type</label>
				<div class="col-md-7"><?php									                            		$db->select('type_id,type');
	                            			                            		$db->order_by('type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_movement_type'); 	                            $partners_movement_action_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_movement_action_type_id_options[$option->type_id] = $option->type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_movement_action[type_id]',$partners_movement_action_type_id_options, $record['partners_movement_action.type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_movement[remarks]" id="partners_movement-remarks" placeholder="Enter Remarks" rows="4">{{ $record['partners_movement.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Nature of Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Nature of Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Effective</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_movement_action[effectivity_date]" id="partners_movement_action-effectivity_date" value="{{ $record['partners_movement_action.effectivity_date'] }}" placeholder="Enter Effective" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_movement_action[remarks]" id="partners_movement_action-remarks" placeholder="Enter Remarks" rows="4">{{ $record['partners_movement_action.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Extension Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Movement Details</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Months</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_extension[no_of_months]" id="partners_movement_action_extension-no_of_months" value="{{ $record['partners_movement_action_extension.no_of_months'] }}" placeholder="Enter Months" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>End Date</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_extension[end_date]" id="partners_movement_action_extension-end_date" value="{{ $record['partners_movement_action_extension.end_date'] }}" placeholder="Enter End Date" /> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Compensation Adjustment</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Compensation Adjustment</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Current Salary</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_compensation[current_salary]" id="partners_movement_action_compensation-current_salary" value="{{ $record['partners_movement_action_compensation.current_salary'] }}" placeholder="Enter Current Salary" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>New Salary</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_compensation[to_salary]" id="partners_movement_action_compensation-to_salary" value="{{ $record['partners_movement_action_compensation.to_salary'] }}" placeholder="Enter New Salary" /> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">End Service Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>End Service Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>End Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_movement_action_moving[end_date]" id="partners_movement_action_moving-end_date" value="{{ $record['partners_movement_action_moving.end_date'] }}" placeholder="Enter End Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Blacklisted</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['partners_movement_action_moving.blacklisted'] ) checked="checked" @endif name="partners_movement_action_moving[blacklisted][temp]" id="partners_movement_action_moving-blacklisted-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="partners_movement_action_moving[blacklisted]" id="partners_movement_action_moving-blacklisted" value="@if( $record['partners_movement_action_moving.blacklisted'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7"><?php									                            		$db->select('reason_id,reason');
	                            			                            		$db->order_by('reason', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_movement_reason'); 	                            $partners_movement_action_moving_reason_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_movement_action_moving_reason_id_options[$option->reason_id] = $option->reason;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_movement_action_moving[reason_id]',$partners_movement_action_moving_reason_id_options, $record['partners_movement_action_moving.reason_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Further Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_movement_action_moving[further_reason]" id="partners_movement_action_moving-further_reason" placeholder="Enter Further Reason" rows="4">{{ $record['partners_movement_action_moving.further_reason'] }}</textarea> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Transfer Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Transfer Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Field id</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_transfer[field_id]" id="partners_movement_action_transfer-field_id" value="{{ $record['partners_movement_action_transfer.field_id'] }}" placeholder="Enter Field id" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>From id</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_transfer[from_id]" id="partners_movement_action_transfer-from_id" value="{{ $record['partners_movement_action_transfer.from_id'] }}" placeholder="Enter From id" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>To id</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_movement_action_transfer[to_id]" id="partners_movement_action_transfer-to_id" value="{{ $record['partners_movement_action_transfer.to_id'] }}" placeholder="Enter To id" /> 				</div>	
			</div>	</div>
</div>