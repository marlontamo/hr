<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('job_grade.job_grade_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('job_grade.job_grade') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_grade_level[job_level]" id="users_job_grade_level-job_level" value="{{ $record['users_job_grade_level.job_level'] }}" placeholder="{{ lang('job_grade.p_job_grade') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('job_grade.job_grade_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_grade_level[job_grade_code]" id="users_job_grade_level-job_grade_code" value="{{ $record['users_job_grade_level.job_grade_code'] }}" placeholder="{{ lang('job_grade.p_job_grade_code') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('job_grade.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('job_grade.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('job_grade.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_job_grade_level.status_id'] ) checked="checked" @endif name="users_job_grade_level[status_id][temp]" id="users_job_grade_level-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_job_grade_level[status_id]" id="users_job_grade_level-status_id" value="<?php echo $record['users_job_grade_level.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>