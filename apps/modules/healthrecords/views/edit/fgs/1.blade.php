<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Health Records</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Partner</label>
				<div class="col-md-7"><?php									                            		$db->select('partner_id,alias');
	                            			                            		$db->order_by('alias', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners'); 	                            $partners_health_records_partner_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_health_records_partner_id_options[$option->partner_id] = $option->alias;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_health_records[partner_id]',$partners_health_records_partner_id_options, $record['partners_health_records.partner_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_health_records-partner_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Form Type</label>
				<div class="col-md-7"><?php									                            		$db->select('health_type_id,health_type');
	                            			                            		$db->order_by('health_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_health_type'); 	                            $partners_health_records_health_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_health_records_health_type_id_options[$option->health_type_id] = $option->health_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_health_records[health_type_id]',$partners_health_records_health_type_id_options, $record['partners_health_records.health_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_health_records-health_type_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Health Provider</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_health_records[health_provider]" id="partners_health_records-health_provider" value="{{ $record['partners_health_records.health_provider'] }}" placeholder="Enter Health Provider" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date of Completion</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_health_records[date_of_completion]" id="partners_health_records-date_of_completion" value="{{ $record['partners_health_records.date_of_completion'] }}" placeholder="Enter Date of Completion" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Status</label>
				<div class="col-md-7"><?php									                            		$db->select('health_type_status_id,health_type_status');
	                            			                            		$db->order_by('health_type_status', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_health_type_status'); 	                            $partners_health_records_health_type_status_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_health_records_health_type_status_id_options[$option->health_type_status_id] = $option->health_type_status;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_health_records[health_type_status_id]',$partners_health_records_health_type_status_id_options, $record['partners_health_records.health_type_status_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_health_records-health_type_status_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachments</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_health_records-attachments-container">
								@if( !empty($record['partners_health_records.attachments']) )
									<?php 
										$file = FCPATH . urldecode( $record['partners_health_records.attachments'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="partners_health_records[attachments]" id="partners_health_records-attachments" value="{{ $record['partners_health_records.attachments'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" id="partners_health_records-attachments-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>