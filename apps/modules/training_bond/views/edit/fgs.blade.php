<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Bond Schedule</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Cost From</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_bond[cost_from]" id="training_bond-cost_from" value="{{ $record['training_bond.cost_from'] }}" placeholder="Enter Cost From" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/>	
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Cost To</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_bond[cost_to]" id="training_bond-cost_to" value="{{ $record['training_bond.cost_to'] }}" placeholder="Enter Cost To" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 	
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>RLS in days</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_bond[rls_days]" id="training_bond-rls_days" value="{{ $record['training_bond.rls_days'] }}" placeholder="Enter RLS in days" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/>	
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3">RLS in months</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="training_bond[rls_months]" id="training_bond-rls_months" value="{{ $record['training_bond.rls_months'] }}" placeholder="Enter RLS in months" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				
			</div>	
		</div>			
		
	</div>
</div>