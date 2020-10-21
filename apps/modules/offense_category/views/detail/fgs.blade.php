<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offense Category Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="col-md-3 col-sm-3 text-right text-muted">{{ lang('offense_category.offense_category') }}:</label>
			<div class="col-md-7 col-sm-7">
				{{ $record['partners_offense_category_offense_category'] }}		
			</div>	
		</div>				
		<div class="form-group">
			<label class="col-md-3 col-sm-3 text-right text-muted">{{ lang('offense_category.description') }}:</label>
			<div class="col-md-7 col-sm-7">							
				{{ $record['partners_offense_category_description'] }}				
			</div>	
		</div>	
	</div>			
</div>