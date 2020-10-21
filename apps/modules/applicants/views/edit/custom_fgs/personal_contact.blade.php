<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.personal_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
        <!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
                <div id="personal_phone">
                <?php $phone_count = count($profile_telephones); 
                    if($phone_count > 0){
                    $count_phone = 0;
                ?>
                <input type="hidden" name="phone_count" id="phone_count" value="{{ $phone_count }}" />
                <input type="hidden" name="phone_counting" id="phone_counting" value="{{ $phone_count }}" />
                <?php
                        foreach($profile_telephones as $telephone){ 
                            $count_phone++;
                    ?>
                        <div class="form-group hidden-sm hidden-xs" id="phone-count-<?php echo $count_phone; ?>">
                            <label class="control-label col-md-3">{{ lang('applicants.phone') }} 
                                <span class="phone_count_display" id="phone_display_count-<?php echo $count_phone; ?>"><?php echo ($count_phone > 1) ? $count_phone : "" ?></span>
                            </label>
                            <div class="col-md-5">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control" maxlength="16" name="recruitment_personal[phone][]" id="recruitment_personal-phone" placeholder="Enter Telephone Number" value="{{ $telephone }}">
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
                    }else{
                    ?>
                    <input type="hidden" name="phone_count" id="phone_count" value="1" />
                    <input type="hidden" name="phone_counting" id="phone_counting" value="1" />
                    <div class="form-group hidden-sm hidden-xs" id="phone-count-1">
                        <label class="control-label col-md-3">{{ lang('applicants.phone') }} 
                                <span class="phone_count_display" id="phone_display_count-1"></span>
                        </label>
                            <div class="col-md-5">
                               <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" maxlength="16" name="recruitment_personal[phone][]" id="recruitment_personal[phone]" placeholder="Enter Telephone Number" value="">
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
                <div id="personal_mobile">  
                <?php $mobile_count = count($profile_mobiles); 
                    if($mobile_count > 0){
                ?>
                <input type="hidden" name="mobile_count" id="mobile_count" value="{{ $mobile_count }}" />
                <input type="hidden" name="mobile_counting" id="mobile_counting" value="{{ $mobile_count }}" />
                <?php 
                        $count_mobile = 0;
                        foreach($profile_mobiles as $mobile){ 
                            $count_mobile++;
                ?>
                        <div class="form-group hidden-sm hidden-xs" id="mobile-count-<?php echo $count_mobile; ?>">
                            <label class="control-label col-md-3">{{ lang('applicants.mobile') }} 
                                <span class="mobile_count_display" id="mobile_display_count-<?php echo $count_mobile; ?>">
                            <?php echo ($count_mobile > 1) ? $count_mobile : "" ?>
                                </span>
                            </label>
                            <div class="col-md-5">
                                 <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                    <input type="text" class="form-control" maxlength="16" name="recruitment_personal[mobile][]" id="recruitment_personal-mobile" placeholder="Enter Mobile Number" value="{{ $mobile }}">
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
                    }else{
                ?>
                <input type="hidden" name="mobile_count" id="mobile_count" value="1" />
                <input type="hidden" name="mobile_counting" id="mobile_counting" value="1" />
                <div class="form-group hidden-sm hidden-xs" id="mobile-count-1">
                    <label class="control-label col-md-3">{{ lang('applicants.mobile') }} 
                                <span class="mobile_count_display" id="mobile_display_count-1"></span></label>
                        <div class="col-md-5">
                           <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                            <input type="text" class="form-control" maxlength="16" name="recruitment_personal[mobile][]" id="recruitment_personal-mobile" placeholder="Enter Mobile Number" value="">
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
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.email') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment[email]" id="recruitment-email" value="{{ $record['email'] }}" placeholder="Enter Email Address"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.address') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                            </span>
                        <input type="text" class="form-control" name="recruitment_personal[address_1]" id="recruitment_personal-address_1" value="{{ $record['address_1'] }}" placeholder="Enter Street"/>
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
                        <input type="text" class="form-control" name="recruitment_personal[city_town]" id="recruitment_personal-city_town" value="{{ $profile_live_in }}" placeholder="Enter City/Town"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.province') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                        <input type="text" class="form-control" name="recruitment_personal[province]" id="recruitment_personal-province" value="{{ $record['province'] }}" placeholder="Enter Province"/>
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
                        <input type="text" class="form-control" name="recruitment_personal[country]" id="recruitment_personal-country" value="{{ $profile_country }}" placeholder="Enter Country"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.zip') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[zip_code]" id="recruitment_personal-zip_code" value="{{ $record['zip_code'] }}" placeholder="Enter Zipcode"/>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>