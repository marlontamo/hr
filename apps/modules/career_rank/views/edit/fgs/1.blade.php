<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Career Rank Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Career Rank</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_rank[job_rank]" id="users_job_rank-job_rank" value="{{ $record['users_job_rank.job_rank'] }}" placeholder="Enter Career Rank" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Career Rank Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_rank[job_rank_code]" id="users_job_rank-job_rank_code" value="{{ $record['users_job_rank.job_rank_code'] }}" placeholder="Enter Career Rank Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_job_rank.status_id'] ) checked="checked" @endif name="users_job_rank[status_id][temp]" id="users_job_rank-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_job_rank[status_id]" id="users_job_rank-status_id" value="<?php echo $record['users_job_rank.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>