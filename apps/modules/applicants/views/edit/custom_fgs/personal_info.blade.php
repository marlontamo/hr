     
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.personal') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.gender') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <?php
                            $recruitment_gender_options = array('Male' => lang('common.male'), 'Female' => lang('common.female'));
                        ?>
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                        {{ form_dropdown('recruitment_personal[gender]',$recruitment_gender_options, $record['gender'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.bday') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="recruitment[birth_date]" id="recruitment-birth_date" value="{{ $record['birth_date'] }}" placeholder="Enter Birthday" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.birthplace') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[birth_place]" id="recruitment_personal-birth_place" value="{{ $record['birth_place'] }}" placeholder="Enter Birth Place"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.religion') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[religion]" id="recruitment_personal-religion" value="{{ $record['religion'] }}" placeholder="Enter Religion"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.nationality') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[nationality]" id="recruitment_personal-nationality" value="{{ $record['nationality'] }}" placeholder="Enter Nationality"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.civil_status') }}</label>
                    <div class="col-md-5">
                        <?php
                            $recruitment_civil_status_options = array('Single' => 'Single', 'Married' => 'Married');
                        ?>
                        {{ form_dropdown('recruitment_personal[civil_status]',$recruitment_civil_status_options, $profile_civil_status, 'class="form-control select2me" data-placeholder="Select..."') }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.solo_parent') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                            <input type="checkbox" value="1" @if( $record['personal_solo_parent'] ) checked="checked" @endif name="recruitment_personal[solo_parent][temp]" id="recruitment_personal-solo_parent-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[solo_parent]" id="recruitment_personal-solo_parent" value="@if( $record['personal_solo_parent'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.tin') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[tin_number]" id="recruitment_personal-tin_number" value="{{ $record['tin_number'] }}" placeholder="Enter TIN"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.sss_no') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[sss_number]" id="recruitment_personal-sss_number" value="{{ $record['sss_number'] }}" placeholder="Enter SSS Number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.pagibig_no') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[pagibig_number]" id="recruitment_personal-pagibig_number" value="{{ $record['pagibig_number'] }}" placeholder="Enter Pagibig Number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.philhealth_no') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[philhealth_number]" id="recruitment_personal-philhealth_number" value="{{ $record['philhealth_number'] }}" placeholder="Enter Philhealth Number"/>
                    </div>
                </div>                                
            </div>                            
        </div>
	</div>
</div>