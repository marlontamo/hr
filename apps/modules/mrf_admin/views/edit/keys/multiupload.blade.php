<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-7">
    	<div data-provides="fileupload" class="fileupload fileupload-new" id="<?php echo $id?>-container">
        <input type="hidden" name="key[{{$key->key_id}}]" value="<?php if( isset($key->key_value) ) echo $key->key_value?>"/>
	        <span class="btn default btn-sm btn-file">
	        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('mrf_admin.select_file') }}</span>
	        <input type="file" id="<?php echo $id?>-fileupload" type="file" name="files[]" multiple="">
	        </span>
	        <ul class="padding-none margin-top-10">
	        @if( !empty($record['<?php echo $f_name?>']) )
				<?php echo '<?php'?> 
					$upload_ids = explode( ',', $record['<?php echo $f_name?>'] );
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
				<?php echo '?>'?>
			@endif
	        </ul>
	    </div>
    </div>
</div>