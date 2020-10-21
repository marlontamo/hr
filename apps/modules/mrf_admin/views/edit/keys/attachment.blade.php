<div class="form-group">
    <label class="control-label col-md-3">{{ $key->key_label }}</label>
    <div class="col-md-5">
	@if( $record['recruitment_request.status_id'] > 1 )
		@if( isset($record['recruitment_request.attachment']) )
			@if( !empty($record['recruitment_request.attachment']) )
				<?php 
					$file = FCPATH . urldecode( $record['recruitment_request.attachment'] );
					if( file_exists( $file ) )
					{
						$f_info = get_file_info( $file );

                        $notification_link = base_url().$record['recruitment_request.attachment'];
                        echo '<div class="input-group">';
                        echo '<a href="'.$notification_link.'" class="pop-uri" target="_blank">'.basename($f_info['name']).'</a>';
                        echo '</div>';
					}
				?>
			@endif
		@endif
	@else
    	<div data-provides="fileupload" class="fileupload fileupload-new" id="recruitment_request-attachment-container">
			@if( isset($record['recruitment_request.attachment']) )
				@if( !empty($record['recruitment_request.attachment']) )
					<?php 
						$file = FCPATH . urldecode( $record['recruitment_request.attachment'] );
						if( file_exists( $file ) )
						{
							$f_info = get_file_info( $file );
						}
					?>
				@endif
			@endif
			<input type="hidden" name="recruitment_request[attachment]" id="recruitment_request-attachment" value="@if( isset($record['recruitment_request.attachment']) ) {{ $record['recruitment_request.attachment'] }} @endif"/>
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
					<input type="file" accept="application/pdf, image/*" id="recruitment_request-attachment-fileupload" type="file" name="files[]">
				</span>
				<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
				
			</div>
			<div class="help-block text-muted small">{{ $key->help_block }}</div>
		</div>	
	@endif
    </div>
</div>