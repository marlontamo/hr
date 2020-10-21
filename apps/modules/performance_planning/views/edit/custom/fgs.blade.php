<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('performance_planning.planning') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.year') }}
			</label>
			<div class="col-md-5">
				<?php		
					$min_year = date('Y');
					$max_year = date('Y');
					$db->select_min('year');
					$db->where('deleted', '0');	
					$result = $db->get('performance_planning'); 	
					if ($result && $result->num_rows() > 0){
						if ($result->row()->year != NULL){
							$min_year = $result->row()->year;
						}
					}

					for ($i=$min_year; $i <= $max_year; $i++) { 
						$performance_planning_year_options[$i] = $i;
					}
                ?>							
                <div class="input-group">
					<span class="input-group-addon">
                    <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('performance_planning[year]',$performance_planning_year_options, $record['performance_planning.year'], 'class="form-control select2me" data-placeholder="Select..." id="performance_planning-year"') }}
                </div> 					
				<!-- <input type="text" class="form-control" name="performance_planning[year]" id="performance_planning-year" value="{{ $record['performance_planning.year'] }}" placeholder="Enter Year" /> -->
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.performance_type') }}
			</label>
			<div class="col-md-5"><?php									                            		
				$db->select('performance_id,performance');
				$db->order_by('performance', '0');
				$db->where('deleted', '0');
				$options = $db->get('performance_setup_performance');
				$performance_planning_performance_type_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$performance_planning_performance_type_id_options[$option->performance_id] = $option->performance;
				} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning[performance_type_id]',$performance_planning_performance_type_id_options, $record['performance_planning.performance_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.from') }}
			</label>
			<div class="col-md-6">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="performance_planning[date_from]" id="performance_planning-date_from" value="{{ $record['performance_planning.date_from'] }}" placeholder="Enter Date From" readonly>
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				<div class="help-block small">{{ lang('performance_planning.start_date') }}</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.to') }}
			</label>
			<div class="col-md-6">
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
					<input type="text" class="form-control" name="performance_planning[date_to]" id="performance_planning-date_to" value="{{ $record['performance_planning.date_to'] }}" placeholder="Enter Date To" readonly>
					<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
				<div class="help-block small">{{ lang('performance_planning.end_date') }}</div>
			</div>
		</div>
<!-- 		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.template') }}</label>
			<div class="col-md-6">
				<?php
				$db->select('template_id,template');
				$db->where('deleted', '0');
				$options = $db->get('performance_template');
				$performance_planning_template_id_options = array();
					foreach($options->result() as $option)
					{
						$performance_planning_template_id_options['Selection'][$option->template_id] = $option->template;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning[template_id][]',$performance_planning_template_id_options, explode(',', $record['performance_planning.template_id']), 'class="form-control select2" data-placeholder="Select..." multiple id="performance_planning-template_id"') }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.employment_status_filter') }}
			</label>
			<div class="col-md-6">
				<?php
				$db->select('employment_status_id,employment_status');
				$db->where('deleted', '0');
				$options = $db->get('partners_employment_status');
				$employment_status_id_options = array();
					foreach($options->result() as $option)
					{
						$employment_status_id_options['Selection'][$option->employment_status_id] = $option->employment_status;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning[employment_status_id][]',$employment_status_id_options, explode(',', $record['performance_planning.employment_status_id']), 'class="form-control select2" data-placeholder="Select..." multiple id="performance_planning-employment_status_id"') }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">{{ lang('performance_planning.filter_by') }}</label>
			<div class="col-md-6">
				<?php
					$db->select('filter_id,filter_by');
					$db->order_by('filter_by', '0');
					$db->where('deleted', '0');
					$options = $db->get('performance_planning_filter');
					$performance_planning_filter_by_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$performance_planning_filter_by_options[$option->filter_id] = $option->filter_by;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning[filter_by]',$performance_planning_filter_by_options, $record['performance_planning.filter_by'], 'class="form-control select2me" data-placeholder="Select..." id="performance_planning-filter_by"') }}
				</div>
			</div>
		</div>	
		<div class="form-group">
			<label class="control-label col-md-4">{{ lang('performance_planning.selection') }}</label>
			<div class="col-md-6">
				<?php
				$db->select('company_id,company');
				$db->where('deleted', '0');
				$options = $db->get('users_company');
				$performance_planning_filter_id_options = array();
				foreach($options->result() as $option)
				{
					$performance_planning_filter_id_options[$option->company_id] = $option->company;
				} ?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning[filter_id][]',$performance_planning_filter_id_options, explode(',', $record['performance_planning.filter_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_planning-filter_id"') }}
				</div>
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.applicable_for') }}
			</label>
			<div class="col-md-6">
				<?php
				$db->select('user_id,full_name');
				$db->where('deleted', '0');
				$db->order_by('full_name', '0');
				$options = $db->get('users');
				$performance_planning_applicable_user_id_options = array();
				foreach($options->result() as $option)
				{
					$performance_planning_applicable_user_id_options[$option->user_id] = $option->full_name;
				} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('performance_planning_applicable[user_id][]',$performance_planning_applicable_user_id_options, explode(',', $record['performance_planning_applicable.user_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_planning_applicable-user_id"') }}
				</div>
			</div>
		</div>	 -->
		<!-- <div class="form-group hidden">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				Selection
			</label>
			<div class="col-md-5">
				<input type="text" class="form-control" name="performance_planning_applicable[reference_id]" id="performance_planning_applicable-reference_id" rows="4" value="{{ $record['performance_planning_applicable.reference_id'] }}">
			</div>
		</div> -->
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.period_status') }}
			</label>
			<div class="col-md-5">
				<div class="make-switch" data-on-label="&nbsp;{{ lang('performance_planning.open') }}&nbsp;" data-off-label="&nbsp;{{ lang('performance_planning.close') }}&nbsp;">
					<input type="checkbox" value="1" @if( $record['performance_planning.status_id'] || empty($record_id) ) checked="checked" @endif name="performance_planning[status_id][temp]" id="performance_planning-status_id-temp" class="dontserializeme toggle"/>
					<input type="hidden" name="performance_planning[status_id]" id="performance_planning-status_id" value="@if( $record['performance_planning.status_id'] || empty($record_id) ) 1 @else 0 @endif"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-4">
				<span class="required">* </span>
				{{ lang('performance_planning.notes') }}
			</label>
			<div class="col-md-5">
				<textarea class="form-control" name="performance_planning[notes]" id="performance_planning-notes" placeholder="Enter Notes" rows="4">{{ $record['performance_planning.notes'] }}</textarea>
			</div>
		</div>		
	</div>
</div>
<br>