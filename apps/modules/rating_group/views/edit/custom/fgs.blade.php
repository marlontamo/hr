<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Rating Group</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>Rating Group
			</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="performance_setup_rating_group[rating_group]" id="performance_setup_rating_group-rating_group" value="{{ $record['performance_setup_rating_group.rating_group'] }}" placeholder="Enter Rating Group" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				Description
			</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="performance_setup_rating_group[description]" id="performance_setup_rating_group-description" value="{{ $record['performance_setup_rating_group.description'] }}" placeholder="Enter Description" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				Is Active
			</label>
			<div class="col-md-7">
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['performance_setup_rating_group.status_id'] ) checked="checked" @endif name="performance_setup_rating_group[status_id][temp]" id="performance_setup_rating_group-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="performance_setup_rating_group[status_id]" id="performance_setup_rating_group-status_id" value="@if( $record['performance_setup_rating_group.status_id'] ) 1 else 0 @endif"/>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Rating Score</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-group">
			<label class="control-label col-md-4">Rating Score</label>
			<div class="col-md-5">
				<div class="input-group">
					<input type="text" class="form-control" maxlength="64" id="rating_score" name="rating_score" placeholder="Enter Score..">

					<span class="input-group-btn">
						<button type="button" class="btn btn-success" onclick="add_form('rating_score', 'score')"><i class="fa fa-plus"></i></button>
					</span>
				</div>
				<div class="help-block small">
					Enter Rating Score.
				</div>
				<!-- /input-group -->
			</div>
		</div>
		<div class="portlet margin-top-25">
			<div class="portlet-body" >
				<!-- Table -->
				<table class="table table-condensed table-striped table-hover" >
					<thead>
						<tr>
							<th width="15%" class="padding-top-bottom-10" >Rating</th>
							<th width="20%" class="padding-top-bottom-10" >Score</th>
							<th width="35%" class="padding-top-bottom-10" >Description</th>
							<th width="15%" class="padding-top-bottom-10" >Is Active</th>
							<th width="12%" class="padding-top-bottom-10" >Action</th>
						</tr>
					</thead>
					<tbody id="score" class="rating_score">
						@if(is_array($rating_scores))
							@foreach($rating_scores as $index => $value)
							<tr>
								<td>
									<input type="hidden" class="form-control" maxlength="64" value="{{$value['rating_score_id']}}" name="performance_setup_rating_score[rating_score_id][]" id="performance_setup_rating_score-rating_score_id">
									<input type="text" class="form-control" maxlength="64" value="{{$value['rating_score']}}" name="performance_setup_rating_score[rating_score][]" id="performance_setup_rating_score-rating_score">
								</td>
								<td>
									<input type="text" class="form-control" maxlength="64" value="{{$value['score']}}" name="performance_setup_rating_score[score][]" id="performance_setup_rating_score-score">
								</td>
								<td>
									<input type="text" class="form-control" maxlength="64" value="{{$value['description']}}" name="performance_setup_rating_score[description][]" id="performance_setup_rating_score-description">
								</td>
								<td>
									<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
										<input type="checkbox" value="1" @if( $value['status_id'] ) checked="checked" @endif name="performance_setup_rating_score[status_id][temp][]" id="performance_setup_rating_score-status_id-temp" class="dontserializeme toggle score_stat"/>
										<input type="hidden" name="performance_setup_rating_score[status_id][]" id="performance_setup_rating_score-status_id" value="@if( $value['status_id'] ) 1 else 0 @endif" class="score_status_id"/>
									</div>
									<!-- <select  class="form-control select2me input-sm" data-placeholder="Select..." name="performance_setup_rating_score[status_id][]" id="performance_setup_rating_score-status_id">
										<option value="1" @if($value['status_id'] == 1) {{"selected"}} @endif>Yes</option>
										<option value="0" @if($value['status_id'] == 0) {{"selected"}} @endif>No</option>
									</select> -->
								</td>
								<td>
									<a class="btn btn-xs text-muted delete_row" data-record-id="{{$value['rating_score_id']}}" ><i class="fa fa-trash-o"></i> Delete</a>
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>

	</div>
</div>