<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.gen_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- <form action="#" class="form-horizontal"> -->
		<!-- <form class="form-horizontal" id="form-1" partner_id="1" method="POST"> -->
			<div class="form-body">
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('applicants.last') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="recruitment[lastname]" id="recruitment-lastname" value="{{ $record['lastname'] }}" placeholder="Enter Last Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('applicants.first') }}<span class="required">*</span></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="recruitment[firstname]" id="recruitment-firstname" value="{{ $record['firstname'] }}" placeholder="Enter First Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('applicants.middle') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="recruitment[middlename]" id="recruitment-middlename" value="{{ $record['middlename'] }}" placeholder="Enter Middle Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('applicants.maiden') }} <br><small class="text-muted">(if applicable)</small></label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="recruitment[maidenname]" id="recruitment-maidenname" value="{{ $record['maidenname'] }}" placeholder="Enter Maiden Name"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('applicants.nick') }}</label>
					<div class="col-md-5">
						<input type="text" class="form-control" name="recruitment[nickname]" id="recruitment-nickname" value="{{ $record['nickname'] }}" placeholder="Enter Nick Name"/>
					</div>
				</div>
				<div class="form-group">
                	<label class="control-label col-md-3">{{ lang('applicants.profile_pic') }}</label>
                    <div class="col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-photo-container">
                            <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                <?php 
                                	$filename = urldecode(basename($record['photo'])); 
                                	if(strtolower($filename) == 'avatar.png'){
                                		$record['photo'] = '';
                                		$filename = '';
                                	}
                                ?>

                                <!-- <img class= "photo-display"
                                    id="img-preview" 
                                    src="{{ base_url($record['photo']) }}" 
                                     style="width: 200px; height: 150px;" /> -->
                                <input type="hidden" name="recruitment_personal[photo]" id="recruitment_personal-photo" value="{{ $record['photo'] }}">
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
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('applicants.select_img') }}</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="files[]" class="default file" id="recruitment_personal-photo-fileupload" />
                                </span>
								<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                            </div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
			
	</div>
</div>