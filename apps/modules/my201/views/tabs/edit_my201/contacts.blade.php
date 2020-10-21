<!-- Contact Information -->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('my201.personal_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal" >
			<div class="form-body">
				@if(in_array('phone', $partners_keys))
	                <div id="personal_phone">
	                    <?php $phone_count = count($profile_telephones); 
	                        if($phone_count > 0){
	                        $count_phone = 0;
	                    ?>
	                    <input type="hidden" name="phone_count" id="phone_count" value="{{ $phone_count }}" />
	                    <input type="hidden" name="phone_counting" id="phone_counting" value="{{ $phone_count }}" />
	                    <?php
	                        foreach($profile_telephones as $telephone){
	                            if(!empty($telephone)){ 
	                            $count_phone++;
	                    ?>
	                        <div class="form-group hidden-sm hidden-xs" id="phone-count-<?php echo $count_phone; ?>">
	                            <label class="control-label col-md-3">{{ lang('my201.phone') }} 
	                                <span class="phone_count_display" id="phone_display_count-<?php echo $count_phone; ?>"><?php echo ($count_phone > 1) ? $count_phone : "" ?></span>
	                            </label>
	                            <div class="col-md-5">
	                                 <div class="input-group">
	                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
	                                    <input type="text" class="form-control" {{ $is_editable['phone'] == 1 ? '' : 'readonly="readonly"' }} maxlength="16" name="partners_personal[phone][]" id="partners_personal-phone" placeholder="Enter Telephone Number" value="{{ $telephone }}">
	                                 </div>
	                            </div>
	                           	@if($is_editable['phone'] == 1)
		                            <span class="hidden-xs hidden-sm add_delete_phone" >
		                                @if($phone_count > 1)
		                                    <a class="btn btn-default action_phone" id="delete_phone-<?php echo $count_phone; ?>" onclick="remove_form(this.id, 'phone')"  ><i class="fa fa-trash-o"></i></a>
		                                @endif
		                                @if($phone_count == $count_phone)
		                                    <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')" ><i class="fa fa-plus"></i></a>
		                            	@endif
		                            </span>
	                            @endif
	                             
	                        </div>
	                    <?php 
	                            }
	                        }
	                    }else{
	                    ?>
	                    <input type="hidden" name="phone_count" id="phone_count" value="1" />
	                    <input type="hidden" name="phone_counting" id="phone_counting" value="1" />
	                    <div class="form-group hidden-sm hidden-xs" id="phone-count-1">
	                        <label class="control-label col-md-3">{{ lang('my201.phone') }} 
	                                <span class="phone_count_display" id="phone_display_count-1"></span>
	                        </label>
	                            <div class="col-md-5">
	                               <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
	                                <input type="text" class="form-control" {{ $is_editable['phone'] == 1 ? '' : 'readonly="readonly"' }} maxlength="16" name="partners_personal[phone][]" id="partners_personal[phone]" placeholder="Enter Telephone Number" value="">
	                            </div>
	                        </div>
	                        @if($is_editable['phone'] == 1)
		                        <span class="hidden-xs hidden-sm add_delete_phone">
		                            <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')"><i class="fa fa-plus"></i></a>
		                        </span>
		                    @endif
	                    </div>
	                    <?php
	                    }
	                    ?>  
	                </div>
                @endif

                @if(in_array('mobile', $partners_keys))
	                <div id="personal_mobile">  
	                    <?php $mobile_count = count($profile_mobiles); 
	                        if($mobile_count > 0){
	                    ?>
	                    <input type="hidden" name="mobile_count" id="mobile_count" value="{{ $mobile_count }}" />
	                    <input type="hidden" name="mobile_counting" id="mobile_counting" value="{{ $mobile_count }}" />
	                    <?php 
	                            $count_mobile = 0;
	                            foreach($profile_mobiles as $mobile){ 
	                                if(!empty($mobile)){ 
	                                $count_mobile++;
	                    ?>
	                        <div class="form-group hidden-sm hidden-xs" id="mobile-count-<?php echo $count_mobile; ?>">
	                            <label class="control-label col-md-3">Mobile 
	                                <span class="mobile_count_display" id="mobile_display_count-<?php echo $count_mobile; ?>">
	                            <?php echo ($count_mobile > 1) ? $count_mobile : "" ?>
	                                </span>
	                            </label>
	                            <div class="col-md-5">
	                                 <div class="input-group">
	                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
	                                    <input type="text" class="form-control" {{ $is_editable['mobile'] == 1 ? '' : 'readonly="readonly"' }} maxlength="16" name="partners_personal[mobile][]" id="partners_personal-mobile" placeholder="Enter Mobile Number" value="{{ $mobile }}">
	                                 </div>
	                            </div>
	                        	@if($is_editable['mobile'] == 1)
		                            <span class="hidden-xs hidden-sm add_delete_mobile">
		                                @if($mobile_count > 1)
		                                <a class="btn btn-default action_mobile" id="delete_mobile-<?php echo $count_mobile; ?>" onclick="remove_form(this.id, 'mobile')" ><i class="fa fa-trash-o"></i></a>
		                                @endif
		                                @if($mobile_count == $count_mobile)
		                                <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
		                            	@endif
		                            </span>
	                            @endif
	                        </div>
		                <?php   	}
		                        }
		                    }else{
		                ?>
		                <input type="hidden" name="mobile_count" id="mobile_count" value="1" />
		                <input type="hidden" name="mobile_counting" id="mobile_counting" value="1" />
		                <div class="form-group hidden-sm hidden-xs" id="mobile-count-1">
		                    <label class="control-label col-md-3">{{ lang('my201.mobile') }} 
		                                <span class="mobile_count_display" id="mobile_display_count-1"></span></label>
		                        <div class="col-md-5">
		                           <div class="input-group">
		                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
		                            <input type="text" class="form-control" {{ $is_editable['mobile'] == 1 ? '' : 'readonly="readonly"' }} maxlength="16" name="partners_personal[mobile][]" id="partners_personal-mobile" placeholder="Enter Mobile Number" value="">
		                        </div>
		                    </div>
		                    @if($is_editable['mobile'] == 1)
		                    <span class="hidden-xs hidden-sm add_delete_mobile">
		                        <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
		                    </span>
		                    @endif
		                </div>
		                <?php
		                    }
		                ?>
		            </div>
                @endif

	            <div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.email') }}</label>
						<div class="col-md-5">
	                        <input type="text" class="form-control" {{ $is_editable['mobile'] == 1 ? '' : 'readonly="readonly"' }} id="users-email" value="{{ $profile_email }}"/>
	                    </div>
					</div>
				</div>
				@if(in_array('address_1', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.address') }}</label>
							<div class="col-md-5">
								<div class="input-group">
		                            <span class="input-group-addon">
		                               <i class="fa fa-map-marker"></i>
		                             </span>
			                        <textarea class="form-control" name="partners_personal[address_1]" {{ $is_editable['address_1'] == 1 ? '' : 'readonly="readonly"' }} id="users-address_1" >{{ $complete_address }}</textarea>
			                    </div>
		                    </div>
						</div>
					</div>
				@endif
				@if(in_array('city_town', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.city') }}</label>
							<div class="col-md-5">
				                <input type="text" class="form-control" name="partners_personal[city_town]"  {{ $is_editable['city_town'] == 1 ? '' : 'readonly="readonly"' }} id="partners_personal-city_town" value="{{ $profile_live_in }}"/>
				            </div>
						</div>
					</div>
				@endif

				@if(in_array('zip_code', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.zip') }}</label>
							<div class="col-md-5">
				                <input type="text" class="form-control" name="partners_personal[zip_code]" {{ $is_editable['zip_code'] == 1 ? '' : 'readonly="readonly"' }} id="partners_personal-zip_code" value="{{ $zip_code }}"/>
				            </div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

<!-- Emergency Contact -->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('my201.emergency_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal" >
			<div class="form-body">
			@if(in_array('emergency_name', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.name') }} :</label>
						<div class="col-md-5">
                            <input type="text" class="form-control" {{ $is_editable['emergency_name'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_name]" id="partners_personal-emergency_name" value="{{ $emergency_name }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.name') }}"/>
                        </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_relationship', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.relationship') }} :</label>
						<div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon">
                                   <i class="fa fa-group"></i>
                                 </span>
                           		<input type="text" class="form-control" {{ $is_editable['emergency_relationship'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_relationship]" id="partners_personal-emergency_relationship" value="{{ $emergency_relationship }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.relationship') }}"/>
                            </div>
                        </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_phone', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.phone') }} :</label>
						<div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            	<input type="text" class="form-control"  {{ $is_editable['emergency_phone'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_phone]" id="partners_personal-emergency_phone" value="{{ $emergency_phone }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.phone') }} {{ lang('my201.number') }}"/>
                            </div>
                        </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_mobile', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.mobile') }} :</label>
						<div class="col-md-5">
	                        <div class="input-group">
	                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
	                        <input type="text" class="form-control" {{ $is_editable['emergency_mobile'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_mobile]" id="partners_personal-emergency_mobile" value="{{ $emergency_mobile }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.mobile') }} {{ lang('my201.number') }}"/>
	                         </div>
	                    </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_address', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.address') }} :</label>
						<div class="col-md-5">
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                               <i class="fa fa-map-marker"></i>
	                             </span>
	                        	<textarea class="form-control"  {{ $is_editable['emergency_address'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_address]" id="partners_personal-emergency_address" placeholder="{{ lang('common.enter') }} {{ lang('my201.address') }}"/>{{ $emergency_address }}</textarea>
	                         </div>
	                    </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_city', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.city') }} :</label>
						<div class="col-md-5">
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                               <i class="fa fa-map-marker"></i>
	                             </span>
	                        <input type="text" class="form-control" {{ $is_editable['emergency_city'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_city]" id="partners_personal-emergency_city" value="{{ $emergency_city }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.city') }}"/>
	                         </div>
	                    </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_country', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.country') }} :</label>
						<div class="col-md-5">
	                        <div class="input-group">
	                            <span class="input-group-addon">
	                               <i class="fa fa-map-marker"></i>
	                             </span>
	                        <input type="text" class="form-control" {{ $is_editable['emergency_country'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_country]" id="partners_personal-emergency_country" value="{{ $emergency_country }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.country') }}"/>
	                        </div>
	                    </div>
					</div>
				</div>
			@endif
			@if(in_array('emergency_zip_code', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.zip') }} :</label>
						 <div class="col-md-5">
	                        <input type="text" class="form-control" {{ $is_editable['emergency_country'] == 1 ? '' : 'readonly="readonly"' }} name="partners_personal[emergency_zip_code]" id="partners_personal-emergency_zip_code" value="{{ $emergency_zip_code }}" placeholder="{{ lang('common.enter') }} {{ lang('my201.zip') }}"/>
	                    </div>
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