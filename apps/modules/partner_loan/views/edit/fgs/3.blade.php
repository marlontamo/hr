<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Payments</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Last Payment Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="payroll_partners_loan[last_payment_date]" id="payroll_partners_loan-last_payment_date" value="{{ $record['payroll_partners_loan.last_payment_date'] }}" placeholder="Enter Last Payment Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Total Amount Paid</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[total_amount_paid]" id="payroll_partners_loan-total_amount_paid" value="{{ $record['payroll_partners_loan.total_amount_paid'] }}" placeholder="Enter Total Amount Paid" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Total No. of Payments</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[no_payments_paid]" id="payroll_partners_loan-no_payments_paid" value="{{ $record['payroll_partners_loan.no_payments_paid'] }}" placeholder="Enter Total No. of Payments" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Total Arrears</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="payroll_partners_loan[total_arrears]" id="payroll_partners_loan-total_arrears" value="{{ $record['payroll_partners_loan.total_arrears'] }}" placeholder="Enter Total Arrears" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>	</div>
</div>