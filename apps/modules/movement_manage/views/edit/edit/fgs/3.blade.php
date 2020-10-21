<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Extension Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p>Movement Details</p>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>Months
			</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="partners_movement_action_extension[no_of_months]" id="partners_movement_action_extension-no_of_months" value="{{ $record['partners_movement_action_extension.no_of_months'] }}" placeholder="Enter Months" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>End Date
			</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="partners_movement_action_extension[end_date]" id="partners_movement_action_extension-end_date" value="{{ $record['partners_movement_action_extension.end_date'] }}" placeholder="Enter End Date" /> 				
			</div>	
		</div>	
	</div>
</div>