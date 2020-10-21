<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('leave_balance_admin.leave_bal') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('leave_balance_admin.year') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_balance[year]" id="time_form_balance-year" value="{{ $record['time_form_balance.year'] }}" placeholder="Enter Year" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('leave_balance_admin.partner') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,display_name');
	                            			                            		$db->order_by('display_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users'); 	                            $time_form_balance_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_balance_user_id_options[$option->user_id] = $option->display_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_balance[user_id]',$time_form_balance_user_id_options, $record['time_form_balance.user_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('leave_balance_admin.leave_type') }}</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT * FROM ww_time_form WHERE is_leave = 1")); 	                            $time_form_balance_form_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_balance_form_id_options[$option->form_id] = $option->form;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_balance[form_id]',$time_form_balance_form_id_options, $record['time_form_balance.form_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('leave_balance_admin.prev_credit') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_balance[previous]" id="time_form_balance-previous" value="{{ $record['time_form_balance.previous'] }}" placeholder="Enter Previous Credit" /> 				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('leave_balance_admin.cur_credit') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_balance[current]" id="time_form_balance-current" value="{{ $record['time_form_balance.current'] }}" placeholder="Enter Current Credit" /> 				</div>	
			</div>	
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Expiration Date</label>
				<div class="col-md-7">	
					<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
						<input type="text" class="form-control" name="time_form_balance[period_extension]" id="time_form_balance-period_extension" value="{{ $record['time_form_balance.period_extension'] }}" placeholder="Enter Expiration Date" readonly>
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</div>
			</div>	
		</div>
</div>