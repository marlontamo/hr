<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Outgoing Email</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<!-- <p>Outgoing Email</p> -->
	<div class="portlet-body form">
		<div class="form-group">
				<label class="control-label col-md-3">Time In</label>
				<div class="col-md-7">							
					<div class="input-group date" >                                       
						<input type="text" size="16" class="form-control form_datetime" name="system_email_queue[timein]" id="system_email_queue-timein" value="{{ $record['system_email_queue.timein'] }}" />
						<span class="input-group-btn">
							<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div> 				
				</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">To <span class="required">* </span></label>
			<div class="col-md-7">							
				<?php 
					$db->select('email, full_name');
					$db->where('deleted',0);
					$db->where('email <>', '');
					$options = $db->get('users')->result_array();
	                //$options = array('queued' => 'Queued', 'sending' => 'Sending', 'sent' => 'Sent' );
	                $selected = explode(',', $record['system_email_queue.to']);
	                //$system_email_queue_to_options = array('' => 'Select...');
                    foreach($options as $key => $option)
                    {
                    	$system_email_queue_to_options[$option['email']] = $option['full_name'];
                    }
                ?>
                {{ form_dropdown('system_email_queue[to][]', $system_email_queue_to_options, $selected, 'class="form-control select2me" multiple data-placeholder="Select..." id="system_email_queue-to"') }}

				<!-- <input type="text" class="form-control" name="system_email_queue[to]" id="system_email_queue-to" value="{{ $record['system_email_queue.to'] }}" /> -->
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Cc</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="system_email_queue[cc]" id="system_email_queue-cc" value="{{ $record['system_email_queue.cc'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Bcc</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="system_email_queue[bcc]" id="system_email_queue-bcc" value="{{ $record['system_email_queue.bcc'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Subject</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="system_email_queue[subject]" id="system_email_queue-subject" value="{{ $record['system_email_queue.subject'] }}" />
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Body</label>
			<div class="col-md-7">
				<div class="help-block text-muted small">Kindly use the text editor below in formatting the content of your email body.</div>
				<textarea class="wysihtml5 form-control" name="system_email_queue[body]" id="system_email_queue-body"  rows="20">{{ $record['system_email_queue.body'] }}</textarea>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Status</label>
			<div class="col-md-7">
				<?php 

	                $options = array('queued' => 'Queued', 'sending' => 'Sending', 'sent' => 'Sent' );
	                $email_status_id_options = array('' => 'Select...');
                    foreach($options as $key => $option)
                    {
                    	$email_status_id_options[$key] = $option;
                    }
                ?>
                <div class="input-group">
					<span class="input-group-addon">
	                	<i class="fa fa-list-ul"></i>
	                </span>
	                {{ form_dropdown('system_email_queue[status]',$email_status_id_options, $record['system_email_queue.status'], 'class="form-control select2me" data-placeholder="Select..."') }}
	            </div>
	        </div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Sent On</label>
			<div class="col-md-7">
				<div class="input-group date ">                                       
					<input type="text" size="16" class="form-control" readonly="readonly" name="system_email_queue[sent_on]" id="system_email_queue-sent_on" value="{{ ($record['system_email_queue.sent_on'] == '0000-00-00 00:00:00') ? '' : $record['system_email_queue.sent_on'] }}" />
					<span class="input-group-btn">
						<button class="btn default " type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>	
		</div>	
	</div>
</div>