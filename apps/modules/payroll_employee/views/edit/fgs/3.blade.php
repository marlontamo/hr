<div class="portlet">
	<div class="portlet-title">
		<div class="caption">HDMF Setup </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
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
	                            {{ form_dropdown('payroll_partners[hdmf_week][]',$payroll_partners_hdmf_week_options, explode(',', $record['payroll_partners.hdmf_week']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="payroll_partners-hdmf_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>