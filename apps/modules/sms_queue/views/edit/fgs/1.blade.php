<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Email</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Outgoing Email</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Time In</label>
				<div class="col-md-7">							<div class="input-group date form_datetime">                                       
								<input type="text" size="16" readonly class="form-control" name="system_email_queue[timein]" id="system_email_queue-timein" value="{{ $record['system_email_queue.timein'] }}" />
								<span class="input-group-btn">
									<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
								</span>
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">To</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="system_email_queue[to]" id="system_email_queue-to" value="{{ $record['system_email_queue.to'] }}" placeholder="Enter To" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Cc</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="system_email_queue[cc]" id="system_email_queue-cc" value="{{ $record['system_email_queue.cc'] }}" placeholder="Enter Cc" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Bcc</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="system_email_queue[bcc]" id="system_email_queue-bcc" value="{{ $record['system_email_queue.bcc'] }}" placeholder="Enter Bcc" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Subject</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="system_email_queue[subject]" id="system_email_queue-subject" value="{{ $record['system_email_queue.subject'] }}" placeholder="Enter Subject" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Body</label>
				<div class="col-md-7">							<textarea class="form-control" name="system_email_queue[body]" id="system_email_queue-body" placeholder="Enter Body" rows="4">{{ $record['system_email_queue.body'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="system_email_queue[status]" id="system_email_queue-status" value="{{ $record['system_email_queue.status'] }}" placeholder="Enter Status" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Sent On</label>
				<div class="col-md-7">							<div class="input-group date form_datetime">                                       
								<input type="text" size="16" readonly class="form-control" name="system_email_queue[sent_on]" id="system_email_queue-sent_on" value="{{ $record['system_email_queue.sent_on'] }}" />
								<span class="input-group-btn">
									<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
								</span>
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>