<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('specialization.specialization_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">	
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('specialization.specialization') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_specialization[specialization]" id="users_specialization-specialization" value="{{ $record['users_specialization.specialization'] }}" placeholder="{{ lang('specialization.p_specialization') }}" />
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('specialization.specialization_code') }}</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="users_specialization[specialization_code]" id="users_specialization-specialization_code" value="{{ $record['users_specialization.specialization_code'] }}" placeholder="{{ lang('specialization.p_specialization_code') }}" />
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('specialization.active') }}</label>
				<div class="col-md-7">
					<div class="make-switch" data-on-label="&nbsp;{{ lang('specialization.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('specialization.option_no') }}&nbsp;">
						<input type="checkbox" value="1" @if( $record['users_specialization.status_id'] ) checked="checked" @endif name="users_specialization[status_id][temp]" id="users_specialization-status_id-temp" class="dontserializeme toggle"/>
						<input type="hidden" name="users_specialization[status_id]" id="users_specialization-status_id" value="<?php echo $record['users_specialization.status_id'] ? 1 : 0 ?>"/>
					</div>
				</div>	
			</div>
		</div>
</div>