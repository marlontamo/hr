<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Coordinator Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Coordinator</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,alias');
	                            			                            		$db->order_by('alias', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners'); 	                            $time_coordinator_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_coordinator_user_id_options[$option->user_id] = $option->alias;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_coordinator[user_id]',$time_coordinator_user_id_options, $record['time_coordinator.user_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_coordinator-user_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>