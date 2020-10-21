<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Safe Manhour</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Partner</label>
				<div class="col-md-7"><?php									                            		$db->select('partner_id,alias');
	                            			                            		$db->order_by('alias', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners'); 	                            $partners_safe_manhour_partner_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_safe_manhour_partner_id_options[$option->partner_id] = $option->alias;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_safe_manhour[partner_id]',$partners_safe_manhour_partner_id_options, $record['partners_safe_manhour.partner_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_safe_manhour-partner_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Nature </label>
				<div class="col-md-7"><?php									                            		$db->select('nature_id,nature');
	                            			                            		$db->order_by('nature', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_safe_manhour_nature'); 	                            $partners_safe_manhour_nature_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_safe_manhour_nature_id_options[$option->nature_id] = $option->nature;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_safe_manhour[nature_id]',$partners_safe_manhour_nature_id_options, $record['partners_safe_manhour.nature_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_safe_manhour-nature_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Health Provider</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_safe_manhour[health_provider]" id="partners_safe_manhour-health_provider" value="{{ $record['partners_safe_manhour.health_provider'] }}" placeholder="Enter Health Provider" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Total Manhour</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_safe_manhour[total_manhour]" id="partners_safe_manhour-total_manhour" value="{{ $record['partners_safe_manhour.total_manhour'] }}" placeholder="Enter Total Manhour" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date of Incident</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_safe_manhour[date_incident]" id="partners_safe_manhour-date_incident" value="{{ $record['partners_safe_manhour.date_incident'] }}" placeholder="Enter Date of Incident" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date of Return to Work</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_safe_manhour[date_return_to_work]" id="partners_safe_manhour-date_return_to_work" value="{{ $record['partners_safe_manhour.date_return_to_work'] }}" placeholder="Enter Date of Return to Work" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Status </label>
				<div class="col-md-7"><?php									                            		$db->select('status_id,status');
	                            			                            		$db->order_by('status', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_safe_manhour_status'); 	                            $partners_safe_manhour_status_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_safe_manhour_status_id_options[$option->status_id] = $option->status;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_safe_manhour[status_id]',$partners_safe_manhour_status_id_options, $record['partners_safe_manhour.status_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_safe_manhour-status_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Medication </label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_safe_manhour[medication]" id="partners_safe_manhour-medication" value="{{ $record['partners_safe_manhour.medication'] }}" placeholder="Enter Medication " /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Medication Quantity</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_safe_manhour[medication_qty]" id="partners_safe_manhour-medication_qty" value="{{ $record['partners_safe_manhour.medication_qty'] }}" placeholder="Enter Medication Quantity" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Details</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_safe_manhour[details]" id="partners_safe_manhour-details" placeholder="Enter Details" rows="4">{{ $record['partners_safe_manhour.details'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachments</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_safe_manhour-attachment-container">
								@if( !empty($record['partners_safe_manhour.attachment']) )
									<?php 
										$file = FCPATH . urldecode( $record['partners_safe_manhour.attachment'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="partners_safe_manhour[attachment]" id="partners_safe_manhour-attachment" value="{{ $record['partners_safe_manhour.attachment'] }}"/>
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
										<input type="file" id="partners_safe_manhour-attachment-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>