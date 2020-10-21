<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners.employment_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.status') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <?php   $db->select('employment_status_id,employment_status, active');
                                $db->where('deleted', '0');
                                $options = $db->get('partners_employment_status');
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <select name="partners[status_id]" id="partners-emp_status_id" class="form-control select2me" data-placeholder="Select..." >
                                <option></option>
                                @foreach($options->result() as $option)
                                    <option value="{{$option->employment_status_id}}" data-active="{{$option->active}}">
                                        {{$option->employment_status}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>  
                </div>
                <div class="form-group hidden resigned_date">
                    <label class="control-label col-md-3">{{ lang('partners.end_date') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners[resigned_date]" id="partners-resigned_date" value="" placeholder="{{ lang('common.enter') }} {{ lang('partners.end_date') }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.types') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <?php   $db->select('employment_type_id,employment_type');
                                $db->where('deleted', '0');
                                $options = $db->get('partners_employment_type');

                                $partners_type_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_type_id_options[$option->employment_type_id] = $option->employment_type;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners[employment_type_id]',$partners_type_id_options, null, 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @if(in_array('job_class', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.career_steam') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                        <?php   $db->select('job_class_id,job_class');
                                $db->where('deleted', '0');
                                $options = $db->get('users_job_class');

                                $partners_job_class_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_job_class_options[$option->job_class] = $option->job_class;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[job_class]',$partners_job_class_options, $record['job_class'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('job_rank_level', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.career_level') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('job_rank_level_id,job_rank_level');
                                $db->where('deleted', '0');
                                $options = $db->get('users_job_rank_level');

                                $partners_career_level_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {

                                    $partners_career_level_options[$option->job_rank_level] = $option->job_rank_level;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[job_rank_level]',$partners_career_level_options, $record['job_rank_level'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('job_level', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.job_grade') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('job_grade_id,job_level');
                                $db->where('deleted', '0');
                                $options = $db->get('users_job_grade_level');

                                $partners_job_grade_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_job_grade_options[$option->job_grade_id] = $option->job_level;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners[job_grade_id]',$partners_job_grade_options, $record['partners.job_grade_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('pay_level', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.pay_grade') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('pay_level_id,pay_level');
                                $db->where('deleted', '0');
                                $options = $db->get('users_job_pay_level');

                                $partners_job_pay_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_job_pay_options[$option->pay_level] = $option->pay_level;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[pay_level]',$partners_job_pay_options, $record['pay_level'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('pay_set_rates', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.pay_set_rates') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('pay_set_rates_id,pay_set_rates');
                                $db->where('deleted', '0');
                                $options = $db->get('users_pay_set_rates');

                                $partners_pay_set_rates_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_pay_set_rates_options[$option->pay_set_rates] = $option->pay_set_rates;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[pay_set_rates]',$partners_pay_set_rates_options, $record['pay_set_rates'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('competency_level', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.competency_level') }}</label>
                    <div class="col-md-5">
                        <?php   $db->select('competency_level_id,competency_level');
                                $db->where('deleted', '0');
                                $options = $db->get('users_competency_level');

                                $partners_competency_level_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $partners_competency_level_options[$option->competency_level] = $option->competency_level;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[competency_level]',$partners_competency_level_options, $record['competency_level'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                @if(in_array('employee_grade', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.employee_grade') }}</label>
                    <div class="col-md-5">
                        <?php   $options = $db->get_where('partners_grade', array('deleted' => 0));
                                $grade_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $grade_options[$option->grade] = $option->grade;
                                } ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        {{ form_dropdown('partners_personal[employee_grade]',$grade_options, $record['employee_grade'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                @endif
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.hire_date') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[effectivity_date]" id="partners-effectivity_date" value="" placeholder="{{ lang('common.enter') }} {{ lang('partners.hier_date') }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                @if(in_array('probationary_date', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ $partners_labels['probationary_date'] }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[probationary_date]" id="partners_personal-probationary_date" value="{{ $record['partners.resigned_date'] }}" placeholder="{{ lang('common.enter') }} {{ $partners_labels['probationary_date'] }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <span class="text-muted small">End date of employment/contract service</span>
                    </div>
                </div>
                @endif
                @if(in_array('original_date_hired', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.ohire_date') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[original_date_hired]" id="partners_personal-original_date_hired" value="{{ $record['partners.effectivity_date'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.ohire_date') }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('last_probationary', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners.last_probi') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[last_probationary]" id="partners_personal-last_probationary" value="{{ $record_personal[1]['partners_personal.last_probationary'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.last_probi') }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                @if(in_array('last_salary_adjustment', $partners_keys))
                <div class="form-group ">
                    <label class="control-label col-md-3">{{ lang('partners.last_sa') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[last_salary_adjustment]" id="partners_personal-last_salary_adjustment" value="{{ $record_personal[1]['partners_personal.last_salary_adjustment'] }}" placeholder="{{ lang('common.enter') }} {{ lang('partners.last_sa') }}" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <span class="help-block">{{ lang('partners.dt_sal_adjust') }}</span> 
                    </div>
                </div>
                @endif
            </div>
        </div>
	</div>
</div>