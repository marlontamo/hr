<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Employee Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Partner</label>
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
</div>