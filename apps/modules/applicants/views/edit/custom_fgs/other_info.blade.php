<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.other_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal">
            <div class="form-body">
            	<div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.height') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[height]" id="recruitment_personal-height" value="{{ $record['height'] }}" placeholder="Enter Height"/>
                    </div>
                </div>
                
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-4">{{ lang('applicants.weight') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[weight]" id="recruitment_personal-weight" value="{{ $record['weight'] }}" placeholder="Enter Weight"/>
                    </div>
                </div>
                <div class="form-group hidden-sm hidden-xs">
                    <label class="control-label col-md-4">{{ lang('applicants.hobby') }}</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-star"></i></span>
                        <input type="text" class="form-control" name="recruitment_personal[interests_hobbies]" id="recruitment_personal-interests_hobbies" value="{{ $record['interests_hobbies'] }}" placeholder="Enter Interest and Hobbies"/>
                         </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.languages') }}</label>
                    <div class="col-md-5">                                   
                        <input type="text" class="form-control" name="recruitment_personal[language]" id="recruitment_personal-language" value="{{ $record['language'] }}" placeholder="Enter Languange Known"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.dialects') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[dialect]" id="recruitment_personal-dialect" value="{{ $record['dialect'] }}" placeholder="Enter Dialects"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.no_dependents') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[dependents_count]" id="recruitment_personal-dependents_count" value="{{ $record['dependents_count'] }}" placeholder="Enter No. of Dependents"/>
                    </div>
                </div>
<!--                 <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.license_certified') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['cert_member_to_trade'] ) checked="checked" @endif name="recruitment_personal[cert_member_to_trade][temp]" id="recruitment_personal-cert_member_to_trade-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[cert_member_to_trade]" id="recruitment_personal-cert_member_to_trade" value="@if( $record['cert_member_to_trade'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.prev_employed') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['previously_employed_at_hdi'] ) checked="checked" @endif name="recruitment_personal[previously_employed_at_hdi][temp]" id="recruitment_personal-previously_employed_at_hdi-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[previously_employed_at_hdi]" id="recruitment_personal-previously_employed_at_hdi" value="@if( $record['previously_employed_at_hdi'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.list_known_person') }}</label>
                    <div class="col-md-5">
                        <textarea rows="3" class="form-control"name="recruitment_personal[known_people_at_hdi]" id="recruitment_personal-known_people_at_hdi" >{{$record['known_people_at_hdi']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.physical_disabilites') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['physical_disabilities'] ) checked="checked" @endif name="recruitment_personal[physical_disabilities][temp]" id="recruitment_personal-physical_disabilities-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[physical_disabilities]" id="recruitment_personal-physical_disabilities" value="@if( $record['physical_disabilities'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.work_limit') }}</label>
                    <div class="col-md-5">
                        <textarea rows="3" class="form-control"name="recruitment_personal[work_limitations]" id="recruitment_personal-work_limitations" >{{$record['work_limitations']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.major_illness') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                            <input type="checkbox" value="1" @if( $record['illness_injuries'] ) checked="checked" @endif name="recruitment_personal[illness_injuries][temp]" id="recruitment_personal-illness_injuries-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[illness_injuries]" id="recruitment_personal-illness_injuries" value="@if( $record['illness_injuries'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.ill_desc') }}</label>
                    <div class="col-md-5">
                        <textarea rows="3" class="form-control"name="recruitment_personal[illness_injuries_desc]" id="recruitment_personal-illness_injuries_desc" >{{$record['illness_injuries_desc']}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.ill_compensation') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['illness_compensated'] ) checked="checked" @endif name="recruitment_personal[illness_compensated][temp]" id="recruitment_personal-illness_compensated-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[illness_compensated]" id="recruitment_personal-illness_compensated" value="@if( $record['illness_compensated'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.relocate') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['willing_to_relocate'] ) checked="checked" @endif name="recruitment_personal[willing_to_relocate][temp]" id="recruitment_personal-willing_to_relocate-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[willing_to_relocate]" id="recruitment_personal-willing_to_relocate" value="@if( $record['willing_to_relocate'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">{{ lang('applicants.work_notice') }}</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="recruitment_personal[days_notice_to_work]" id="recruitment_personal-days_notice_to_work" value="{{ $record['days_notice_to_work'] }}" placeholder="Days Notice"/>
                    </div>
                </div> -->
                
            </div>
<!--             <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-4 col-md-8">
                            <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }} @if (empty($record['record_id'])) and {{ lang('common.next') }} @endif</button>
                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>
                            <a class="btn default btn-sm" href="{{ $mod->url }}" type="button" >{{ lang('common.back_to_list') }}</a>                               
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
	</div>
</div>