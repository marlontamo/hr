<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee</label>
				<div class="col-md-7"><?php		
										$qry_category = $mod->get_role_category();							                            		
										$db->select('users.user_id,users.full_name');
	                            		$db->order_by('full_name', '0');
										$db->join('partners', 'users.user_id = partners.user_id');
										$db->join('users_profile', 'users_profile.user_id = partners.user_id');

								        if ($qry_category != ''){
								            $db->where($qry_category, '', false);
								        }	                            		
	                            		$db->where('users.deleted', '0');
	                            		$options = $db->get('users'); 	                            
	                            		$time_record_summary_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_record_summary_user_id_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_record_summary[user_id]',$time_record_summary_user_id_options, $record['time_record_summary.user_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_record_summary[date]" id="time_record_summary-date" value="{{ $record['time_record_summary.date'] }}" placeholder="Enter Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_record_summary[payroll_date]" id="time_record_summary-payroll_date" value="{{ $record['time_record_summary.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Day Type</label>
				<div class="col-md-7"><?php									                            		$db->select('day_type_code,day_type');
	                            			                            		$db->order_by('day_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('time_day_type'); 	                            $time_record_summary_day_type_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_record_summary_day_type_options[$option->day_type_code] = $option->day_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_record_summary[day_type]',$time_record_summary_day_type_options, $record['time_record_summary.day_type'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Hours Worked</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[hrs_actual]" id="time_record_summary-hrs_actual" value="{{ $record['time_record_summary.hrs_actual'] }}" placeholder="Enter Hours Worked" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Absent</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['time_record_summary.absent'] ) checked="checked" @endif name="time_record_summary[absent][temp]" id="time_record_summary-absent-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="time_record_summary[absent]" id="time_record_summary-absent" value="@if( $record['time_record_summary.absent'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Paid Leaves</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[lwp]" id="time_record_summary-lwp" value="{{ $record['time_record_summary.lwp'] }}" placeholder="Enter Paid Leaves" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Unpaid Leaves</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[lwop]" id="time_record_summary-lwop" value="{{ $record['time_record_summary.lwop'] }}" placeholder="Enter Unpaid Leaves" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Lates</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[late]" id="time_record_summary-late" value="{{ $record['time_record_summary.late'] }}" placeholder="Enter Lates" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Undertime</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[undertime]" id="time_record_summary-undertime" value="{{ $record['time_record_summary.undertime'] }}" placeholder="Enter Undertime" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Overtime</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_record_summary[ot]" id="time_record_summary-ot" value="{{ $record['time_record_summary.ot'] }}" placeholder="Enter Overtime" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>	</div>
</div>