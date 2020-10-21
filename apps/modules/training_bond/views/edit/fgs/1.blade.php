<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Bond Schedule</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Training Bond Schedule</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Cost From</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_bond[cost_from]" id="training_bond-cost_from" value="{{ $record['training_bond.cost_from'] }}" placeholder="Enter Cost From" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Cost To</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_bond[cost_to]" id="training_bond-cost_to" value="{{ $record['training_bond.cost_to'] }}" placeholder="Enter Cost To" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>RLS in months</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_bond[rls_months]" id="training_bond-rls_months" value="{{ $record['training_bond.rls_months'] }}" placeholder="Enter RLS in months" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>RLS in days</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="training_bond[rls_days]" id="training_bond-rls_days" value="{{ $record['training_bond.rls_days'] }}" placeholder="Enter RLS in days" /> 				</div>	
			</div>	</div>
</div>