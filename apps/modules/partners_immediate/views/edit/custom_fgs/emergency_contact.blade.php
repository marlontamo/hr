<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners_immediate.emergency_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
            <div class="form-body">
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.name') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[emergency_name]" id="partners_personal-emergency_name" value="{{ $emergency_name }}" placeholder="Enter Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.relationship') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-group"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_relationship]" id="partners_personal-emergency_relationship" value="{{ $emergency_relationship }}" placeholder="Enter Relationship"/>
                        </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.phone') }}</label>
                    <div class="col-md-5">
                         <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="partners_personal[emergency_phone]" id="partners_personal-emergency_phone" value="{{ $emergency_phone }}" placeholder="Enter Phone Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.mobile') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        <input type="text" class="form-control" name="partners_personal[emergency_mobile]" id="partners_personal-emergency_mobile" value="{{ $emergency_mobile }}" placeholder="Enter Mobile Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.address') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_address]" id="partners_personal-emergency_address" value="{{ $emergency_address }}" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.city') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_city]" id="partners_personal-emergency_city" value="{{ $emergency_city }}" placeholder="Enter City"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.country') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_country]" id="partners_personal-emergency_country" value="{{ $emergency_country }}" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.zip') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[emergency_zip_code]" id="partners_personal-emergency_zip_code" value="{{ $emergency_zip_code }}" placeholder="Enter Zipcode"/>
                    </div>
                </div>
                
            </div>
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
        </div>
	</div>
</div>