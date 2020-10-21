<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Memorandum Detail</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Enter memorandum details</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Memo Body</label>
				<div class="col-md-7">							<textarea class="form-control" name="memo[memo_body]" id="memo-memo_body" placeholder="Enter Memo Body" rows="4">{{ $record['memo.memo_body'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachment</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="memo-attachment-container">
								@if( !empty($record['memo.attachment']) )
									<?php 
										$file = FCPATH . urldecode( $record['memo.attachment'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="memo[attachment]" id="memo-attachment" value="{{ $record['memo.attachment'] }}"/>
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
										<input type="file" id="memo-attachment-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>