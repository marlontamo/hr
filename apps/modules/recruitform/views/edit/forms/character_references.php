<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
			<a class="text-muted" id="delete_reference-<?php echo $count;?>" onclick="remove_form(this.id, 'reference', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
			<!-- <a class="collapse pull-right" href="javascript:;"></a> -->
		</div>
	</div>
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->	
                <div class="form-group">
                    <label class="control-label col-md-3 small">Name<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-name][]" id="recruitment_personal_history-reference-name" placeholder="Enter Name"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">Occupation</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-occupation][]" id="recruitment_personal_history-reference-occupation" placeholder="Enter Occupation"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">Organization</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-organization][]" id="recruitment_personal_history-reference-organization" placeholder="Enter Organization"/>
                        </div>
                    </div>
                </div>                   
                <div class="form-group">
                    <label class="control-label col-md-3 small">Years Known<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="number_spinner">
                            <div class="input-group input-small">
                                <input type="text" maxlength="3" class="spinner-input form-control" onkeypress="return isNumber(event)" 
                                 name="recruitment_personal_history[reference-years-known][]" id="recruitment_personal_history-reference-years-known" placeholder="Enter Years Known" >
                                <div class="spinner-buttons input-group-btn btn-group-vertical">
                                    <button class="btn spinner-up btn-xs blue" type="button">
                                    <i class="fa fa-angle-up"></i>
                                    </button>
                                    <button class="btn spinner-down btn-xs blue" type="button">
                                    <i class="fa fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-years-known][]" id="recruitment_personal_history-reference-years-known" placeholder="Enter Years Known"/>
                        </div> -->
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3 small">Phone</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-phone"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-phone][]" id="recruitment_personal_history-reference-phone" placeholder="Enter Telephone Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3 small">Mobile</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-mobile"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-mobile][]" id="recruitment_personal_history-reference-mobile" placeholder="Enter Mobile Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">Address</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-address][]" id="recruitment_personal_history-reference-address" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">City</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-city][]" id="recruitment_personal_history-reference-city" placeholder="Enter City"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">Country</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-country][]" id="recruitment_personal_history-reference-country" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">Zipcode</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-zipcode][]" id="recruitment_personal_history-reference-zipcode" placeholder="Enter Zipcode"/>
                        </div>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>