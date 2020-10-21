<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('recruitform.character_ref') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('character_references', 'reference')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<!-- Previous Character reference : start doing the loop-->
<div id="personal_reference">
    <input type="hidden" name="reference_count" id="reference_count" value="1" />
<div class="portlet">
    <div class="portlet-title">
        <!-- <div class="caption" id="education-category">Company Name</div> -->
        <div class="tools">
            <a class="text-muted" id="delete_reference-1" onclick="remove_form(this.id, 'reference', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
        <!-- START FORM --> 
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.name') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-name][]" id="recruitment_personal_history-reference-name" placeholder="Enter Name"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.occupation') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-occupation][]" id="recruitment_personal_history-reference-occupation" placeholder="Enter Occupation"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.org') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-organization][]" id="recruitment_personal_history-reference-organization" placeholder="Enter Organization"/>
                        </div>
                    </div>
                </div>                
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.years_known') }}<span class="required">*</span></label>
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
                    <label class="control-label col-md-3 small">{{ lang('recruitform.phone') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-phone"></i>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" name="recruitment_personal_history[reference-phone][]" id="recruitment_personal_history-reference-phone" placeholder="Enter Telephone Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.mobile') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-mobile"></i>
                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control" name="recruitment_personal_history[reference-mobile][]" id="recruitment_personal_history-reference-mobile" placeholder="Enter Mobile Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.address') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-address][]" id="recruitment_personal_history-reference-address" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.city') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                        <input type="text" class="form-control" name="recruitment_personal_history[reference-city][]" id="recruitment_personal_history-reference-city" placeholder="Enter City"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.country') }}</label>
                    <div class="col-md-9">
                        <div class="input-icon">
                            <i class="fa fa-map-marker"></i>
                            <input type="text" class="form-control" name="recruitment_personal_history[reference-country][]" id="recruitment_personal_history-reference-country" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 small">{{ lang('recruitform.zip') }}</label>
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
</div>
