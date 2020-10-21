<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Badges</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_badges[badge_code]" id="play_badges-badge_code" value="{{ $record['play_badges.badge_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_badges[badge]" id="play_badges-badge" value="{{ $record['play_badges.badge'] }}" placeholder="Enter Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Points</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_badges[points]" id="play_badges-points" value="{{ $record['play_badges.points'] }}" placeholder="Enter Points" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="play_badges[description]" id="play_badges-description" placeholder="Enter Description" rows="4">{{ $record['play_badges.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Image/Icon</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="play_badges-image_path-container">
								@if( !empty($record['play_badges.image_path']) )
									<?php 
										$file = FCPATH . urldecode( $record['play_badges.image_path'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="play_badges[image_path]" id="play_badges-image_path" value="{{ $record['play_badges.image_path'] }}"/>
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
										<input type="file" id="play_badges-image_path-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>  {{ lang('common.remove') }}</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>