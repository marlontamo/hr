<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('performance_appraisal.appraisal') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>{{ lang('performance_appraisal.appraisal') }}</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('performance_appraisal.year') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_appraisal[year]" id="performance_appraisal-year" value="{{ $record['performance_appraisal.year'] }}" placeholder="Enter Year" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.dt_from') }}</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="performance_appraisal[date_from]" id="performance_appraisal-date_from" value="{{ $record['performance_appraisal.date_from'] }}" placeholder="Enter Date From" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.dt_to') }}</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="performance_appraisal[date_to]" id="performance_appraisal-date_to" value="{{ $record['performance_appraisal.date_to'] }}" placeholder="Enter Date To" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.performance_type') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('performance_id,performance');
	                            			                            		$db->order_by('performance', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_setup_performance'); 	                            $performance_appraisal_performance_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_appraisal_performance_type_id_options[$option->performance_id] = $option->performance;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[performance_type_id]',$performance_appraisal_performance_type_id_options, $record['performance_appraisal.performance_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-performance_type_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.template') }}</label>
				<div class="col-md-7"><?php                                                        		$db->select('template_id,template');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('performance_template');
									$performance_appraisal_template_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$performance_appraisal_template_id_options[$option->template_id] = $option->template;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[template_id][]',$performance_appraisal_template_id_options, explode(',', $record['performance_appraisal.template_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal-template_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.period_status') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{ lang('performance_appraisal.yes') }}&nbsp;" data-off-label="&nbsp;{ lang('performance_appraisal.no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['performance_appraisal.status_id'] ) checked="checked" @endif name="performance_appraisal[status_id][temp]" id="performance_appraisal-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="performance_appraisal[status_id]" id="performance_appraisal-status_id" value="@if( $record['performance_appraisal.status_id'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.notes') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="performance_appraisal[notes]" id="performance_appraisal-notes" placeholder="Enter Notes" rows="4">{{ $record['performance_appraisal.notes'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{ lang('performance_appraisal.filter_by') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('filter_id,filter_by');
	                            			                            		$db->order_by('filter_by', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_appraisal_filter'); 	                            $performance_appraisal_filter_by_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_appraisal_filter_by_options[$option->filter_id] = $option->filter_by;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[filter_by]',$performance_appraisal_filter_by_options, $record['performance_appraisal.filter_by'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-filter_by"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{ lang('performance_appraisal.selection') }}</label>
				<div class="col-md-7"><?php                                                        		$db->select('company_id,company');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users_company');
									$performance_appraisal_filter_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$performance_appraisal_filter_id_options[$option->company_id] = $option->company;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[filter_id][]',$performance_appraisal_filter_id_options, explode(',', $record['performance_appraisal.filter_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal-filter_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.applicable_for') }}</label>
				<div class="col-md-7"><?php                                                        		$db->select('user_id,full_name');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('users');
									$performance_appraisal_applicable_user_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$performance_appraisal_applicable_user_id_options[$option->user_id] = $option->full_name;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal_applicable[user_id][]',$performance_appraisal_applicable_user_id_options, explode(',', $record['performance_appraisal_applicable.user_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal_applicable-user_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{ lang('performance_appraisal.employment_status_filter') }}</label>
				<div class="col-md-7"><?php                                                        		$db->select('employment_status_id,employment_status');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('partners_employment_status');
									$performance_appraisal_employment_status_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$performance_appraisal_employment_status_id_options[$option->employment_status_id] = $option->employment_status;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[employment_status_id][]',$performance_appraisal_employment_status_id_options, explode(',', $record['performance_appraisal.employment_status_id']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="performance_appraisal-employment_status_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{ lang('performance_appraisal.planning') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('planning_id,planning');
	                            			                            		$db->order_by('planning', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_planning'); 	                            $performance_appraisal_planning_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_appraisal_planning_id_options[$option->planning_id] = $option->planning;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_appraisal[planning_id]',$performance_appraisal_planning_id_options, $record['performance_appraisal.planning_id'], 'class="form-control select2me" data-placeholder="Select..." id="performance_appraisal-planning_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>