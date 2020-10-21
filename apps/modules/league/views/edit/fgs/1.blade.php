<div class="portlet">
	<div class="portlet-title">
		<div class="caption">League</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_league[league_code]" id="play_league-league_code" value="{{ $record['play_league.league_code'] }}" placeholder="Enter Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_league[league]" id="play_league-league" value="{{ $record['play_league.league'] }}" placeholder="Enter Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="play_league[description]" id="play_league-description" placeholder="Enter Description" rows="4">{{ $record['play_league.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>