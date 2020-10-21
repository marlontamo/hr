<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Info</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Period</label>
				<div class="col-md-7">							<input type="hidden" name="payroll_period[date]"/>
							<div class="input-group input-xlarge date-picker input-daterange" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_period[date_from]" id="payroll_period-date_from" value="{{ $record['payroll_period.date_from'] }}" />
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control" name="payroll_period[date_to]" id="payroll_period-date_to" value="{{ $record['payroll_period.date_to'] }}" />
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_period[payroll_date]" id="payroll_period-payroll_date" value="{{ $record['payroll_period.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Posting Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_period[posting_date]" id="payroll_period-posting_date" value="{{ $record['payroll_period.posting_date'] }}" placeholder="Enter Posting Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Apply To</label>
				<div class="col-md-7"><?php									                            		$db->select('apply_to_id,apply_to');
	                            			                            		$db->order_by('apply_to', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_apply_to'); 	                            $payroll_period_apply_to_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_period_apply_to_id_options[$option->apply_to_id] = $option->apply_to;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_period[apply_to_id]',$payroll_period_apply_to_id_options, $record['payroll_period.apply_to_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_period-apply_to_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Processing</label>
				<div class="col-md-7"><?php									                            		$db->select('period_processing_type_id,period_processing_type');
	                            			                            		$db->order_by('period_processing_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_period_processing_type'); 	                            $payroll_period_period_processing_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_period_period_processing_type_id_options[$option->period_processing_type_id] = $option->period_processing_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_period[period_processing_type_id]',$payroll_period_period_processing_type_id_options, $record['payroll_period.period_processing_type_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_period-period_processing_type_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Schedule</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_schedule_id,payroll_schedule');
	                            			                            		$db->order_by('payroll_schedule', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_schedule'); 	                            $payroll_period_payroll_schedule_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_period_payroll_schedule_id_options[$option->payroll_schedule_id] = $option->payroll_schedule;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_period[payroll_schedule_id]',$payroll_period_payroll_schedule_id_options, $record['payroll_period.payroll_schedule_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_period-payroll_schedule_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Week</label>
				<div class="col-md-7"><?php									                            		$db->select('week_id,week');
	                            			                            		$db->order_by('week', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_week'); 	                            $payroll_period_week_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_period_week_options[$option->week_id] = $option->week;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_period[week]',$payroll_period_week_options, $record['payroll_period.week'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_period-week"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="payroll_period[remarks]" id="payroll_period-remarks" placeholder="Enter Remarks" rows="4">{{ $record['payroll_period.remarks'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Status</label>
				<div class="col-md-7"><?php									                            		$db->select('period_status_id,period_status');
	                            			                            		$db->order_by('period_status', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_period_status'); 	                            $payroll_period_period_status_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_period_period_status_id_options[$option->period_status_id] = $option->period_status;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_period[period_status_id]',$payroll_period_period_status_id_options, $record['payroll_period.period_status_id'], 'class="form-control select2me" data-placeholder="Select..." id="payroll_period-period_status_id"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>