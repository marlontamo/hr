<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('employment_type.employment_type_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('employment_type.employment_type') }}</label>
				<div class="col-md-7">							
					<input type="text" disabled="disabled" class="form-control" name="partners_employment_type[employment_type]" id="partners_employment_type-employment_type" value="{{ $record['partners_employment_type.employment_type'] }}" placeholder="{{ lang('employment_type.p_employment_type') }}" /> 				
				</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('employment_type.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('employment_type.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('employment_type.option_no') }}&nbsp;">
			    	<input type="checkbox" disabled="disabled" value="1" @if( $record['partners_employment_type.active'] ) checked="checked" @endif name="partners_employment_type[active][temp]" id="partners_employment_type-active-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" disabled="disabled" name="partners_employment_type[active]" id="partners_employment_type-active" value="@if( $record['partners_employment_type.active'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>
	</div>
</div>