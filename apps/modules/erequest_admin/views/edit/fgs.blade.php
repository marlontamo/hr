<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('erequest_admin.online_request') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>{{ lang('erequest_admin.online_request') }}</p>
		<div class="portlet-body form">			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('erequest_admin.request_item') }}</label>
				<div class="col-md-7">							
					<input type="text" disabled class="form-control" name="resources_request[request]" id="resources_request-request" value="{{ $record['resources_request.request'] }}" placeholder="{{ lang('common.enter') }} {{ lang('erequest_admin.request_item') }}" /> 				
				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('erequest_admin.date_needed') }}</label>
				<div class="col-md-7">							
					<div class="input-group input-medium " data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" disabled name="resources_request[date_needed]" id="resources_request-date_needed" value="{{ $record['resources_request.date_needed'] }}" placeholder="{{ lang('common.enter') }} {{ lang('erequest_admin.date_needed') }}" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('erequest_admin.reason') }}</label>
				<div class="col-md-7">							<textarea disabled class="form-control" name="resources_request[reason]" id="resources_request-reason" placeholder="{{ lang('common.enter') }} {{ lang('erequest_admin.reason') }}" rows="4">{{ $record['resources_request.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('erequest_admin.attachments') }}</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="resources_request_upload-upload_id-container">
                                <input type="hidden" name="resources_request_upload[upload_id]" id="resources_request_upload-upload_id" value="{{ $record['resources_request_upload.upload_id'] }}"/>
                                <span class="btn default btn-sm btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('erequest_admin.select_file') }}</span>
                                <input type="file" disabled id="resources_request_upload-upload_id-fileupload" type="file" name="files[]" multiple="">
                                </span>
                                <ul class="padding-none margin-top-10">
                                @if( !empty($record['resources_request_upload.upload_id']) )
									<?php 
										$upload_ids = explode( ',', $record['resources_request_upload.upload_id'] );
										foreach( $upload_ids as $upload_id )
										{
											$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id))->row();
											$file = FCPATH . urldecode( $upload->upload_path );
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
														break;
													case 'video/mp4':
														$icon = 'fa-film';
														break;
													case 'audio/mpeg':
														$icon = 'fa-volume-up';
														break;
													default:
														$icon = 'fa-file-text-o';
												}
												echo '<li class="padding-3 fileupload-delete-'.$upload_id.'" style="list-style:none;">
										            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
										            <span>'. basename($f_info['name']) .'</span>
										            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id.'" href="javascript:void(0)"></a></span>
										        </li>';
											}
										}
									?>								@endif
                                </ul>
                            </div> 				</div>	
			</div>			<div class="form-group hidden">
				<label class="control-label col-md-3">User</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $resources_request_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$resources_request_user_id_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('resources_request[user_id]',$resources_request_user_id_options, $record['resources_request.user_id'], 'class="form-control select2me" data-placeholder="Select..." id="resources_request-user_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('erequest_admin.admin_sec') }}</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('erequest_admin.note_admin_sec') }}</p>

	<div class="portlet-body form">
		<!-- BEGIN FORM-->        
        <!-- <div class="form-body"> -->
        	<div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>{{ lang('common.remarks') }}
                </label>
                <div class="col-md-7">
                    <textarea class="form-control" rows="4" name="resources_request[remarks]" id="resources_request-remarks" >{{ $record['resources_request.remarks'] }}</textarea>
                </div>
            </div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('erequest_admin.attachments') }}</label>
				<div class="col-md-7">							
					<div data-provides="fileupload" class="fileupload fileupload-new" id="resources_request_upload_hr-upload_id-container">
                        <input type="hidden" name="resources_request_upload_hr[upload_id]" id="resources_request_upload_hr-upload_id" value="{{ $record['resources_request_upload_hr.upload_id'] }}"/>
                        <span class="btn default btn-sm btn-file">
                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('erequest_admin.select_file') }}</span>
                        <input type="file" id="resources_request_upload_hr-upload_id-fileupload" type="file" name="files[]" multiple="">
                        </span>
                        <ul class="padding-none margin-top-10">
                        @if( !empty($record['resources_request_upload_hr.upload_id']) )
							<?php 
								$upload_ids = explode( ',', $record['resources_request_upload_hr.upload_id'] );
								foreach( $upload_ids as $upload_id )
								{
									$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id))->row();
									$file = FCPATH . urldecode( $upload->upload_path );
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
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												break;
											default:
												$icon = 'fa-file-text-o';
										}
										echo '<li class="padding-3 fileupload-delete-'.$upload_id.'" style="list-style:none;">
								            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span>
								            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id.'" href="javascript:void(0)"></a></span>
								        </li>';
									}
								}
							?>
							@endif
                        </ul>
                    </div>

					<div class="help-block small">
						{{ lang('erequest_admin.req_docs') }}
					</div>
                </div>	
			</div>		
            <div class="form-group">
                <label class="control-label col-md-3">{{ lang('erequest_admin.notify_email') }}:
                </label>
                <div class="col-md-7">
                    <input type="checkbox" value="{{$record['resources_request.notify_immediate']}}" class="checkboxes" name="resources_request[notify_immediate]" id="resources_request-notify_immediate" <?php if($record['resources_request.notify_immediate'] > 0) echo "checked" ?> /> <span class="small">{{ lang('erequest_admin.immediate') }}</span> <br>
                    <input type="checkbox" value="1" class="checkboxes" name="resources_request[notify_others-temp]" id="resources_request-notify_others-temp" <?php if(strlen($record['resources_request.notify_others']) >0) echo "checked" ?> /> <span class="small">{{ lang('erequest_admin.others') }}:</span> 
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
						{{ form_dropdown('resources_request[notify_others][]',$user_id_options, explode(',', $record['resources_request.notify_others']), 'class="form-control select2" data-placeholder="Select..." multiple id="resources_request-notify_others"') }}
					</div>
                </div>
            </div>
        <!-- </div> -->
        
	</div>
</div>