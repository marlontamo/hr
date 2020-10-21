<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Offense Level Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('offense_level.offense_level') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="partners_offense_level[offense_level]" id="partners_offense_sanction-sanction" placeholder="{{ lang('offense_level.offense_level') }}" rows="4">{{ $record['partners_offense_level.offense_level'] }}</textarea> 				
			</div>	
		</div>				
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('offense_level.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="partners_offense_level[description]" id="partners_offense_sanction-sanction" placeholder="{{ lang('offense_level.description') }}" rows="4">{{ $record['partners_offense_level.description'] }}</textarea> 				
			</div>	
		</div>				
		</div>
</div>