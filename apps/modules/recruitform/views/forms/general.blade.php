<h5 class="kiosk-title bold">General Information:</h5>
<div class="form-group">
    <label class="control-label col-md-3 small">Last Name
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment[lastname]" id="recruitment-lastname">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">First Name
    	<span class="required">*</span>
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment[firstname]" id="recruitment-firstname">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Middle Name
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment[middlename]" id="recruitment-middlename">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Maiden Name
        <br><small class="text-muted">(if applicable)</small>
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment[maidenname]" id="recruitment-maidenname">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Nick Name
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment[nickname]" id="recruitment-nickname">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">Profile Picture
    </label>
    <div class="col-md-9">
        <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-photo-container">
            <input type="hidden" name="recruitment_personal[photo]" id="recruitment_personal-photo" >
            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 50px; max-height: 150px; line-height: 20px;"></div>                            
                <div class="input-group">
                        <span class="input-group-btn">
                            <span class="uneditable-input" style="max-width:50px important!">
                                <i class="fa fa-file fileupload-exists"></i> 
                                <span class="fileupload-preview" style="max-width:50px important!"></span>
                            </span>
                        </span>
                        <div id="photo-container">
                    <span class="btn default btn-file">
                    <span class="fileupload-new "><i class="fa fa-paper-clip"></i> Select File</span>
                    <span class="fileupload-exists "><i class="fa fa-undo"></i> Change</span>
                    <input type="file" name="files[]" class="default file" id="recruitment_personal-photo-fileupload" style="max-width:206px important!"/>
                    </span>
                    <a data-dismiss="fileupload" class="small btn red fileupload-exists fileupload-delete "><i class="fa fa-trash-o"></i> Remove</a>
                </div>
            </div>
        </div>
    </div>
</div>