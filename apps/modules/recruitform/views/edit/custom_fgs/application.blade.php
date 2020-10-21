<h5 class="kiosk-title bold">{{ lang('recruitform.app_info') }}:</h5>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.dt_application') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <!-- <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy"> -->
                <input type="text" readonly class="form-control" name="recruitment[recruitment_date]" id="recruitment-recruitment_date" value="{{date('F d, Y')}}" placeholder="Enter Application Date" >
            <!-- <span class="input-group-btn"> -->
            <!-- <button class="btn default" type="button"><i class="fa fa-calendar"></i></button> -->
            <!-- </span> -->
        <!-- </div>         -->
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.apply_for') }}
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
        	<option value="">{{ lang('recruitform.select') }}</option>
                @if( sizeof( $mrf ) > 0 )
                    @foreach( $mrf as $year => $mrfs )
                        @foreach( $mrfs as $mrf )
                            <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} ({{ $mrf->document_no}}) </option>
                        @endforeach
                    @endforeach
                @endif
        </select>
        <input type="hidden" class="form-control" name="recruitment[request_id]" id="recruitment-request_id" value="" placeholder="Enter Position Sought"/>
    
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.oth_pos') }}
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment[oth_position]" id="recruitment-firstname">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.desired_salary') }} 
    	<!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="input-group">
			<input type="text" class="form-control mask_number" style="width: 200px" name="recruitment_personal[desired_salary]" id="recruitment_personal-desired_salary">
            &nbsp; - &nbsp;
            <input type="text" class="form-control mask_number" style="width: 200px" maxlength="64" name="recruitment_personal[desired_salary_to]" id="recruitment_personal-desired_salary_to">
		</div>
    </div>
   {{--  <div class="col-xs-1"> - </div>
    <div class=" col-md-4">
        <div class="input-icon ">
            <input type="text" class="form-control " maxlength="64" name="recruitment_personal[desired_salary]" id="recruitment_personal-desired_salary">
        </div>
    </div> --}}
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[salary_pay_mode]" id="recruitment_personal-salary_pay_mode">
        	<option value="Monthly">{{ lang('recruitform.monthly') }}</option>
            <option value="Hourly">{{ lang('recruitform.hourly') }}</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.currently_employed') }}
    	<!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;{{ lang('recruitform.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('recruitform.no') }}&nbsp;">
            <input type="checkbox" value="1" checked="checked" name="recruitment_personal[currently_employed][temp]" id="recruitment_personal-currently_employed-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[currently_employed]" id="recruitment_personal-currently_employed" value="1"/>
        </div> 
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.upload_resume') }}
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
                    <span class="fileupload-new "><i class="fa fa-paper-clip"></i> {{ lang('recruitform.select_file') }}</span>
                    <span class="fileupload-exists "><i class="fa fa-undo"></i> Change</span>
                    <input type="file" name="files[]" class="default file" id="recruitment_personal-resume-fileupload" style="max-width:206px important!"/>
                    </span>
                    <a data-dismiss="fileupload" class="small btn red fileupload-exists fileupload-delete "><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>