<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('nte.ir') }}
			<span class="text-muted small">{{ lang('common.view') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.involved') }} :</label>
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.offense') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['offense']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.complainants') }} :</label>
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.date_time_offense') }} :</label>
						<div class="col-md-7 col-sm-7">{{date('F d, Y - h:i a', strtotime($record['date_time_of_offense']))}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.attachments') }} :</label>
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
		<div class="caption">{{ lang('nte.details_offense') }}
			<!-- <span class="text-muted small">view</span> -->
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p class="margin-bottom-25">{{ lang('nte.note_detail_offense') }}</p>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.witnesses') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
								$record['witnesses'] = empty($record['witnesses']) ? 0 : $record['witnesses'];
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['witnesses']})";		
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.location') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['location']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.details_violation') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['violation_details']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.damages') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['damages']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('nte.supervisor_remarks') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['hr_remarks']}}</span>
						</div>
					</div>
				</div>
			</div>			
		</div>
    </div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			@if($record['category'] == 'partner')
				{{ lang('nte.emp_explain') }}
			@elseif($record['category'] == 'complainants')
				{{ lang('nte.complainant_explain') }}
			@elseif($record['category'] == 'immediate')
				{{ lang('nte.immediate_explain') }}
			@else
				{{ lang('nte.witness_explanation') }}
			@endif
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('nte.note_explain') }}</p>

	<div class="portlet-body">
		<!-- <form id="immediate_remarks"> -->
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
	        <div class="form-body">
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								<span class="required">* </span>
								{{ lang('nte.explanations') }} :
							</label>
							<div class="col-md-7 col-sm-7">
								<?php
									$readonly = '';
									if (in_array($record['incident_status_id'],array(6))){
										$readonly = 'readonly="readonly"';
									}
								?>
	                    			<textarea <?php echo $readonly ?> rows="4" class="form-control" name="partners_incident_nte[explanation]">{{$record['explanation']}}</textarea>
							</div>
						</div> 
					</div>
				</div>
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								{{ lang('nte.attachments') }} :
							</label>
							<div class="col-md-7 col-sm-7">
								<div data-provides="fileupload" class="fileupload fileupload-new" id="partners_incident_nte-attachments-container">
									@if( !empty($record['partners_incident_nte.attachments']) )
										<?php 
											$file = FCPATH . urldecode( $record['partners_incident_nte.attachments'] );
											if( file_exists( $file ) )
											{
												$if_info = get_file_info( $file );
											}
										?>								
									@endif
									<input type="hidden" name="partners_incident_nte[attachments]" id="partners_incident_nte-attachments" value="{{ $record['partners_incident_nte.attachments'] }}"/>
									<div class="input-group">
										<span class="input-group-btn">
											<span class="uneditable-input">
												<i class="fa fa-file fileupload-exists"></i> 
												<span class="fileupload-preview">@if( isset($if_info['name'] ) ) {{ basename($if_info['name']) }} @endif</span>
											</span>
										</span>
										<span class="btn default btn-file">
											<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('nte.select_file') }}</span>
											<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
											<input type="file" id="partners_incident_nte-attachments-fileupload" type="file" name="files[]">
										</span>
										<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>						
					

	        </div>		

	    <!-- </form> -->
	</div>
</div>