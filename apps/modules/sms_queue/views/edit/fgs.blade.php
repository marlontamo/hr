<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Outgoing SMS</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<!-- <p>Outgoing Email</p> -->
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Time In</label>
				<div class="col-md-7">							<div class="input-group date form_datetime " disabled>                                       
								<input type="text" size="16" disabled class="form-control" name="system_sms_queue[timein]" id="system_sms_queue-timein" value="{{ $record['system_sms_queue.timein'] }}" />
								<span class="input-group-btn">
									<button class="btn default " type="button"><i class="fa fa-times"></i></button>
								</span>
								<span class="input-group-btn">
									<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">To</label>
				<div class="col-md-7">							<input type="text" disabled class="form-control" name="system_sms_queue[to]" id="system_sms_queue-to" value="{{ $record['system_sms_queue.to'] }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Cc</label>
				<div class="col-md-7">							<input type="text" disabled class="form-control" name="system_sms_queue[cc]" id="system_sms_queue-cc" value="{{ $record['system_sms_queue.cc'] }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Bcc</label>
				<div class="col-md-7">							<input type="text" disabled class="form-control" name="system_sms_queue[bcc]" id="system_sms_queue-bcc" value="{{ $record['system_sms_queue.bcc'] }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Subject</label>
				<div class="col-md-7">							<input type="text" disabled class="form-control" name="system_sms_queue[subject]" id="system_sms_queue-subject" value="{{ $record['system_sms_queue.subject'] }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Body</label>
				<div class="col-md-7">							<textarea disabled class="form-control" name="system_sms_queue[body]" id="system_sms_queue-body"  rows="6">{{ $record['system_sms_queue.body'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" disabled class="form-control" name="system_sms_queue[status]" id="system_sms_queue-status" value="{{ $record['system_sms_queue.status'] }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Sent On</label>
				<div class="col-md-7">							<div class="input-group date ">                                       
								<input type="text" size="16" disabled class="form-control" name="system_sms_queue[sent_on]" id="system_sms_queue-sent_on" value="{{ $record['system_sms_queue.sent_on'] }}" />
								<span class="input-group-btn">
									<button class="btn default " type="button"><i class="fa fa-times"></i></button>
								</span>
								<span class="input-group-btn">
									<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>