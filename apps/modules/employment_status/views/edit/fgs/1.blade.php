<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('employment_status.employment_status') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('employment_status.employment_status') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="partners_employment_status[employment_status]" id="partners_employment_status-employment_status" value="{{ $record['partners_employment_status.employment_status'] }}" placeholder="Enter Employment Status"/> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('employment_status.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('employment_status.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('employment_status.option_no') }}&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['partners_employment_status.active'] ) checked="checked" @endif name="partners_employment_status[active][temp]" id="partners_employment_status-active-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="partners_employment_status[active]" id="partners_employment_status-active" value="@if( $record['partners_employment_status.active'] ) 1 else 0 @endif"/>
				</div> 				
			</div>	
		</div>	
	</div>
</div>