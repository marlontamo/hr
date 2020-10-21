<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.personal_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
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
                            <label class="control-label col-md-3">{{ lang('partners.phone') }} 
                                <span class="phone_count_display" id="phone_display_count-<?php echo $count_phone; ?>"><?php echo ($count_phone > 1) ? $count_phone : "" ?></span>
                            </label>
                            <div class="col-md-5">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control" maxlength="16" name="partners_personal[phone][]" id="partners_personal-phone" placeholder="Enter Telephone Number" value="{{ $telephone }}">
                                 </div>
                            </div>
                            <!-- <?php //if($phone_count == $count_phone) { ?> -->
                            <span class="hidden-xs hidden-sm add_delete_phone" >
                                <?php if($phone_count > 1) { ?>
                                    <a class="btn btn-default action_phone" id="delete_phone-<?php echo $count_phone; ?>" onclick="remove_form(this.id, 'phone')"  ><i class="fa fa-trash-o"></i></a>
                                <?php  }
                                    if($phone_count == $count_phone) { ?>
                                    <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')" ><i class="fa fa-plus"></i></a>
                            </span>
                             <?php } ?> 
                        </div>
                    <?php 
                            }
                        }
                    }else{
                    ?>
                    <input type="hidden" name="phone_count" id="phone_count" value="1" />
                    <input type="hidden" name="phone_counting" id="phone_counting" value="1" />
                    <div class="form-group hidden-sm hidden-xs" id="phone-count-1">
                        <label class="control-label col-md-3">{{ lang('partners.phone') }} 
                                <span class="phone_count_display" id="phone_display_count-1"></span>
                        </label>
                            <div class="col-md-5">
                               <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" maxlength="16" name="partners_personal[phone][]" id="partners_personal[phone]" placeholder="Enter Telephone Number" value="">
                            </div>
                        </div>
                        <span class="hidden-xs hidden-sm add_delete_phone">
                            <a class="btn btn-default action_phone add_phone" id="add_phone" onclick="add_form('contact_phone', 'phone')"><i class="fa fa-plus"></i></a>
                        </span>
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
                                    <input type="text" class="form-control" maxlength="16" name="partners_personal[mobile][]" id="partners_personal-mobile" placeholder="Enter Mobile Number" value="{{ $mobile }}">
                                 </div>
                            </div>
                          <!--   <?php //if($mobile_count == $count_mobile) { ?> -->
                            <span class="hidden-xs hidden-sm add_delete_mobile">
                                <?php if($mobile_count > 1) { ?>
                                <a class="btn btn-default action_mobile" id="delete_mobile-<?php echo $count_mobile; ?>" onclick="remove_form(this.id, 'mobile')" ><i class="fa fa-trash-o"></i></a>
                                <?php } if($mobile_count == $count_mobile) {  ?>
                                <a class="btn btn-default action_mobile add_mobile" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
                            </span>
                            <?php } ?>
                        </div>
                <?php 
                            }
                        }
                    }else{
                ?>
                <input type="hidden" name="mobile_count" id="mobile_count" value="1" />
                <input type="hidden" name="mobile_counting" id="mobile_counting" value="1" />
                <div class="form-group hidden-sm hidden-xs" id="mobile-count-1">
                    <label class="control-label col-md-3">{{ lang('partners.mobile') }} 
                                <span class="mobile_count_display" id="mobile_display_count-1"></span></label>
                        <div class="col-md-5">
                           <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                            <input type="text" class="form-control" maxlength="16" name="partners_personal[mobile][]" id="partners_personal-mobile" placeholder="Enter Mobile Number" value="">
                        </div>
                    </div>
                    <span class="hidden-xs hidden-sm add_delete_mobile">
                        <a class="btn btn-default action_mobile add_mobile`" id="add_mobile" onclick="add_form('contact_mobile', 'mobile')"><i class="fa fa-plus"></i></a>
                    </span>
                </div>
                <?php
                    }
                ?>
                </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.email') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="users[email]" id="users-email" value="{{ $record['users.email'] }}" placeholder="Enter Email Address"/>
                    </div>
                </div>
                @if(in_array('address_1', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.address') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                            </span>
                        <input type="text" class="form-control" name="partners_personal[address_1]" id="partners_personal-address_1" value="{{ $address_1 }}" placeholder="Enter Address"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('city_town', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.city') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[city_town]" id="partners_personal-city_town" value="{{ $profile_live_in }}" placeholder="Enter City/Town"/>
                         </div>
                    </div>
                </div>
                @endif
                @if(in_array('country', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.country') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="partners_personal[country]" id="partners_personal-country" value="{{ $profile_country }}" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('zip_code', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.zip') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[zip_code]" id="partners_personal-zip_code" value="{{ $zip_code }}" placeholder="Enter Zipcode"/>
                    </div>
                </div>
                @endif
            </div>
        </div>
	</div>
</div>