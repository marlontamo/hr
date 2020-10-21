<div class="general_div">
<h5 class="kiosk-title bold">{{ lang('appform.gen_info') }}:</h5>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('appform.last') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment[lastname]" id="recruitment-lastname">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('appform.first') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment[firstname]" id="recruitment-firstname">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('appform.middle') }}
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment[middlename]" id="recruitment-middlename">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('appform.apply_for') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
        	<option value="">{{ lang('appform.select') }}</option>

                @if( sizeof( $mrf ) > 0 )
                    @foreach( $mrf as $year => $mrfs )
                        @foreach( $mrfs as $mrf )
                            <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} </option>
                        @endforeach
                    @endforeach
                @endif
        </select>
        <input type="hidden" class="form-control" name="recruitment[request_id]" id="recruitment-request_id" value="" placeholder="Enter Position Sought"/>
    </div>
</div>

<div class="form-group hidden">
    <label class="control-label col-md-3 small">{{ lang('appform.desired_sal') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment_personal[desired_salary]" id="recruitment_personal-desired_salary">
		</div>
    </div>
</div>
<div class="form-group hidden">
    <label class="control-label col-md-3 small">
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[salary_pay_mode]" id="recruitment_personal-salary_pay_mode">
        	<option value="Monthly">{{ lang('appform.monthly') }}</option>
            <option value="Hourly">{{ lang('appform.hourly') }}</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('appform.upload_resume') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-resume-container">
            <input type="hidden" name="recruitment_personal[resume]" id="recruitment_personal-resume" >
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 50px; max-height: 150px; line-height: 20px;"></div>                            
                <div class="input-group">
                        <span class="input-group-btn">
                            <span class="uneditable-input" style="max-width:50px important!">
                                <i class="fa fa-file fileupload-exists"></i> 
                                <span class="fileupload-preview" style="max-width:50px important!"></span>
                            </span>
                        </span>
                    <div id="resume-container">
                        <span class="btn default btn-file">
                        <span class="fileupload-new "><i class="fa fa-paper-clip"></i> {{ lang('appform.select') }}</span>
                        <span class="fileupload-exists "><i class="fa fa-undo"></i> {{ lang('appform.change') }}</span>
                        <input type="file" name="files[]" class="default file" id="recruitment_personal-resume-fileupload"/>
                        </span>
                        <a data-dismiss="fileupload" class="small btn red fileupload-exists fileupload-delete "><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>