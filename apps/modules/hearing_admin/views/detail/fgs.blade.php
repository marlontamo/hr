<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('hearing_admin.nte') }}
			<span class="text-muted small">{{ lang('common.view') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.involved') }} :</label>
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.offense') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['offense']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.complainants') }} :</label>
						<div class="col-md-7 col-sm-7">
							<?php 
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['complainants']})";		
								$result = $db->query($get_users);
								if ($result && $result->num_rows() > 0){
									$select_users = $result->result_array();
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
			</div><div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.date_time_offense') }} :</label>
						<div class="col-md-7 col-sm-7">{{date('F d, Y - h:i a', strtotime($record['date_time_of_offense']))}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.attachments') }} :</label>
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
		<div class="caption">{{ lang('hearing_admin.details_offense') }}
			<!-- <span class="text-muted small">view</span> -->
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p class="margin-bottom-25">{{ lang('hearing_admin.note_detail_offense') }}</p>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.witnesses') }} :</label>
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.location') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['location']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.details_violation') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['violation_details']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.damages') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['damages']}}</span>
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
			{{ lang('hearing_admin.emp_explain') }}
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">
		{{ lang('hearing_admin.note_explain') }}
	</p>
	<div class="portlet-body">
		<!-- <form id="immediate_remarks"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							{{ lang('hearing_admin.explanations') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['involved_explanation']['explanation']}}
						</div>
					</div>
				</div>
			</div>		        
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.attachments') }} :</label>
						<div class="controls col-md-6">							
                            <!-- <ul class="padding-none margin-top-10"> -->
                            @if( !empty($record['involved_explanation']['attachments']) )
								<?php 
									$file = FCPATH . urldecode( $record['involved_explanation']['attachments']);
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
												echo '<a class="fancybox-button" href="'.base_url($record['involved_explanation']['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            	<span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												echo '<a href="'.base_url($record['involved_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												echo '<a href="'.base_url($record['involved_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											default:
												$icon = 'fa-file-text-o';
												echo '<a href="'.base_url($record['involved_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
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
	    <!-- </form> -->
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			{{ lang('hearing_admin.witness_explanation') }}
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">
		{{ lang('hearing_admin.note_witness') }}
	</p>
	<div class="portlet-body">
		<!-- <form id="immediate_remarks"> -->
        <div class="form-body">
	        @foreach($record['witnesses_explanation'] as $witness)
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								{{ lang('hearing_admin.witness_name') }} :
							</label>
							<div class="col-md-7 col-sm-7">
								{{$witness['full_name']}}
							</div>
						</div>
					</div>
				</div>	
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								{{ lang('hearing_admin.explanations') }} :
							</label>
							<div class="col-md-7 col-sm-7">
								{{$witness['explanation']}}
							</div>
						</div>
					</div>
				</div>		        
				<div class="row">
					<div class="col-md-12">
		                <div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.attachments') }} :</label>
							<div class="controls col-md-6">							
	                            <!-- <ul class="padding-none margin-top-10"> -->
	                            @if( !empty($witness['attachments']) )
									<?php 
										$file = FCPATH . urldecode( $witness['attachments']);
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
												echo '<a class="fancybox-button" href="'.base_url($witness['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            	<span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												echo '<a href="'.base_url($witness['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												echo '<a href="'.base_url($witness['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											default:
												$icon = 'fa-file-text-o';
												echo '<a href="'.base_url($witness['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
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
				<br>
			@endforeach
        </div>		
	    <!-- </form> -->
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			{{ lang('hearing_admin.supervisor_explanation') }}
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">
		{{ lang('hearing_admin.note_sup') }}
	</p>
	<div class="portlet-body">
		<!-- <form id="immediate_remarks"> -->
        <div class="form-body">
        @if(!empty($record['immediate_explanation']))

	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							{{ lang('hearing_admin.sup_name') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['immediate_explanation']['full_name']}}
						</div>
					</div>
				</div>
			</div>	
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							{{ lang('hearing_admin.explanations') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['immediate_explanation']['explanation']}}
						</div>
					</div>
				</div>
			</div>		        
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('hearing_admin.attachments') }} :</label>
						<div class="controls col-md-6">							
                            <!-- <ul class="padding-none margin-top-10"> -->
                            @if( !empty($record['immediate_explanation']['attachments']) )
								<?php 
									$file = FCPATH . urldecode( $record['immediate_explanation']['attachments']);
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
												echo '<a class="fancybox-button" href="'.base_url($record['immediate_explanation']['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            	<span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												echo '<a href="'.base_url($record['immediate_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												echo '<a href="'.base_url($record['immediate_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											default:
												$icon = 'fa-file-text-o';
												echo '<a href="'.base_url($record['immediate_explanation']['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
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
    	@endif
        </div>		
	    <!-- </form> -->
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			{{ lang('hearing_admin.hearing_sched') }}
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">
		{{ lang('hearing_admin.set_sched') }}
	</p>
	<div class="portlet-body">
		<!-- <form id="immediate_remarks"> -->
        <div class="form-body">
        	
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								<span class="required">*</span>{{ lang('hearing_admin.date_hearing') }} :
							</label>
							<div class="col-md-7 col-sm-7">
								<div class="input-group date form_datetime"> 
									<input type="text" size="16" readonly class="form-control" name="partners_incident_nte[hearing_date]" id="partners_incident_nte-hearing_date" value="{{ $record['nte_hearing_date'] }}" />
									<!-- <span class="input-group-btn">
										<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
									</span> -->
									<span class="input-group-btn">
										<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>	
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								{{ lang('hearing_admin.remarks') }} :
							</label>
							<div class="col-md-7 col-sm-7">
	                    		<textarea rows="4" class="form-control" name="partners_incident_nte[hr_remarks]">{{$record['nte_hr_remarks']}}</textarea>
							</div>
						</div>
					</div>
				</div>	
	    
        </div>		
	    <!-- </form> -->
	</div>
</div>