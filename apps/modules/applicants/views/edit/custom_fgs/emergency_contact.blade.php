<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.emergency_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
            <div class="form-body">
            	<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.name') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[emergency_name]" id="recruitment_personal-emergency_name" value="{{ $record['emergency_name'] }}" placeholder="Enter Name"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.relationship') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-group"></i>
                             </span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_relationship]" id="recruitment_personal-emergency_relationship" value="{{ $record['emergency_relationship'] }}" placeholder="Enter Relationship"/>
                        </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('applicants.phone') }}</label>
                    <div class="col-md-5">
                         <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_phone]" id="recruitment_personal-emergency_phone" value="{{ $record['emergency_phone'] }}" placeholder="Enter Phone Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('applicants.mobile') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_mobile]" id="recruitment_personal-emergency_mobile" value="{{ $record['emergency_mobile'] }}" placeholder="Enter Mobile Number"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.address') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_address]" id="recruitment_personal-emergency_address" value="{{ $record['emergency_address'] }}" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.city') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_city]" id="recruitment_personal-emergency_city" value="{{ $record['emergency_city'] }}" placeholder="Enter City"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.country') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="recruitment_personal[emergency_country]" id="recruitment_personal-emergency_country" value="{{ $record['emergency_country'] }}" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.zip') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[emergency_zip_code]" id="recruitment_personal-emergency_zip_code" value="{{ $record['emergency_zip_code'] }}" placeholder="Enter Zipcode"/>
                    </div>
                </div>
                
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-3 col-md-8">
                            <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }} @if (empty($record['record_id'])) and {{ lang('common.next') }} @endif</button>
                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>
                            <a class="btn default btn-sm" href="{{ $mod->url }}" type="button" >{{ lang('common.back_to_list') }}</a>                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>