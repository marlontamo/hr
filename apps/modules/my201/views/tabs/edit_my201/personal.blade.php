<!-- Personal Information -->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('my201.personal') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
            <div class="form-body">
            	@if(in_array('gender', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.gender') }}</label>
							<div class="col-md-5">
		                        <?php
		                            $users_profile_gender_options = array('Male' => lang('common.male'), 'Female' => lang('common.female'));
		                            $disabled = ($is_editable['gender'] == 1) ? '' : 'disabled';
		                        ?>
		                       <div class="input-group">
		                            <span class="input-group-addon">
		                               <i class="fa fa-user"></i>
		                             </span>
		                        	{{ form_dropdown('partners_personal[gender]',$users_profile_gender_options, $gender, 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
		                        </div>
		                    </div>
						</div>
					</div>
				@endif
				@if(in_array('bday', $partners_keys))
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 ">{{ lang('my201.bday') }}</label>
						<div class="col-md-5">
	                    	<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
	                            <input type="text" class="form-control" {{ ($is_editable['bday'] == 1) ? '' : 'readonly="readonly"' }} name="users_profile[birth_date]" id="users_profile-birth_date" value="{{ $profile_birthdate }}" placeholder="Enter Birthday" >
	                            <span class="input-group-btn">
	                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
	                            </span>
	                        </div>
                        </div>
					</div>
				</div>
				@endif
				@if(in_array('birth_place', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.birthplace') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['birth_place'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[birth_place]" id="partners_personal-birth_place" value="{{ $birth_place }}" placeholder="Enter Birth Place"/>
		                    </div>
						</div>
					</div>
				@endif

				@if(in_array('religion', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.religion') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['religion'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[religion]" id="partners_personal-religion" value="{{ $religion }}" placeholder="Enter Birth Place"/>
		                    </div>
						</div>
					</div>
				@endif

				@if(in_array('nationality', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.nationality') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['nationality'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[nationality]" id="partners_personal-nationality" value="{{ $nationality }}" placeholder="Enter Nationality"/>
		                    </div>
						</div>
					</div>
				@endif
				@if(in_array('civil_status', $partners_keys))
					<div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3">{{ lang('my201.civil_status') }}</label>
		                    <div class="col-md-5">
		                        <?php
		                            $users_profile_civil_status_options = array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced');
		                            $disabled = ($is_editable['civil_status'] == 1) ? '' : 'disabled';
		                        ?>
		                        {{ form_dropdown('partners_personal[civil_status]',$users_profile_civil_status_options, $profile_civil_status, 'class="form-control select2me" '.$disabled.'  data-placeholder="Select..."') }}
		                    </div>
		                </div>
	                </div>
                @endif
                @if(in_array('solo_parent', $partners_keys))
                	<div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3">{{ lang('my201.solo_parent') }}</label>
		                    <div class="col-md-5">
		                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
		                            <input type="checkbox"  {{ ($is_editable['solo_parent'] == 1) ? '' : 'disabled' }}  {{ ( $personal_solo_parent ) ? 'checked="checked"' : '' }} name="partners_personal[solo_parent][temp]" id="partners_personal-solo_parent-temp" class="dontserializeme toggle"/>
		                            <input type="hidden" name="partners_personal[solo_parent]" id="partners_personal-solo_parent" value="{{ ( $personal_solo_parent ) ? 1 : 0 }}" />
		                        </div> 
		                    </div>
		                </div>
	                </div>
                @endif
                @if(in_array('with_parking', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ $partners_labels['with_parking'] }}</label>
							<div class="col-md-5">
		                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
		                            <input type="checkbox"  {{ ($is_editable['with_parking'] == 1) ? '' : 'disabled' }} {{ ( $with_parking ) ? 'checked="checked"' : '' }} name="partners_personal[with_parking][temp]" id="partners_personal-with_parking-temp" class="dontserializeme toggle"/>
		                            <input type="hidden" name="partners_personal[with_parking]" id="partners_personal-with_parking" value="{{ ( $with_parking ) ? 1 : 0 }}" />
		                        </div> 
		                    </div>
						</div>
					</div>
				@endif
            </div>
        </div>
	</div>
</div>


<!-- Other Personal Information -->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('my201.other_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
		<div class="form-horizontal">
            <div class="form-body">
            	 @if(in_array('height', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.height') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['height'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[height]" id="partners_personal-height" value="{{ $height }}" placeholder="Enter Height"/>
		                    </div>
						</div>
					</div>
                @endif
                @if(in_array('weight', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.weight') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['weight'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[weight]" id="partners_personal-weight" value="{{ $weight }}" placeholder="Enter Weight"/>
		                    </div>
						</div>
					</div>
                @endif
                @if(in_array('interests_hobbies', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.hobby') }}</label>
							<div class="col-md-5">
		                        <div class="input-group">
		                            <span class="input-group-addon"><i class="fa fa-star"></i></span>
		                        <input type="text" class="form-control" {{ ($is_editable['interests_hobbies'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[interests_hobbies]" id="partners_personal-interests_hobbies" value="{{ $interests_hobbies }}" placeholder="Enter Interest and Hobbies"/>
		                         </div>
		                    </div>
						</div>
					</div>
                @endif
                @if(in_array('language', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.languages') }}</label>
							<div class="col-md-5">                                   
		                        <input type="text" class="form-control" {{ ($is_editable['language'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[language]" id="partners_personal-language" value="{{ $language }}" placeholder="Enter Languange Known"/>
		                    </div>
						</div>
					</div>
                @endif
                @if(in_array('dialect', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.dialects') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['language'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[dialect]" id="partners_personal-dialect" value="{{ $dialect }}" placeholder="Enter Dialects"/>
		                    </div>
						</div>
					</div>
                @endif
                @if(in_array('dependents_count', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.no_dependents') }}</label>
							<div class="col-md-5">
		                        <input type="text" class="form-control" {{ ($is_editable['dependents_count'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal[dependents_count]" id="partners_personal-dependents_count" value="{{ $dependents_count }}" placeholder="Enter No. of Dependents"/>
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
