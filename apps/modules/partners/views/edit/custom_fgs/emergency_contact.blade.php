<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.emergency_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
            <div class="form-body">
                @if(in_array('emergency_name', $partners_keys))
                	<div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="partners_personal[emergency_name]" id="partners_personal-emergency_name" value="{{ $emergency_name }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.name') }}"/>
                        </div>
                    </div>
                @endif
                @if(in_array('emergency_relationship', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('partners.relationship') }}</label>
                        <div class="col-md-5">
                           <div class="input-group">
                                <span class="input-group-addon">
                                   <i class="fa fa-group"></i>
                                 </span>
                            <input type="text" class="form-control" name="partners_personal[emergency_relationship]" id="partners_personal-emergency_relationship" value="{{ $emergency_relationship }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.relationship') }}"/>
                            </div>
                        </div>
                    </div>
                @endif
                @if(in_array('emergency_phone', $partners_keys))
                    <div class="form-group hidden-sm hidden-xs">
                        <label class="control-label col-md-3">{{ lang('partners.phone') }}</label>
                        <div class="col-md-5">
                             <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" name="partners_personal[emergency_phone]" id="partners_personal-emergency_phone" value="{{ $emergency_phone }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.phone') }} {{ lang('partners.number') }}"/>
                             </div>
                        </div>
                    </div>
                @endif
                @if(in_array('emergency_mobile', $partners_keys))
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-3">{{ lang('partners.mobile') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                        <input type="text" class="form-control" name="partners_personal[emergency_mobile]" id="partners_personal-emergency_mobile" value="{{ $emergency_mobile }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.mobile') }} {{ lang('partners.number') }}"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('emergency_address', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.address') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_address]" id="partners_personal-emergency_address" value="{{ $emergency_address }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.address') }}"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('emergency_city', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.city') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_city]" id="partners_personal-emergency_city" value="{{ $emergency_city }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.city') }}"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('emergency_country', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.country') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[emergency_country]" id="partners_personal-emergency_country" value="{{ $emergency_country }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.country') }}"/>
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('emergency_zip_code', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.zip') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[emergency_zip_code]" id="partners_personal-emergency_zip_code" value="{{ $emergency_zip_code }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.zip') }}"/>
                    </div>
                </div>
                @endif
                
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