<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Report Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="report_query[report_title]" id="report_query-report_title" value="{{ $record['report_query.report_title'] }}" placeholder="Enter Report Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Report Query</label>
				<div class="col-md-7">							<textarea class="form-control" name="report_query[report_query]" id="report_query-report_query" placeholder="Enter Report Query" rows="4">{{ $record['report_query.report_query'] }}</textarea> 				</div>	
			</div>	</div>
</div>