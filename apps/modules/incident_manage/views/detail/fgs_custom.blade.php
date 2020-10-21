<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('incident_admin.ir') }}
			<span class="text-muted small">{{ lang('common.view') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.involved') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['involved_partners']})";		
								$select_users = $db->query($get_users)->result_array();
								foreach($select_users as $value){
								?>
								<span>{{$value['firstname']}} {{$value['lastname']}}</span>
								<br />
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.offense') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['offense']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.complainants') }} :</label>
						<div class="col-md-7 col-sm-7">
							<?php 
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['complainants']})";		
								$select_users = $db->query($get_users)->result_array();
								foreach($select_users as $value){
								?>
								<span>{{$value['firstname']}} {{$value['lastname']}}</span>
								<br />
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div><div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.date_time_offense') }} :</label>
						<div class="col-md-7 col-sm-7">{{date('F d, Y - h:i a', strtotime($record['date_time_of_offense']))}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.attachments') }} :</label>
						<div class="controls col-md-6">							
                            <!-- <ul class="padding-none margin-top-10"> -->
                            @if( !empty($record['attachments']) )
								<?php 
									$file = FCPATH . urldecode( $record['attachments']);
									if( file_exists( $file ) )
									{
										$f_info = get_file_info( $file );
										$f_type = filetype( $file );

										$finfo = finfo_open(FILEINFO_MIME_TYPE);
										$f_type = finfo_file($finfo, $file);

										switch( $f_type )
										{
											case 'image/jpeg':
												$icon = 'fa-picture-o';
												echo '<a class="fancybox-button" href="'.base_url($record['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            	<span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											default:
												$icon = 'fa-file-text-o';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
										}
								        	// <li class="padding-3 fileupload-delete-'.$record_id.'" style="list-style:none;">
								        	// </li>
								            // <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$record_id.'" href="javascript:void(0)"></a></span>
									}
								?>
							@endif
                            <!-- </ul> -->
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('incident_admin.details_offense') }}
			<!-- <span class="text-muted small">view</span> -->
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p class="margin-bottom-25">{{ lang('incident_admin.note_detail_offense') }}</p>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.witnesses') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
								$record['witnesses'] = empty($record['witnesses']) ? 0 : $record['witnesses'];
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['witnesses']})";	
											
								$select_users = $db->query($get_users);
								if($select_users->num_rows() > 0){
									$select_users = $select_users->result_array();
									foreach($select_users as $value){
								?>
									<span>{{$value['firstname']}} {{$value['lastname']}}</span>
									<br />
								<?php
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.location') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['location']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.details_violation') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['violation_details']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('incident_admin.damages') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['damages']}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!--HR Remarks-->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Immediate Remarks</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('incident_manage.note_sup_remarks') }}</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form action="#" class="form-horizontal"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required">* </span>
							{{ lang('incident_manage.supervisor_remarks') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							<?php
								$readonly = '';
								if ($record['incident_status_id'] >= 9){
									$readonly = 'readonly="readonly';
								}

								switch ($coc_process) {
									case 'immediate':
										$remarks = $record['ime_remarks'];
										break;
									default:
										$record['app_remarks'];
										break;
								}
							?>							
                    		<textarea <?php echo $readonly ?> rows="4" class="form-control" name="partners_incident[immediate_remarks]">{{$remarks}}</textarea>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required">* </span>
							Send NTE to :
						</label>
						<div class="col-md-7 col-sm-7">
	                    	<input type="checkbox" class="checkboxes" value="{{$record['nte_partner']}}"
	                    	 name="partners_incident[nte_partner]" id="resources_request-nte_partner" 
	                    	 <?php if($record['nte_partner'] > 0) echo "checked" ?> /> 
	                    	<span class="small">Involved Employee</span> <br>

	                    	<input type="checkbox" class="checkboxes" value="{{$record['nte_complainants']}}"
	                    	 name="partners_incident[nte_complainants]" id="resources_request-nte_complainants" 
	                    	 <?php if($record['nte_complainants'] > 0) echo "checked" ?> /> 
	                    	<span class="small">Complainants</span> <br>

	                    	<input type="checkbox" class="checkboxes" value="{{$record['nte_witnesses']}}"
	                    	 name="partners_incident[nte_witnesses]" id="resources_request-nte_witnesses" 
	                    	 <?php if($record['nte_witnesses'] > 0) echo "checked" ?> /> 
	                    	<span class="small">Witnesses</span> <br>

	                        <input type="checkbox" class="checkboxes" value="{{$record['nte_others']}}" 
	                        name="partners_incident[nte_others]" id="partners_incident-nte_others" 
	                        <?php if($record['nte_others'] > 0) echo "checked" ?>  /> <span class="small">Other/s:</span> <br>
	                        <br>
	                        <?php
							$db->select('user_id, full_name');
							$db->where('deleted', '0');
							$db->where('active', '1');
							$options = $db->get('users');
							$user_id_options = array();
								foreach($options->result() as $option)
								{
									$user_id_options[$option->user_id] = $option->full_name;
								} 
								// echo "<pre>";print_r($user_id_options);
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('partners_incident[nte_others-temp][]',$user_id_options, explode(',', $record['nte_others-temp']), 'class="form-control select2" data-placeholder="Select..." multiple id="partners_incident-nte_others-temp"') }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- </form> -->
	</div>
</div>
<!--End-->