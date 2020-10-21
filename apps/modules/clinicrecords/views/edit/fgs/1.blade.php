<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Clinic Records</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Partner</label>
				<div class="col-md-7"><?php									                            		$db->select('partner_id,alias');
	                            			                            		$db->order_by('alias', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners'); 	                            $partners_clinic_records_partner_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_clinic_records_partner_id_options[$option->partner_id] = $option->alias;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_clinic_records[partner_id]',$partners_clinic_records_partner_id_options, $record['partners_clinic_records.partner_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clinic_records-partner_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Medication </label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[medication]" id="partners_clinic_records-medication" value="{{ $record['partners_clinic_records.medication'] }}" placeholder="Enter Medication " /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Medication Quantity </label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[medication_qty]" id="partners_clinic_records-medication_qty" value="{{ $record['partners_clinic_records.medication_qty'] }}" placeholder="Enter Medication Quantity " /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Complaint</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_clinic_records[complaint]" id="partners_clinic_records-complaint" placeholder="Enter Complaint" rows="4">{{ $record['partners_clinic_records.complaint'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Diagnosis</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_clinic_records[diagnosis]" id="partners_clinic_records-diagnosis" placeholder="Enter Diagnosis" rows="4">{{ $record['partners_clinic_records.diagnosis'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Other Medication Cost</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[other_med_cost]" id="partners_clinic_records-other_med_cost" value="{{ $record['partners_clinic_records.other_med_cost'] }}" placeholder="Enter Other Medication Cost" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Details</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[details]" id="partners_clinic_records-details" value="{{ $record['partners_clinic_records.details'] }}" placeholder="Enter Details" /> 				</div>	
			</div>	</div>
</div>