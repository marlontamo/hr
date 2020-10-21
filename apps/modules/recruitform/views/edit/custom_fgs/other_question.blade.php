<h5 class="kiosk-title bold">{{ lang('recruitform.other_questions') }}:</h5>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.machine_operated') }}
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[machine_operated]" id="recruitment-machine_operated">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.driver_license') }}
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;{{ lang('recruitform.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('recruitform.no') }}&nbsp;">
            <input type="checkbox" value="1" checked="checked" name="recruitment_personal[driver_license][temp]" id="recruitment_personal-driver_license-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[driver_license]" id="recruitment_personal-driver_license" value="1"/>
        </div> 
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.type_license') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[driver_type_license]" id="recruitment_personal-driver_type_license">
            <option value="">{{ lang('recruitform.select') }}</option>
                @if( sizeof( $type_license ) > 0 )
                    @foreach( $type_license as $key => $val )
                        <option value="{{ $val['type_license_id'] }}"> {{ $val['type_license'] }} </option>
                    @endforeach
                @endif
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.prc_license') }}
        <!-- <span class="required">*</span> -->
    </label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;{{ lang('recruitform.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('recruitform.no') }}&nbsp;">
            <input type="checkbox" value="1" checked="checked" name="recruitment_personal[prc_license][temp]" id="recruitment_personal-prc_license-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[prc_license]" id="recruitment_personal-prc_license" value="1"/>
        </div> 
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.type_license') }}
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[prc_type_license]" id="recruitment-prc_type_license">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.license_no') }}
    </label>
    <div class="col-md-9">
    	<div class="input-icon">
			<input type="text" class="form-control" maxlength="64" name="recruitment_personal[prc_license_no]" id="recruitment-prc_license_no">
		</div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.date_expiration') }}<span class="required">*</span></label>
    <div class="col-md-9">
        <div class="input-group input-medium date date-picker " data-date-format="MM dd, yyyy" >
            <div class="input-icon">
                <input type="text" class="form-control" name="recruitment_personal[prc_date_expiration]" id="recruitment_personal-prc_date_expiration" value="" placeholder="Enter Date of Expiration" >
            </div>
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.illness') }}
    </label>
    <div class="col-md-9">
        <div class="make-switch" data-on-label="&nbsp;{{ lang('recruitform.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('recruitform.no') }}&nbsp;">
            <input type="checkbox" value="1" checked="checked" name="recruitment_personal[illness_question][temp]" id="recruitment_personal-illness_question-temp" class="dontserializeme toggle"/>
            <input type="hidden" name="recruitment_personal[illness_question]" id="recruitment_personal-illness_question" value="1"/>
        </div> 
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.illness_yes') }}
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[illness_yes]" id="recruitment-illness_yes">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.trial_court') }}<span class="required">*</span></label>
    <div class="col-md-9 checkbox-list">
        <label class="checkbox-inline">
            <input type="checkbox" name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-yes"  
            value="Yes"/>
            Yes
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-no" 
            value="No"/> 
            No
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-acquitted" 
            value="Acquitted"/> 
            Acquitted
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="recruitment_personal[trial_court][]" id="recruitment_personal-trial_court-guilty" 
            value="Found Guilty"/> 
            Found Guilty
        </label>                
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.learn_job') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[how_hiring_heard]" id="recruitment_personal-how_hiring_heard">
            <option value="">{{ lang('recruitform.select') }}</option>
                @if( sizeof( $sourcing_tool ) > 0 )
                    @foreach( $sourcing_tool as $key => $val )
                        <option value="{{ $val['sourcing_tool_id'] }}"> {{ $val['sourcing_tool'] }} </option>
                    @endforeach
                @endif
        </select>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.start') }}
    </label>
    <div class="col-md-9">
        <div class="input-icon">
            <input type="text" class="form-control" maxlength="64" name="recruitment_personal[work_start]" id="recruitment-work_start">
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="control-label col-md-3 small">{{ lang('recruitform.referral') }}
        <span class="required">*</span>
    </label>
    <div class="col-md-9">
        <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[referred_employee]" id="recruitment_personal-referred_employee">
            <option value="">{{ lang('recruitform.select') }}</option>
                @if( sizeof( $employee ) > 0 )
                    @foreach( $employee as $key => $val )
                        <option value="{{ $val['user_id'] }}"> {{ $val['full_name'] }} </option>
                    @endforeach
                @endif
        </select>
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

