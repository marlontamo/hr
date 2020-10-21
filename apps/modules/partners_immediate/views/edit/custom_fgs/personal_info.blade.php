
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners_immediate.personal') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.gender') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <?php
                            $users_profile_gender_options = array('Male' => lang('common.male'), 'Female' => lang('common.female'));
                        ?>
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                        {{ form_dropdown('partners_personal[gender]',$users_profile_gender_options, $gender, 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.bday') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="users_profile[birth_date]" id="users_profile-birth_date" value="{{ $record['users_profile.birth_date'] }}" placeholder="Enter Birthday" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.birthplace') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[birth_place]" id="partners_personal-birth_place" value="{{ $birth_place }}" placeholder="Enter Birth Place"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.religion') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[religion]" id="partners_personal-religion" value="{{ $religion }}" placeholder="Enter Religion"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.nationality') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="partners_personal[nationality]" id="partners_personal-nationality" value="{{ $nationality }}" placeholder="Enter Nationality"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.civil_status') }}</label>
                    <div class="col-md-5">
                        <?php
                            $users_profile_civil_status_options = array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced');
                        ?>
                        {{ form_dropdown('partners_personal[civil_status]',$users_profile_civil_status_options, $profile_civil_status, 'class="form-control select2me" data-placeholder="Select..."') }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.solo_parent') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                            <input type="checkbox" value="1" @if( $personal_solo_parent ) checked="checked" @endif name="partners_personal[solo_parent][temp]" id="partners_personal-solo_parent-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="partners_personal[solo_parent]" id="partners_personal-solo_parent" value="@if( $personal_solo_parent ) 1 else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                
            </div>                            
        </div>
	</div>
</div>