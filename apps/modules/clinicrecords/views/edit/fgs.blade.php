<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> {{ lang('clinicrecords.clinic_record') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('clinicrecords.partner') }}</label>
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
		</div>			
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('clinicrecords.medication') }} </label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[medication]" id="partners_clinic_records-medication" value="{{ $record['partners_clinic_records.medication'] }}" placeholder="{{ lang('common.enter') }} {{ lang('clinicrecords.medication') }} " /> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('clinicrecords.med_qty') }} </label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[medication_qty]" id="partners_clinic_records-medication_qty" value="{{ $record['partners_clinic_records.medication_qty'] }}" placeholder="{{ lang('common.enter') }} {{ lang('clinicrecords.med_qty') }} " /> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('clinicrecords.complaint') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_clinic_records[complaint]" id="partners_clinic_records-complaint" placeholder="Enter Complaint" rows="4">{{ $record['partners_clinic_records.complaint'] }}</textarea> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('clinicrecords.diagnosis') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_clinic_records[diagnosis]" id="partners_clinic_records-diagnosis" placeholder="Enter Diagnosis" rows="4">{{ $record['partners_clinic_records.diagnosis'] }}</textarea> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('clinicrecords.other_meds') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[other_med_cost]" id="partners_clinic_records-other_med_cost" value="{{ $record['partners_clinic_records.other_med_cost'] }}" placeholder="{{ lang('common.enter') }} {{ lang('clinicrecords.other_meds') }}" /> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('clinicrecords.details') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_clinic_records[details]" id="partners_clinic_records-details" value="{{ $record['partners_clinic_records.details'] }}" placeholder="{{ lang('common.enter') }} {{ lang('clinicrecords.details') }}" /> 				</div>	
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">{{ lang('clinicrecords.attachments') }}</label>
				<div class="col-md-7">
					<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_clinic_records-attachments-container">
								@if( !empty($record['partners_clinic_records.attachments']) )
									<?php 
										$file = FCPATH . urldecode( $record['partners_clinic_records.attachments'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="partners_clinic_records[attachments]" id="partners_clinic_records-attachments" value="{{ $record['partners_clinic_records.attachments'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('clinicrecords.select_file') }}</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('common.change') }}</span>
										<input type="file" id="partners_clinic_records-attachments-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
								</div>
					</div>
				</div>	
			</div>
	</div>
</div>