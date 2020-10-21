<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Traning Feedback Participants</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Total Score</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="training_feedback[total_score]" id="training_library-library" value="{{ $record['training_feedback.total_score'] }}" placeholder="Enter  Total Score" /> 
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Average Scor</label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="training_feedback[average_score]" id="training_library-library" value="{{ $record['training_feedback.average_score'] }}" placeholder="Enter Average Score" /> 
				</div>	
			</div>
	</div>
</div>