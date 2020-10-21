<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Outgoing Emails
			<span class="text-muted small">{{ lang('common.info') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<!-- <p>Outgoing Email</p> -->
	<div class="portlet-body form">
		<div class="form-group">
				<label class="control-label col-md-3">Time In</label>
				<div class="col-md-7">							
					<div class="input-group date  " disabled>                                       
						<input type="text" size="16" disabled class="form-control" name="system_email_queue[timein]" id="system_email_queue-timein" value="{{ $record['system_email_queue.timein'] }}" />
						<span class="input-group-btn">
							<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div> 				
				</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">To</label>
			<div class="col-md-7">							
				<input type="text" disabled class="form-control" name="system_email_queue[to]" id="" value="{{ $record['system_email_queue.to'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Cc</label>
			<div class="col-md-7">
				<input type="text" disabled class="form-control" name="system_email_queue[cc]" id="system_email_queue-cc" value="{{ $record['system_email_queue.cc'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Bcc</label>
			<div class="col-md-7">
				<input type="text" disabled class="form-control" name="system_email_queue[bcc]" id="system_email_queue-bcc" value="{{ $record['system_email_queue.bcc'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Subject</label>
			<div class="col-md-7">
				<input type="text" disabled class="form-control" name="system_email_queue[subject]" id="system_email_queue-subject" value="{{ $record['system_email_queue.subject'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Body</label>
			<div class="col-md-7">
				<textarea disabled class="form-control" name="system_email_queue[body]" id="system_email_queue-body"  rows="6">{{ $record['system_email_queue.body'] }}</textarea>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Status</label>
			<div class="col-md-7">
				<input type="text" disabled class="form-control" name="system_email_queue[status]" id="system_email_queue-status" value="{{ ucwords($record['system_email_queue.status']) }}" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Sent On</label>
			<div class="col-md-7">
				<div class="input-group date ">                                       
					<input type="text" size="16" disabled class="form-control" name="system_email_queue[sent_on]" id="system_email_queue-sent_on" value="{{ ($record['system_email_queue.sent_on'] == '0000-00-00 00:00:00') ? '' : $record['system_email_queue.sent_on'] }}"  />
					<span class="input-group-btn">
						<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>	
		</div>	
	</div>
</div>