<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('partners_immediate.emergency_contact') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">
				<div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.status') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                    	<?php 	$db->select('employment_status_id,employment_status');
                    			$db->where('deleted', '0');
                    			$options = $db->get('partners_employment_status');

                    			$partners_status_id_options = array('' => 'Select...');
                    			foreach($options->result() as $option)
                    			{
                    				$partners_status_id_options[$option->employment_status_id] = $option->employment_status;
                    			} ?>
                    	<div class="input-group">
							<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                        </span>
	                    {{ form_dropdown('partners[status_id]',$partners_status_id_options, $record['partners.status_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                    </div>
	                </div>	
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.type') }}<span class="required">*</span></label>
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
                        {{ form_dropdown('partners[employment_type_id]',$partners_type_id_options, $record['partners.employment_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                        </div>
                    </div>  
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.hire_date') }}<span class="required">*</span></label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[effectivity_date]" id="partners-effectivity_date" value="{{ $record['partners.effectivity_date'] }}" placeholder="Enter Date Hired" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.probi_date') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[probationary_date]" id="partners_personal-probationary_date" value="{{ $record_personal[1]['partners_personal.probationary_date'] }}" placeholder="Enter Probationary Date" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.ohire_date') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[original_date_hired]" id="partners_personal-original_date_hired" value="{{ $record_personal[1]['partners_personal.original_date_hired'] }}" placeholder="Enter Original Date Hired" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.last_probi') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[last_probationary]" id="partners_personal-last_probationary" value="{{ $record_personal[1]['partners_personal.last_probationary'] }}" placeholder="Enter Last Probationary" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.last_sa') }}</label>
                    <div class="col-md-5">
                   		<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                            <input type="text" class="form-control" name="partners_personal[last_salary_adjustment]" id="partners_personal-last_salary_adjustment" value="{{ $record_personal[1]['partners_personal.last_salary_adjustment'] }}" placeholder="Enter Last Salary Adjustment" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <span class="help-block">{{ lang('partners_immediate.dt_sal_adjust') }}</span> 
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>