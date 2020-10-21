<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('erequest_admin.online_request') }}
			<span class="text-muted small">{{ lang('common.view') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('erequest_admin.request_item') }} :</label>
						<div class="col-md-8 col-sm-8">
							<span>{{$record['resources_request.request']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('erequest_admin.date_needed') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['resources_request.date_needed']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('erequest_admin.reason') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['resources_request.reason']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('erequest_admin.file_upload') }} :</label>
						<div class="controls col-md-6">							
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
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
