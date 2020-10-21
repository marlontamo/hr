<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Details of Offense</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Witnesses</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $partners_incident_witnesses_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_incident_witnesses_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_incident[witnesses]',$partners_incident_witnesses_options, $record['partners_incident.witnesses'], 'class="form-control select2me" data-placeholder="Select..." id="partners_incident-witnesses"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Location</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_incident[location]" id="partners_incident-location" value="{{ $record['partners_incident.location'] }}" placeholder="Enter Location" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Details of Violation </label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_incident[violation_details]" id="partners_incident-violation_details" placeholder="Enter Details of Violation " rows="4">{{ $record['partners_incident.violation_details'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Damage/s done (If any) </label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_incident[damages]" id="partners_incident-damages" placeholder="Enter Damage/s done (If any) " rows="4">{{ $record['partners_incident.damages'] }}</textarea> 				</div>	
			</div>	</div>
</div>