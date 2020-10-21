<div class="portlet">
    <div class="portlet-title">
        <div class="caption">{{ lang('applicants.other_questions') }}</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.machine_operated') }}
                    </label>
                    <div class="col-md-5">
                        <div class="input-icon">
                            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[machine_operated]" value="{{ $record['machine_operated'] }}" id="recruitment-machine_operated">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.driver_license') }}
                        <!-- <span class="required">*</span> -->
                    </label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['driver_license'] ) checked="checked" @endif name="recruitment_personal[driver_license][temp]" id="recruitment_personal-driver_license-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[driver_license]" id="recruitment_personal-driver_license" value="@if( $record['driver_license'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.type_license') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-5">
                        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[driver_type_license]" id="recruitment_personal-driver_type_license">
                            <option value="">{{ lang('applicants.select') }}</option>
                                <?php $selected = ''; ?>
                                @if( sizeof( $type_license ) > 0 )
                                    @foreach( $type_license as $key => $val )
                                        <?php
                                        if($record['driver_license'] == $val['type_license_id']) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>                                    
                                        <option <?php echo $selected ?> value="{{ $val['type_license_id'] }}"> {{ $val['type_license'] }} </option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.prc_license') }}
                        <!-- <span class="required">*</span> -->
                    </label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['prc_license'] ) checked="checked" @endif name="recruitment_personal[prc_license][temp]" id="recruitment_personal-prc_license-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[prc_license]" id="recruitment_personal-prc_license" value="@if( $record['prc_license'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.type_license') }}
                    </label>
                    <div class="col-md-5">
                        <div class="input-icon">
                            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[prc_type_license]" value="{{ $record['prc_type_license'] }}" id="recruitment-prc_type_license">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.license_no') }}
                    </label>
                    <div class="col-md-5">
                    	<div class="input-icon">
                			<input type="text" class="form-control" maxlength="64" name="recruitment_personal[prc_license_no]" value="{{ $record['prc_license_no'] }}" id="recruitment-prc_license_no">
                		</div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.date_expiration') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <div class="input-group input-medium date date-picker " data-date-format="MM dd, yyyy" >
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal[prc_date_expiration]" id="recruitment_personal-prc_date_expiration" value="{{ $record['prc_date_expiration'] }}" placeholder="Enter Date of Expiration" >
                            </div>
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.illness') }}
                    </label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['illness_question'] ) checked="checked" @endif name="recruitment_personal[illness_question][temp]" id="recruitment_personal-illness_question-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[illness_question]" id="recruitment_personal-illness_question" value="@if( $record['illness_question'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.illness_yes') }}
                    </label>
                    <div class="col-md-5">
                        <div class="input-icon">
                            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[illness_yes]" value="{{ $record['illness_yes'] }}" id="recruitment-illness_yes">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.trial_court') }}<span class="required">*</span></label>
                    <div class="col-md-5 checkbox-list">
                        <label class="checkbox-inline">
                            <input type="checkbox" @if( $record['trial_court'] == "Yes" ) checked="checked" @endif name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-yes"  
                            value="Yes"/>
                            Yes
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" @if( $record['trial_court'] == "No" ) checked="checked" @endif name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-no" 
                            value="No"/> 
                            No
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" @if( $record['trial_court'] == "Acquitted" ) checked="checked" @endif name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-acquitted" 
                            value="Acquitted"/> 
                            Acquitted
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" @if( $record['trial_court'] == "Found Guilty" ) checked="checked" @endif name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-guilty" 
                            value="Found Guilty"/> 
                            Found Guilty
                        </label>                
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.learn_job') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-5">
                        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[how_hiring_heard]" id="recruitment_personal-how_hiring_heard">
                            <option value="">{{ lang('applicants.select') }}</option>
                                <?php $selected = ''; ?>
                                @if( sizeof( $sourcing_tool ) > 0 )
                                    @foreach( $sourcing_tool as $key => $val )
                                        <?php
                                        if($record['how_hiring_heard'] == $val['sourcing_tool_id']) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>                                      
                                        <option <?php echo $selected ?> value="{{ $val['sourcing_tool_id'] }}"> {{ $val['sourcing_tool'] }} </option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.start') }}
                    </label>
                    <div class="col-md-5">
                        <div class="input-icon">
                            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[work_start]" value="{{ $record['work_start'] }}" id="recruitment-work_start">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.referral') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-5">
                        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[referred_employee]" id="recruitment_personal-referred_employee">
                            <option value="">{{ lang('applicants.select') }}</option>
                                <?php $selected = ''; ?>
                                @if( sizeof( $employee ) > 0 )
                                    @foreach( $employee as $key => $val )
                                        <?php
                                        if($record['referred_employee'] == $val['user_id']) {
                                            $selected = 'selected="selected"';
                                        }
                                        ?>                                      
                                        <option <?php echo $selected ?> value="{{ $val['user_id'] }}"> {{ $val['full_name'] }} </option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-4 col-md-8">
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
<script language="javascript">

    var customHandleUniform = function () {
        if (!jQuery().uniform) {
            return;
        }

        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
        if (test.size() > 0) {
            test.each(function () {
                if ($(this).parents(".checker").size() == 0) {
                    $(this).show();
                    $(this).uniform();
                }
            });
        }
    }

    jQuery(document).ready(function() { 

        customHandleUniform();
    });
</script>

