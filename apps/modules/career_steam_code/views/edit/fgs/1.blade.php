<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Career Steam Code Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Career Steam Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_rank_code[job_rank_code]" id="users_job_rank_code-job_rank_code" value="{{ $record['users_job_rank_code.job_rank_code'] }}" placeholder="Enter Career Steam Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Career Steam Code Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_rank_code[job_rank_code_code]" id="users_job_rank_code-job_rank_code_code" value="{{ $record['users_job_rank_code.job_rank_code_code'] }}" placeholder="Enter Career Steam Code Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_job_rank_code.status_id'] ) checked="checked" @endif name="users_job_rank_code[status_id][temp]" id="users_job_rank_code-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_job_rank_code[status_id]" id="users_job_rank_code-status_id" value="<?php echo $record['users_job_rank_code.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>