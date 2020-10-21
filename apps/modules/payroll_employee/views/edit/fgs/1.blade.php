<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Setup </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Total Year Days</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[total_year_days]" id="payroll_partners-total_year_days" value="{{ $record['payroll_partners.total_year_days'] }}" placeholder="Enter Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rate Type</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_rate_type_id,payroll_rate_type');
	                            			                            		$db->order_by('payroll_rate_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_rate_type'); 	                            $payroll_partners_payroll_rate_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_payroll_rate_type_id_options[$option->payroll_rate_type_id] = $option->payroll_rate_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[payroll_rate_type_id]',$payroll_partners_payroll_rate_type_id_options, $record['payroll_partners.payroll_rate_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Schedule</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_schedule_id,payroll_schedule');
	                            			                            		$db->order_by('payroll_schedule', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_schedule'); 	                            $payroll_partners_payroll_schedule_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_payroll_schedule_id_options[$option->payroll_schedule_id] = $option->payroll_schedule;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[payroll_schedule_id]',$payroll_partners_payroll_schedule_id_options, $record['payroll_partners.payroll_schedule_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rate</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[salary]" id="payroll_partners-salary" value="{{ $record['payroll_partners.salary'] }}" placeholder="Enter Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Tax Code</label>
				<div class="col-md-7"><?php									                            		$db->select('taxcode_id,taxcode');
	                            			                            		$db->order_by('taxcode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('taxcode'); 	                            $payroll_partners_taxcode_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_taxcode_id_options[$option->taxcode_id] = $option->taxcode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[taxcode_id]',$payroll_partners_taxcode_id_options, $record['payroll_partners.taxcode_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Minimum Takehome</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[minimum_takehome]" id="payroll_partners-minimum_takehome" value="{{ $record['payroll_partners.minimum_takehome'] }}" placeholder="Enter Minimum Takehome" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Bank Account</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[bank_account]" id="payroll_partners-bank_account" value="{{ $record['payroll_partners.bank_account'] }}" placeholder="Enter Bank Account" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payment Type</label>
				<div class="col-md-7"><?php									                            		$db->select('payment_type_id,payment_type');
	                            			                            		$db->order_by('payment_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_payment_type'); 	                            $payroll_partners_taxcode_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_payment_type_id_options[$option->payment_type_id] = $option->payment_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[payment_type_id]',$payroll_partners_payment_type_id_options, $record['payroll_partners.payment_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payroll Location</label>
				<div class="col-md-5"><?php									                            		$db->select('location_id,location');
	                            			                            		$db->order_by('location', '0');
	                            		$db->where('deleted', '0');
	                            		$db->where('status_id', '1');
	                            		$options = $db->get('users_location'); 	                            $payroll_partners_location_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_location_id_options[$option->location_id] = $option->location;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[location_id]',$payroll_partners_location_id_options, $record['payroll_partners.location_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div>	<div class="form-group">
				<label class="control-label col-md-3">Fixed Rate</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.fixed_rate'] ) checked="checked" @endif name="payroll_partners[fixed_rate][temp]" id="payroll_partners-fixed_rate-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[fixed_rate]" id="payroll_partners-fixed_rate" value="@if( $record['payroll_partners.fixed_rate'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Sensitivity</label>
				<div class="col-md-7"><?php									                            		$db->select('sensitivity_id,sensitivity');
	                            			                            		$db->order_by('sensitivity', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('sensitivity'); 	                            $payroll_partners_sensitivity_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_sensitivity_options[$option->sensitivity_id] = $option->sensitivity;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[sensitivity]',$payroll_partners_sensitivity_options, $record['payroll_partners.sensitivity'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Resigned Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[resigned_date]" id="partners-resigned_date" value="{{ $record['partners.resigned_date'] }}" placeholder="Enter Resigned Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
		</div> 				<div class="form-group">
				<label class="control-label col-md-3">Attendance Base</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.attendance_base'] ) checked="checked" @endif name="payroll_partners[attendance_base][temp]" id="payroll_partners-attendance_base-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[attendance_base]" id="payroll_partners-attendance_base" value="@if( $record['payroll_partners.attendance_base'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">On Hold</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.on_hold'] ) checked="checked" @endif name="payroll_partners[on_hold][temp]" id="payroll_partners-on_hold-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[on_hold]" id="payroll_partners-on_hold" value="@if( $record['payroll_partners.on_hold'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			</div>
</div>