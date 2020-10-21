<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Career Steam Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Job Class</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_class[job_class]" id="users_job_class-job_class" value="{{ $record['users_job_class.job_class'] }}" placeholder="Enter Job Class" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Job Class Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_class[job_class_code]" id="users_job_class-job_class_code" value="{{ $record['users_job_class.job_class_code'] }}" placeholder="Enter Job Class Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_job_class.status_id'] ) checked="checked" @endif name="users_job_class[status_id][temp]" id="users_job_class-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_job_class[status_id]" id="users_job_class-status_id" value="<?php echo $record['users_job_class.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>