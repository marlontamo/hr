<h5 class="kiosk-title bold">Application Information:</h5>
<div class="form-group">
    <label class="control-label col-md-3 small">Date of Application
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                <input type="text" class="form-control" name="recruitment[recruitment_date]" id="recruitment-recruitment_date" value="" placeholder="Enter Application Date" >
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Apply For
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
        	<option value="">Please Select</option>
           
                @if( sizeof( $mrf ) > 0 )
                    @foreach( $mrf as $year => $mrfs )
                        @foreach( $mrfs as $mrf )
                            <option value="{{ $mrf->position }}"> {{ $mrf->position }} </option>
                        @endforeach
                    @endforeach
                @endif
        </select>
    
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Desired Salary 
    	<!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment_personal[desired_salary]" id="recruitment_personal-desired_salary">
		</div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[salary_pay_mode]" id="recruitment_personal-salary_pay_mode">
        	<option value="Monthly">Monthly</option>
            <option value="Hourly">Hourly</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Currently Employed 
    	<!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
            <input type="checkbox" value="1" checked="checked" name="recruitment_personal[currently_employed][temp]" id="recruitment_personal-currently_employed-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[currently_employed]" id="recruitment_personal-currently_employed" value="1"/>
        </div> 
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">How did you learn about HDI? 
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        
        <select  class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[how_hiring_heard]" id="recruitment_personal-how_hiring_heard">
        	<option value="">Please Select</option>
            <option value="Ads">Ads</option>
            <option value="Jobstreet">Linkedin</option>
            <option value="Jobstreet">Jobstreet</option>
            <option value="Referral">Referral</option>
        </select>
    
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Upload Resume
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
        <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-resume-container">
            <input type="hidden" name="recruitment_personal[resume]" id="recruitment_personal-resume" >
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 50px; max-height: 150px; line-height: 20px;"></div>                            
                <div class="input-group">
                        <span class="input-group-btn">
                            <span class="uneditable-input" style="max-width:25px important!">
                                <i class="fa fa-file fileupload-exists"></i> 
                                <span class="fileupload-preview" style="max-width:25px important!"></span>
                            </span>
                        </span>
                        <div id="resume-container">
                    <span class="btn default btn-file">
                    <span class="fileupload-new "><i class="fa fa-paper-clip"></i> Select File</span>
                    <span class="fileupload-exists "><i class="fa fa-undo"></i> Change</span>
                    <input type="file" name="files[]" class="default file" id="recruitment_personal-resume-fileupload" style="max-width:206px !important"/>
                    <a data-dismiss="fileupload" class="small btn red fileupload-exists fileupload-delete "><i class="fa fa-trash-o"></i> Remove</a>
                    </span>
                    
                </div>
            </div>
        </div>
    </div>
</div>