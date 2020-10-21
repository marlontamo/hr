<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Traning Library</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Training Course</label>
				<div class="col-md-7">							<input disabled="disabled" type="text" class="form-control" name="training_library[library]" id="training_library-library" value="{{ $record['training_library.library'] }}" placeholder="Enter Training Course" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Published Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input disabled="disabled" type="text" class="form-control" name="training_library[published_date]" id="training_library-published_date" value="{{ $record['training_library.published_date'] }}" placeholder="Enter Published Date" readonly>
								<span class="input-group-btn">
									<button disabled="disabled" class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Author</label>
				<div class="col-md-7">							<input disabled="disabled" type="text" class="form-control" name="training_library[author]" id="training_library-author" value="{{ $record['training_library.author'] }}" placeholder="Enter Author" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea disabled="disabled" class="form-control" name="training_library[description]" id="training_library-description" placeholder="Enter Description" rows="4">{{ $record['training_library.description'] }}</textarea> 				</div>	
			</div>			

			<div class="form-group">
				<label class="control-label col-md-3">Training Module</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="training_library-module-container">
								@if( !empty($record['training_library.module']) )
									<?php 
										$file = FCPATH . urldecode( $record['training_library.module'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="training_library[module]" id="training_library-module" value="{{ $record['training_library.module'] }}"/>
								<div disabled="disabled" class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span disabled="disabled" class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" id="training_library-module-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>  {{ lang('common.remove') }}</a>
								</div>
							</div> 				</div>	
			</div>
	</div>
</div>