<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Leave Without Pay Form</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_forms[form_status_id]" id="time_forms-form_status_id" value="{{ $record['time_forms.form_status_id'] }}" placeholder="Enter Status"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="Enter Reason" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">File Upload</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="time_forms_upload-upload_id-container">
                                <input type="hidden" name="time_forms_upload[upload_id]" id="time_forms_upload-upload_id" value="{{ $record['time_forms_upload.upload_id'] }}"/>
                                <span class="btn default btn-sm btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse</span>
                                <input type="file" id="time_forms_upload-upload_id-fileupload" type="file" name="files[]" multiple="">
                                </span>
                                <ul class="padding-none margin-top-10">
                                @if( !empty($record['time_forms_upload.upload_id']) )
									<?php 
										$upload_ids = explode( ',', $record['time_forms_upload.upload_id'] );
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
			</div>	</div>
</div>