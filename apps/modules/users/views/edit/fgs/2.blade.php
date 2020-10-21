<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Personal Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Firstname</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="Enter Firstname" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Lastname</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="Enter Lastname" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Middlename</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="Enter Middlename" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Nickname</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="Enter Nickname" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Photo</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="users_profile-photo-container">
								@if( !empty($record['users_profile.photo']) )
									<?php 
										$file = FCPATH . urldecode( $record['users_profile.photo'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="users_profile[photo]" id="users_profile-photo" value="{{ $record['users_profile.photo'] }}"/>
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
										<input type="file" id="users_profile-photo-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>