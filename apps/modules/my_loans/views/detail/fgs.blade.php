<div id="personal_request" class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ $record['description'] }} <small class="text-muted">payment view</small></div>
	</div>
    <div class="portlet-body form" id="main_form">
    	<form class="form-horizontal" name="change-request-form">
	    	<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
	    	<!-- BEGIN FORM-->
	        <div class="form-body">
		    		<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Loan :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['description'] }}</span>
								</div>
							</div>
						</div>
					</div>
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Entry Date :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ date('F d, Y', strtotime($record['entry_date'])) }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Status :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['loan_status'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Loan Principal :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['lprincipal'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Interest :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['linterest'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Amount :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['lamount'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Last Payment Date :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ date('F d, Y', strtotime($record['last_payment_date'])) }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">Total Amount Paid :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record['lamount_paid'] }}</span>
								</div>
							</div>
						</div>
					</div>	
					<div class="portlet">
						<div class="portlet-title margin-top-25">
							<div class="caption">Payments</div>
							<div class="tools">
								<a class="collapse" href="javascript:;"></a>
							</div>
						</div>
						<p class="margin-bottom-25">This section shows the list of payment made.</p>	
						<div class="portlet-body form">
			    			<table class="table table-condensed table-striped table-hover" >
								<thead>
									<tr>
										<th width="30%" class="padding-top-bottom-10" >Payment Date</th>
										<th width="25%" class="padding-top-bottom-10" >Principal</th>
										<th width="20%" class="padding-top-bottom-10" >Interest</th>
										<th width="25%" class="padding-top-bottom-10" >Total</th>
									</tr>
								</thead>
								<tbody>
									@if(count($payments) > 0)
										@foreach($payments as $payment)
											<tr>
												<td>
													<span class="text-success"> 
														{{ date('F d, Y', strtotime($payment['date_paid'])) }}
													</span>
													<br>
													<span class="text-muted small"> 
														{{ date('l', strtotime($payment['date_paid'])) }}
													</span>
												</td> 
												<td>
													<span class="text-info"> 
														{{ $payment['principal'] }}
													</span>
												</td> 
												<td>
													<span class="text-info"> 
														{{ $payment['interest'] }}
													</span>
												</td> 
												<td>
													<span class="text-info"> 
														{{ $payment['principal'] + $payment['interest'] }}
													</span>
												</td> 
											</tr>
										@endforeach
									@endif
								</tbody>
			    			</table>
			    		</div>
		    		</div>
	        </div>
	        <!-- END FORM--> 
	    </form>
    </div>
</div>
