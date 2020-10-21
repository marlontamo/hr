<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('competency_level.competency_level_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('competency_level.competency_level') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="users_competency_level[competency_level]" id="users_competency_level-competency_level" value="{{ $record['users_competency_level.competency_level'] }}" placeholder="{{ lang('competency_level.p_competency_level') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('competency_level.competency_level_code') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="users_competency_level[competency_level_code]" id="users_competency_level-competency_level_code" value="{{ $record['users_competency_level.competency_level_code'] }}" placeholder="{{ lang('competency_level.p_competency_level_code') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('competency_level.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('competency_level.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('competency_level.option_no') }}&nbsp;">
						    	<input type="checkbox" disabled="disabled" value="1" @if( $record['users_competency_level.status_id'] ) checked="checked" @endif name="users_competency_level[status_id][temp]" id="users_competency_level-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_competency_level[status_id]" id="users_competency_level-status_id" value="<?php echo $record['users_competency_level.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>