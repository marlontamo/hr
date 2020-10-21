<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('code_discipline.offenses') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('code_discipline.offense_category') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="partners_offense[offense_category_id]" id="partners_offense-offense_category_id" value="{{ $record['partners_offense.offense_category'] }}" placeholder="{{ lang('code_discipline.p_offense_category') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('code_discipline.offense_level') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="partners_offense[offense_level_id]" id="partners_offense-offense_level_id" value="{{ $record['partners_offense.sanction'] }}" placeholder="{{ lang('code_discipline.p_offense_level') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('code_discipline.offense') }}</label>
				<div class="col-md-7">							<textarea class="form-control" disabled="disabled" name="partners_offense[offense]" id="partners_offense-offense" placeholder="{{ lang('code_discipline.p_offense') }}" rows="4">{{ $record['partners_offense.offense'] }}</textarea> 				</div>	
			</div>	</div>
</div>