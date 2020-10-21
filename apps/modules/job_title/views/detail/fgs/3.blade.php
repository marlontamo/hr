<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('job_title.job_title_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('job_title.job_title') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_job_title[job_title]" id="users_job_title-job_title" value="{{ $record['users_job_title.job_title'] }}" placeholder="{{ lang('job_title.p_job_title') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('job_title.job_title_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_job_title[job_title_code]" id="users_job_title-job_title_code" value="{{ $record['users_job_title.job_title_code'] }}" placeholder="{{ lang('job_title.p_job_title_code') }}"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('job_title.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('job_title.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('job_title.option_no') }}&nbsp;">
			    	<input type="checkbox" disabled="disabled" value="1" @if( $record['users_job_title.status_id'] ) checked="checked" @endif name="users_job_title[status_id][temp]" id="users_job_title-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="users_job_title[status_id]" id="users_job_title-status_id" value="@if( $record['users_job_title.status_id'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>		
	</div>
</div>