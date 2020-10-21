<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Level</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Level</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_level[level]" id="play_level-level" value="{{ $record['play_level.level'] }}" placeholder="Enter Level" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>League</label>
				<div class="col-md-7"><?php									                            		$db->select('league_id,league');
	                            			                            		$db->order_by('league', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('play_league'); 	                            $play_level_league_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$play_level_league_id_options[$option->league_id] = $option->league;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('play_level[league_id]',$play_level_league_id_options, $record['play_level.league_id'], 'class="form-control select2me" data-placeholder="Select..." id="play_level-league_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Points From</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_level[points_fr]" id="play_level-points_fr" value="{{ $record['play_level.points_fr'] }}" placeholder="Enter Points From" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Points To</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="play_level[points_to]" id="play_level-points_to" value="{{ $record['play_level.points_to'] }}" placeholder="Enter Points To" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="play_level[description]" id="play_level-description" placeholder="Enter Description" rows="4">{{ $record['play_level.description'] }}</textarea> 				</div>	
			</div>	</div>
</div>