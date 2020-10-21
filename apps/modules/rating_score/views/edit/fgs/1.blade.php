<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Rating Score</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Rating Score</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rating Group</label>
				<div class="col-md-7"><?php									                            		$db->select('rating_group_id,rating_group');
	                            			                            		$db->order_by('rating_group', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('performance_setup_rating_group'); 	                            $performance_setup_rating_score_rating_group_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$performance_setup_rating_score_rating_group_id_options[$option->rating_group_id] = $option->rating_group;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('performance_setup_rating_score[rating_group_id]',$performance_setup_rating_score_rating_group_id_options, $record['performance_setup_rating_score.rating_group_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rating Score</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_setup_rating_score[rating_score]" id="performance_setup_rating_score-rating_score" value="{{ $record['performance_setup_rating_score.rating_score'] }}" placeholder="Enter Rating Score" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_setup_rating_score[description]" id="performance_setup_rating_score-description" value="{{ $record['performance_setup_rating_score.description'] }}" placeholder="Enter Description" /> 				</div>	
			</div>	</div>
</div>