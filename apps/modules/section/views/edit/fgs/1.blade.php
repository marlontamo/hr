<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('section.section_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('section.section') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_section[section]" id="users_section-section" value="{{ $record['users_section.section'] }}" placeholder="{{ lang('section.p_section') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('section.section_code') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_section[section_code]" id="users_section-section_code" value="{{ $record['users_section.section_code'] }}" placeholder="Enter Section Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('section.active') }}</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;{{ lang('section.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('section.option_no') }}&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_section.status_id'] ) checked="checked" @endif name="users_section[status_id][temp]" id="users_section-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_section[status_id]" id="users_section-status_id" value="<?php echo $record['users_section.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>