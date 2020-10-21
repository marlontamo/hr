<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('career_stream.career_stream_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('career_stream.job_class') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_class[job_class]" id="users_job_class-job_class" value="{{ $record['users_job_class.job_class'] }}" placeholder="{{ lang('career_stream.p_job_class') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('career_stream.job_class_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_job_class[job_class_code]" id="users_job_class-job_class_code" value="{{ $record['users_job_class.job_class_code'] }}" placeholder="{{ lang('career_stream.p_job_class_code') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('career_stream.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('career_stream.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('career_stream.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_job_class.status_id'] ) checked="checked" @endif name="users_job_class[status_id][temp]" id="users_job_class-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_job_class[status_id]" id="users_job_class-status_id" value="<?php echo $record['users_job_class.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>