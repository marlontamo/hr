<div class="portlet">
	<div class="portlet-title">
		<div class="caption">WHTAX Setup </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
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
	                            {{ form_dropdown('payroll_partners[tax_week][]',$payroll_partners_tax_week_options, explode(',', $record['payroll_partners.tax_week']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="payroll_partners-tax_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>