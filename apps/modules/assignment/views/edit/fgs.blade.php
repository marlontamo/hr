<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('assignment.assignment_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('assignment.assignment') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_assignment[assignment]" id="users_assignment-assignment" value="{{ $record['users_assignment.assignment'] }}" placeholder="{{ lang('assignment.p_assignment') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('assignment.assignment_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_assignment[assignment_code]" id="users_assignment-assignment_code" value="{{ $record['users_assignment.assignment_code'] }}" placeholder="{{ lang('assignment.p_assignment_code') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('assignment.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('assignment.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('assignment.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_assignment.status_id'] ) checked="checked" @endif name="users_assignment[status_id][temp]" id="users_assignment-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_assignment[status_id]" id="users_assignment-status_id" value="<?php echo $record['users_assignment.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>