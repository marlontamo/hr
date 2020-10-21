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
                    <label class="control-label col-md-3">Name<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-name][]" id="partners_personal_history-reference-name" placeholder="Enter Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Occupation</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-occupation][]" id="partners_personal_history-reference-occupation" placeholder="Enter Occupation"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Years Known<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-years-known][]" id="partners_personal_history-reference-years-known" placeholder="Enter Years Known"/>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">Phone</label>
                    <div class="col-md-6">
                         <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-phone][]" id="partners_personal_history-reference-phone" placeholder="Enter Telephone Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">Mobile</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-mobile][]" id="partners_personal_history-reference-mobile" placeholder="Enter Mobile Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Address</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-address][]" id="partners_personal_history-reference-address" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">City</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-city][]" id="partners_personal_history-reference-city" placeholder="Enter City"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Country</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal_history[reference-country][]" id="partners_personal_history-reference-country" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Zipcode</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[reference-zipcode][]" id="partners_personal_history-reference-zipcode" placeholder="Enter Zipcode"/>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>