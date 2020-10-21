<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('incident_report.ir') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('incident_report.involved') }}</label>
			<div class="col-md-7">
				<?php	$db->select('user_id,full_name');
						$db->order_by('full_name', '0');
						$db->where('deleted', '0');
						$db->where('active', '1');
						$db->where('user_id <>', '1');
						$options = $db->get('users');
						$partners_incident_involved_partners_options = array('' => 'Select...');
						foreach($options->result() as $option)
						{
							$partners_incident_involved_partners_options[$option->user_id] = $option->full_name;
						} 
				?>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					{{ form_dropdown('partners_incident[involved_partners]',$partners_incident_involved_partners_options, explode(',', $record['partners_incident.involved_partners']), 'class="form-control select2me" data-placeholder="Select..." id="partners_incident-involved_partners"') }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('incident_report.offense') }} </label>
			<div class="col-md-7">
				<?php 	$db->select('offense_id,offense');
						$db->order_by('offense', '0');
						$db->where('deleted', '0');
						$options = $db->get('partners_offense');
						$partners_incident_offense_id_options = array('' => 'Select...');
						foreach($options->result() as $option)
						{
							$partners_incident_offense_id_options[$option->offense_id] = $option->offense;
						} 
				?>							
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					{{ form_dropdown('partners_incident[offense_id]',$partners_incident_offense_id_options, $record['partners_incident.offense_id'], 'class="form-control select2" data-placeholder="Select..." id="partners_incident-offense_id"') }}
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('incident_report.complainants') }}</label>
			<div class="col-md-7">
				<?php	$db->select('user_id,full_name');
						$db->order_by('full_name', '0');
						$db->where('deleted', '0');
						$db->where('active', '1');
						$db->where('user_id <>', '1');
						$options = $db->get('users');
						$partners_incident_complainants_options = array();
						foreach($options->result() as $option)
						{
							$partners_incident_complainants_options[$option->user_id] = $option->full_name;
						} 
				?>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					<input type="text" value="{{ $current_user->full_name }}" readonly="readonly" class="form-control dontserializeme"> 
					{{ form_dropdown('partners_incident[complainants][]',$partners_incident_complainants_options, $current_user->user_id, 'class="form-control select2" data-placeholder="Select..." id="partners_incident-complainants" style="display:none"') }}
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('incident_report.date_time_offense') }}</label>
			<div class="col-md-7">
				<div class="input-group date form_datetime">
					<input type="text" size="16" readonly class="form-control" name="partners_incident[date_time_of_offense]" id="partners_incident-date_time_of_offense" value="{{ $record['partners_incident.date_time_of_offense'] }}" />
						<!-- <span class="input-group-btn">
								<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
								</span> -->
					<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('incident_report.attachments') }}</label>
			<div class="col-md-7">
				<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_incident-attachments-container">
					<?php  if( !empty($record['partners_incident.attachments']) ){
							$file = FCPATH . urldecode( $record['partners_incident.attachments'] );
							if( file_exists( $file ) )
							{
								$f_info = get_file_info( $file );
							}
						}
					?>
					
					<input type="hidden" name="partners_incident[attachments]" id="partners_incident-attachments" value="{{ $record['partners_incident.attachments'] }}"/>
					<div class="input-group">
						<span class="input-group-btn">
							<span class="uneditable-input">
							<i class="fa fa-file fileupload-exists"></i> 
							<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
							</span>
						</span>
						<span class="btn default btn-file">
							<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('incident_report.select_file') }}</span>
							<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
							<input type="file" id="partners_incident-attachments-fileupload" type="file" name="files[]">
						</span>
						<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('incident_report.details_offense') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('incident_report.witnesses') }}</label>
			<div class="col-md-7">
				<?php									                            		
					$db->select('user_id,full_name');
					$db->order_by('full_name', '0');
					$db->where('deleted', '0');
					$db->where('active', '1');
					$db->where('user_id <>', '1');
					$options = $db->get('users');
					$partners_incident_witnesses_options = array();
					foreach($options->result() as $option)
					{
						$partners_incident_witnesses_options[$option->user_id] = $option->full_name;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
					{{ form_dropdown('partners_incident[witnesses][]',$partners_incident_witnesses_options, explode(',', $record['partners_incident.witnesses']), 'class="form-control select2" data-placeholder="Select..." multiple id="partners_incident-witnesses"') }}
				</div> 				
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('incident_report.location') }}</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="partners_incident[location]" id="partners_incident-location" value="{{ $record['partners_incident.location'] }}" placeholder="{{ lang('incident_report.enter') }} {{ lang('incident_report.location') }}" />
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('incident_report.details_violation') }} </label>
			<div class="col-md-7">
				<textarea class="form-control" name="partners_incident[violation_details]" id="partners_incident-violation_details" placeholder="{{ lang('incident_report.enter') }} {{ lang('incident_report.details_violation') }} " rows="4">{{ $record['partners_incident.violation_details'] }}</textarea>
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('incident_report.damages') }} </label>
			<div class="col-md-7">
				<textarea class="form-control" name="partners_incident[damages]" id="partners_incident-damages" placeholder="{{ lang('incident_report.enter') }} {{ lang('incident_report.damages') }}" rows="4">{{ $record['partners_incident.damages'] }}</textarea>
			</div>	
		</div>	
	</div>
</div>