<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offense Category Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('offense_category.offense_category') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="partners_offense_category[offense_category]" id="partners_offense_sanction-sanction" placeholder="{{ lang('offense_category.offense_category') }}" rows="4">{{ $record['partners_offense_category.offense_category'] }}</textarea> 				
			</div>	
		</div>				
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('offense_category.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="partners_offense_category[description]" id="partners_offense_sanction-sanction" placeholder="{{ lang('offense_category.description') }}" rows="4">{{ $record['partners_offense_category.description'] }}</textarea> 				
			</div>	
		</div>	
	</div>			
</div>