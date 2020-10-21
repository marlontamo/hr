<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.gen_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- <form action="#" class="form-horizontal"> -->
		<form class="form-horizontal" id="form-1" partner_id="1" method="POST">
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.title') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<div class="input-group">
							<span class="input-group-addon">
                            	<i class="fa fa-list-ul"></i>
	                        </span>
		                    <select data-placeholder="Select..." class="form-control select2me" name="users_profile[title]" id="users_profile-title" >
		                    	<option value="">Select...</option>
		                    	<option value="Mr." {{ ($record['users_profile.title'] == "Mr.") ? 'selected="selected"'  : '' }} >Mr.</option>
		                    	<option value="Mrs." {{ ($record['users_profile.title'] == "Mrs.") ? 'selected="selected"'  : '' }}>Mrs.</option>
		                    	<option value="Miss" {{ ($record['users_profile.title'] == "Miss") ? 'selected="selected"'  : '' }}>Miss</option>
		                    </select>
	                    </div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.last') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="Enter Last Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.first') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="Enter First Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.middle') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="Enter Middle Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.suffix') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[suffix]" id="users_profile-suffix" value="{{ $record['users_profile.suffix'] }}" placeholder="Enter Suffix"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.maiden') }} <br><small class="text-muted">(if applicable)</small></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[maidenname]" id="users_profile-maidenname" value="{{ $record['users_profile.maidenname'] }}" placeholder="Enter Maiden Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.nick') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="Enter Nick Name"/>
					</div>
				</div>
				<div class="form-group">
                	<label class="control-label col-md-3">{{ lang('partners.profile_pic') }}</label>
                    <div class="col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload" id="users_profile-photo-container">
                            <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                <?php 
                                	$filename = urldecode(basename($record['users_profile.photo'])); 
                                	if(strtolower($filename) == 'avatar.png'){
                                		$record['users_profile.photo'] = '';
                                		$filename = '';
                                	}
                                ?>

                                <!-- <img class= "photo-display"
                                    id="img-preview" 
                                    src="{{ base_url($record['users_profile.photo']) }}" 
                                     style="width: 200px; height: 150px;" /> -->
                                <input type="hidden" name="users_profile[photo]" id="users_profile-photo" value="{{ $record['users_profile.photo'] }}">
                            <!-- </div> -->
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>                            
							<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">{{ $filename }}</span>
										</span>
									</span>
									<div id="photo-container">
                                <span class="btn default btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('partners.select_img') }}</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="files[]" class="default file" id="users_profile-photo-fileupload" />
                                </span>
								<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                            </div>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners.specialization') }}</span></label>
					<div class="col-md-5">
						<?php	$db->select('specialization_id,specialization');
                    			$db->where('deleted', '0');
                    			$options = $db->get('users_specialization');

                    			$users_profile_specialization_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$users_profile_specialization_options[$option->specialization_id] = $option->specialization;
                    			} ?>
						<div class="input-group">
							<span class="input-group-addon">
                            	<i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('users_profile[specialization_id]',$users_profile_specialization_options, $record['users_profile.specialization_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
					</div>
				</div>
            </div>
			<!-- </form> -->
			<div class="form-actions fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-offset-3 col-md-8">
							<button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
							<button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>