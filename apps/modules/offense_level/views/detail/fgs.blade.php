<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offense Level Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="col-md-3 col-sm-3 text-right text-muted">{{ lang('offense_level.offense_level') }}:</label>
			<div class="col-md-7 col-sm-7">
				{{ $record['partners_offense_level_offense_level'] }}		
			</div>	
		</div>				
		<div class="form-group">
			<label class="col-md-3 col-sm-3 text-right text-muted">{{ lang('offense_level.description') }}:</label>
			<div class="col-md-7 col-sm-7">							
				{{ $record['partners_offense_level_description'] }}				
			</div>	
		</div>	
	</div>			
</div>