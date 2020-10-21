<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			<?php
				$db->where('user_id', $record_id);
				$partner = $db->get('users')->row_array();
				if(!empty($partner)){
					echo $partner['full_name'];
				}
	        ?>

	    </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Total Year Days</label>
				<div class="col-md-3">							<input type="text" class="form-control" name="payroll_partners[total_year_days]" id="payroll_partners-total_year_days" value="{{ $record['payroll_partners.total_year_days'] }}" placeholder="Enter Total Year Days" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rate Type</label>
				<div class="col-md-5"><?php									                            		$db->select('payroll_rate_type_id,payroll_rate_type');
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
				<div class="col-md-5"><?php									                            		$db->select('payroll_schedule_id,payroll_schedule');
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
				<div class="col-md-3">							<input type="text" class="form-control" name="payroll_partners[salary]" id="payroll_partners-salary" value="{{ $record['payroll_partners.salary'] }}" placeholder="Enter Rate" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
            </div>          <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Company</label>
                <div class="col-md-5"><?php                                                                     $db->select('company_id,company');
                                                                                $db->order_by('company', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('users_company');                                 $payroll_partners_company_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                                                            $payroll_partners_company_id_options[$option->company_id] = $option->company;
                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_partners[company_id]',$payroll_partners_company_id_options, $record['payroll_partners.company_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          
            <div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Tax Code</label>
				<div class="col-md-5"><?php									                            		$db->select('taxcode_id,taxcode');
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
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">Minimum Takehome</label>
				<div class="col-md-3">							<input type="text" class="form-control" name="payroll_partners[minimum_takehome]" id="payroll_partners-minimum_takehome" value="{{ $record['payroll_partners.minimum_takehome'] }}" placeholder="Enter Minimum Takehome" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">Account Type</label>
				<div class="col-md-5">
					<div class="input-group">
						<span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                        </span>
                        <?php
                        	$payroll_partners_account_type_id_options = array('' => 'Select...');
                        	$payroll_partners_account_type_id_options[1] = 'Current';
                        	$payroll_partners_account_type_id_options[2] = 'Savings';
                        ?>
                        {{ form_dropdown('payroll_partners[account_type_id]',$payroll_partners_account_type_id_options, $record['payroll_partners.account_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                </div> 				</div>	
			</div>
            <div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Bank Name</label>
				<div class="col-md-5"><?php									                            		
										$db->select('bank_id,CONCAT(bank," - ",IFNULL(account_name,"")) as bank',false);
	                            		$db->order_by('bank');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_bank'); 
	                            		$payroll_partners_bank_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_bank_id_options[$option->bank_id] = $option->bank;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[bank_id]',$payroll_partners_bank_id_options, $record['payroll_partners.bank_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>						
			<div class="form-group">
				<label class="control-label col-md-3">Bank Account</label>
				<div class="col-md-3">							<input type="text" class="form-control" name="payroll_partners[bank_account]" id="payroll_partners-bank_account" value="{{ $record['payroll_partners.bank_account'] }}" placeholder="Enter Bank Account" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Payment Type</label>
				<div class="col-md-5"><?php									                            		$db->select('payment_type_id,payment_type');
	                            			                            		$db->order_by('payment_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_payment_type'); 	                            $payroll_partners_payment_type_id_options = array('' => 'Select...');
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
	                        </div> 				</div>	
			</div><div class="form-group hidden">
				<label class="control-label col-md-3">Fixed Rate</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.fixed_rate'] ) checked="checked" @endif name="payroll_partners[fixed_rate][temp]" id="payroll_partners-fixed_rate-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[fixed_rate]" id="payroll_partners-fixed_rate" value="@if( $record['payroll_partners.fixed_rate'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Sensitivity</label>
				<div class="col-md-5"><?php									                            		$db->select('sensitivity_id,sensitivity');
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
	                        </div><span class="help-block small">Confidentiality purpose.</span> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Resigned Date</label>
				<div class="col-md-4">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[resigned_date]" id="partners-resigned_date" value="{{ $record['partners.resigned_date'] }}" placeholder="Enter Resigned Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div><span class="help-block small">Resignation effectivity date.</span> 				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">Attendance Base</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.attendance_base'] ) checked="checked" @endif name="payroll_partners[attendance_base][temp]" id="payroll_partners-attendance_base-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[attendance_base]" id="payroll_partners-attendance_base" value="@if( $record['payroll_partners.attendance_base'] ) 1 else 0 @endif"/>
							</div><span class="help-block small">If set to NO, will not use time recordexcempted from in processing of payroll.</span> 				</div>	
			</div>	
			<div class="form-group">
				<label class="control-label col-md-3">Payout Scheme</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="0" @if( $record['payroll_partners.whole_half'] == 0 ) checked="checked" @endif name="payroll_partners[whole_half][temp]" id="payroll_partners-whole_half-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[whole_half]" id="payroll_partners-whole_half" value="@if( $record['payroll_partners.whole_half'] ) 1 else 0 @endif"/>
							</div><span class="help-block small">If set to Yes, whole salary will be payout on payroll.</span> 				</div>	
			</div>		
			<div class="form-group">
				<label class="control-label col-md-3">Payout Schedule</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="0" @if( $record['payroll_partners.payout_schedule'] == 0 ) checked="checked" @endif name="payroll_partners[payout_schedule][temp]" id="payroll_partners-payout_schedule-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[payout_schedule]" id="payroll_partners-payout_schedule" value="@if( $record['payroll_partners.payout_schedule'] ) 1 else 0 @endif"/>
							</div><span class="help-block small">If set to Yes, payroll give on every 2nd week or else 4th week.</span> 				</div>	
			</div>							
			<div class="form-group">
				<label class="control-label col-md-3">On Hold</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.on_hold'] ) checked="checked" @endif name="payroll_partners[on_hold][temp]" id="payroll_partners-on_hold-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[on_hold]" id="payroll_partners-on_hold" value="@if( $record['payroll_partners.on_hold'] ) 1 else 0 @endif"/>
							</div><span class="help-block small">If set to YES, Make this partner temporarily be excempted from payroll processing.</span> 				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">Non Swipe</label>
				<div class="col-md-4">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['payroll_partners.non_swipe'] ) checked="checked" @endif name="payroll_partners[non_swipe][temp]" id="payroll_partners-non_swipe-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="payroll_partners[non_swipe]" id="payroll_partners-non_swipe" value="@if( $record['payroll_partners.non_swipe'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">SSS Setup </div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form" style="display: none;">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>SSS No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[sss_no]" id="payroll_partners-sss_no" value="{{ $record['payroll_partners.sss_no'] }}" placeholder="Enter SSS No." /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>SSS Transaction Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_mode_id,payroll_transaction_mode');
	                            			                            		$db->order_by('payroll_transaction_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_mode'); 	                            $payroll_partners_sss_mode_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_sss_mode_options[$option->payroll_transaction_mode_id] = $option->payroll_transaction_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[sss_mode]',$payroll_partners_sss_mode_options, $record['payroll_partners.sss_mode'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[sss_amount]" id="payroll_partners-sss_amount" value="{{ $record['payroll_partners.sss_amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Week</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_partners_sss_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_partners_sss_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[sss_week][]',$payroll_partners_sss_week_options, explode(',', $record['payroll_partners.sss_week']), 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="payroll_partners-sss_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">HDMF Setup </div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form" style="display: none;">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>PagIbig No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[hdmf_no]" id="payroll_partners-hdmf_no" value="{{ $record['payroll_partners.hdmf_no'] }}" placeholder="Enter PagIbig No." /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>HDMF Transaction Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_mode_id,payroll_transaction_mode');
	                            			                            		$db->order_by('payroll_transaction_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_mode'); 	                            $payroll_partners_hdmf_mode_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_hdmf_mode_options[$option->payroll_transaction_mode_id] = $option->payroll_transaction_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[hdmf_mode]',$payroll_partners_hdmf_mode_options, $record['payroll_partners.hdmf_mode'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[hdmf_amount]" id="payroll_partners-hdmf_amount" value="{{ $record['payroll_partners.hdmf_amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Week</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_partners_hdmf_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_partners_hdmf_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[hdmf_week][]',$payroll_partners_hdmf_week_options, explode(',', $record['payroll_partners.hdmf_week']), 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="payroll_partners-hdmf_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">PHIC Setup </div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form" style="display: none;">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>PhilHealth No.</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[phic_no]" id="payroll_partners-phic_no" value="{{ $record['payroll_partners.phic_no'] }}" placeholder="Enter PhilHealth No." /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>PHIC Transaction Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_mode_id,payroll_transaction_mode');
	                            			                            		$db->order_by('payroll_transaction_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_mode'); 	                            $payroll_partners_phic_mode_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_phic_mode_options[$option->payroll_transaction_mode_id] = $option->payroll_transaction_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[phic_mode]',$payroll_partners_phic_mode_options, $record['payroll_partners.phic_mode'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[phic_amount]" id="payroll_partners-phic_amount" value="{{ $record['payroll_partners.phic_amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Week</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_partners_phic_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_partners_phic_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[phic_week][]',$payroll_partners_phic_week_options, explode(',', $record['payroll_partners.phic_week']), 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="payroll_partners-phic_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">WHTAX Setup </div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form" style="display: none;">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>TIN</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[tin]" id="payroll_partners-tin" value="{{ $record['payroll_partners.tin'] }}" placeholder="Enter TIN" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>WHTAX Transaction Mode</label>
				<div class="col-md-7"><?php									                            		$db->select('payroll_transaction_mode_id,payroll_transaction_mode');
	                            			                            		$db->order_by('payroll_transaction_mode', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('payroll_transaction_mode_tax'); 	                            $payroll_partners_tax_mode_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$payroll_partners_tax_mode_options[$option->payroll_transaction_mode_id] = $option->payroll_transaction_mode;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[tax_mode]',$payroll_partners_tax_mode_options, $record['payroll_partners.tax_mode'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Amount</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners[tax_amount]" id="payroll_partners-tax_amount" value="{{ $record['payroll_partners.tax_amount'] }}" placeholder="Enter Amount" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Week</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_partners_tax_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_partners_tax_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[tax_week][]',$payroll_partners_tax_week_options, explode(',', $record['payroll_partners.tax_week']), 'class="form-control select2me" data-placeholder="Select..." multiple="multiple" id="payroll_partners-tax_week"') }}
	                        </div> 				</div>	
			</div>		</div>
</div>