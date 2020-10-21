<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Training Cost</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			

			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Cost</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="training_cost[cost]" id="training_cost-cost" value="{{ $record['training_cost.cost'] }}" placeholder="Enter Cost" /> 				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							
					<textarea class="form-control" name="training_cost[description]" id="training_cost-description" placeholder="Enter Description" rows="4">{{ $record['training_cost.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>