<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('offense_sanction.offense_sanction') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('offense_sanction.category') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="partners_offense_sanction[sanction_category_id]" id="partners_offense_sanction-sanction_category_id" value="{{ $record['partners_offense_sanction.sanction_category_id'] }}" placeholder="{{ lang('offense_sanction.p_category') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('offense_sanction.level') }}</label>
				<div class="col-md-7">							<input type="text" disabled="disabled" class="form-control" name="partners_offense_sanction[sanction_level_id]" id="partners_offense_sanction-sanction_level_id" value="{{ $record['partners_offense_sanction.sanction_level_id'] }}" placeholder="{{ lang('offense_sanction.p_level') }}" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('offense_sanction.sanction') }}</label>
				<div class="col-md-7">							<textarea class="form-control" disabled="disabled" name="partners_offense_sanction[sanction]" id="partners_offense_sanction-sanction" placeholder="{{ lang('offense_sanction.p_sanction') }}" rows="4">{{ $record['partners_offense_sanction.sanction'] }}</textarea> 				</div>	
			</div>	</div>
</div>