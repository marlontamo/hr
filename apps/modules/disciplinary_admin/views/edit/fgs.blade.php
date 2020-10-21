<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Disciplinary Action </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Involved Employee/s</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $partners_incident_involved_partners_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_incident_involved_partners_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_incident[involved_partners]',$partners_incident_involved_partners_options, explode(',', $record['partners_incident.involved_partners']), 'class="form-control select2" data-placeholder="Select..." id="partners_incident-involved_partners"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Offense </label>
				<div class="col-md-7"><?php									                            		$db->select('offense_id,offense');
	                            			                            		$db->order_by('offense', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_offense'); 	                            $partners_incident_offense_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_incident_offense_id_options[$option->offense_id] = $option->offense;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_incident[offense_id]',$partners_incident_offense_id_options, $record['partners_incident.offense_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_incident-offense_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Complainant/s</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $partners_incident_complainants_options = array();
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_incident_complainants_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_incident[complainants][]',$partners_incident_complainants_options, explode(',', $record['partners_incident.complainants']), 'class="form-control select2" data-placeholder="Select..." multiple id="partners_incident-complainants"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date and Time of Offense</label>
				<div class="col-md-7">							<div class="input-group date form_datetime">                                       
								<input type="text" size="16" readonly class="form-control" name="partners_incident[date_time_of_offense]" id="partners_incident-date_time_of_offense" value="{{ $record['partners_incident.date_time_of_offense'] }}" />
								<!-- <span class="input-group-btn">
									<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
								</span> -->
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachments</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_incident-attachments-container">
								@if( !empty($record['partners_incident.attachments']) )
									<?php 
										$file = FCPATH . urldecode( $record['partners_incident.attachments'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="partners_incident[attachments]" id="partners_incident-attachments" value="{{ $record['partners_incident.attachments'] }}"/>
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
										<input type="file" id="partners_incident-attachments-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Details of Offense</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Witnesses</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $partners_incident_witnesses_options = array();
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_incident_witnesses_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_incident[witnesses][]',$partners_incident_witnesses_options, explode(',', $record['partners_incident.witnesses']), 'class="form-control select2" data-placeholder="Select..." multiple id="partners_incident-witnesses"') }}
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
<!--HR Remarks-->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Sanction Details</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section contains sanction details.</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form action="#" class="form-horizontal"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>
							Sanction : 
						</label>
						<div class="col-md-7 col-sm-7">
							<?php
								$db->select('sanction_id, offense_level, sanction');
								$db->order_by('offense_level', '0');
								$db->where('partners_offense_sanction.deleted', '0');
								$db->join('partners_offense_level', 'partners_offense_level.offense_level_id = partners_offense_sanction.offense_level_id');
								$options = $db->get('partners_offense_sanction');
								$partners_offense_sanction_options = array(''=>'select...');
                        		foreach($options->result() as $option)
                        		{
                        			$partners_offense_sanction_options[$option->sanction_id] = $option->offense_level.' - '.$option->sanction;
                        		} 
                        	?>
                        	<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_disciplinary_action[sanction_id]',$partners_offense_sanction_options, explode(',', $record['da_sanction_id']), 'class="form-control select2me" data-placeholder="Select..." id="partners_disciplinary_action-sanction_id"') }}
	                        </div>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<!-- <span class="required">* </span> -->
							Suspended From :
						</label>
						<div class="col-md-7 col-sm-7">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_disciplinary_action[date_from]" id="partners_disciplinary_action-date_from" value="{{ $record['da_date_from'] }}" placeholder="">
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 	
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<!-- <span class="required">* </span> -->
							Suspended To :
						</label>
						<div class="col-md-7 col-sm-7">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_disciplinary_action[date_to]" id="partners_disciplinary_action-date_to" value="{{ $record['da_date_to'] }}" placeholder="">
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 	
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<!-- <span class="required">* </span> -->
							Suspension :
							<br>
							<span class="small text-muted">day/s</span>
						</label>
						<div class="col-md-7 col-sm-7">
							<input type="text" class="form-control" name="partners_disciplinary_action[suspension_days]" id="partners_disciplinary_action-suspension_days" value="{{ $record['da_suspension_days'] }}" /> 
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<!-- <span class="required">* </span> -->
							Payment For Damages  :
						</label>
						<div class="col-md-7 col-sm-7">
							<input type="text" class="form-control" name="partners_disciplinary_action[damages_payment]" id="partners_disciplinary_action-damages_payment" value="{{ $record['da_damages_payment'] }}" /> 
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3">
							<span class="required">* </span>
							Remark/s :
						</label>
						<div class="col-md-7 col-sm-7">
                    		<textarea rows="4" class="form-control" name="partners_disciplinary_action[remarks]">{{$record['da_remarks']}}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- </form> -->
	</div>
</div>