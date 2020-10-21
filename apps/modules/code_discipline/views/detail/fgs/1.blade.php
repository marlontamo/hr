<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offenses</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Offense Category</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_offense[offense_category_id]" id="partners_offense-offense_category_id" value="{{ $record['partners_offense.offense_category_id'] }}" placeholder="Enter Offense Category" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Offense Level</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners_offense[offense_level_id]" id="partners_offense-offense_level_id" value="{{ $record['partners_offense.offense_level_id'] }}" placeholder="Enter Offense Level" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Offense</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_offense[offense]" id="partners_offense-offense" placeholder="Enter Offense" rows="4">{{ $record['partners_offense.offense'] }}</textarea> 				</div>	
			</div>	</div>
</div>