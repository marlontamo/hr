<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Online Request</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Online Request</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Request Item</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="resources_request[request]" id="resources_request-request" value="{{ $record['resources_request.request'] }}" placeholder="Enter Request Item" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date Needed</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="resources_request[date_needed]" id="resources_request-date_needed" value="{{ $record['resources_request.date_needed'] }}" placeholder="Enter Date Needed" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="resources_request[reason]" id="resources_request-reason" placeholder="Enter Reason" rows="4">{{ $record['resources_request.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachments</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="resources_request_upload-upload_id-container">
                                <input type="hidden" name="resources_request_upload[upload_id]" id="resources_request_upload-upload_id" value="{{ $record['resources_request_upload.upload_id'] }}"/>
                                <span class="btn default btn-sm btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse</span>
                                <input type="file" id="resources_request_upload-upload_id-fileupload" type="file" name="files[]" multiple="">
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
			</div>			<div class="form-group">
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