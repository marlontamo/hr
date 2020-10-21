<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners_immediate.gen_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- <form action="#" class="form-horizontal"> -->
		<form class="form-horizontal" id="form-1" partner_id="1" method="POST">
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners_immediate.title') }}<span class="required">*</span></label>
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
					<label class="control-label col-md-3">{{ lang('partners_immediate.last') }} {{ lang('partners_immediate.name') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="{{ lang('partners_immediate.enter') }} {{ lang('partners_immediate.last') }} {{ lang('partners_immediate.name') }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners_immediate.first') }} {{ lang('partners_immediate.name') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="{{ lang('partners_immediate.enter') }} {{ lang('partners_immediate.first') }} {{ lang('partners_immediate.name') }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners_immediate.middle') }} {{ lang('partners_immediate.name') }}/label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="{{ lang('partners_immediate.enter') }} {{ lang('partners_immediate.middle') }} {{ lang('partners_immediate.name') }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners_immediate.maiden') }} {{ lang('partners_immediate.name') }} <br><small class="text-muted">(if applicable)</small></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[maidenname]" id="users_profile-maidenname" value="{{ $record['users_profile.maidenname'] }}" placeholder="{{ lang('partners_immediate.enter') }} {{ lang('partners_immediate.maiden') }} {{ lang('partners_immediate.name') }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('partners_immediate.nick') }} {{ lang('partners_immediate.name') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="{{ lang('partners_immediate.enter') }} {{ lang('partners_immediate.nick') }} {{ lang('partners_immediate.name') }}"/>
					</div>
				</div>
				<div class="form-group">
                	<label class="control-label col-md-3">{{ lang('partners_immediate.profile_pic') }}</label>
                    <div class="col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload" id="users_profile-photo-container">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">

                                <?php $logo = isset($record['users_profile.photo']) && $record['users_profile.photo'] != "" ? $record['users_profile.photo'] : 'assets/img/avatar.png'; ?>

                                <img class= "photo-display"
                                    id="img-preview" 
                                    src="{{ base_url($record['users_profile.photo']) }}" 
                                     style="width: 200px; height: 150px;" />
                                <input type="hidden" name="users_profile[photo]" id="users_profile-photo" value="{{ $record['users_profile.photo'] }}">
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div id="photo-container">
                                <span class="btn default btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('partners_immediate.select_img') }}</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('partners_immediate.change') }}</span>
                                <input type="file" name="files[]" class="default file" id="users_profile-photo-fileupload" />
                                </span>
								<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                            </div>
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