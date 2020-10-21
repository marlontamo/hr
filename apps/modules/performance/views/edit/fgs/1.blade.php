<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Performance</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Performance</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_setup_performance[performance]" id="performance_setup_performance-performance" value="{{ $record['performance_setup_performance.performance'] }}" placeholder="Enter Performance" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Performance Group</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_setup_performance[performance_group]" id="performance_setup_performance-performance_group" value="{{ $record['performance_setup_performance.performance_group'] }}" placeholder="Enter Performance Group" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="performance_setup_performance[description]" id="performance_setup_performance-description" value="{{ $record['performance_setup_performance.description'] }}" placeholder="Enter Description" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Is Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['performance_setup_performance.status_id'] ) checked="checked" @endif name="performance_setup_performance[status_id][temp]" id="performance_setup_performance-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="performance_setup_performance[status_id]" id="performance_setup_performance-status_id" value="@if( $record['performance_setup_performance.status_id'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>	</div>
</div>