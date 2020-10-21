<div class="portlet">
	<div class="portlet-title">
		<div class="caption"> Other Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>This section contains the finding, diagnosis and recommendation.</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Findings</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_health_records[findings]" id="partners_health_records-findings" placeholder="Enter Findings" rows="4">{{ $record['partners_health_records.findings'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Diagnosis</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_health_records[diagnosis]" id="partners_health_records-diagnosis" placeholder="Enter Diagnosis" rows="4">{{ $record['partners_health_records.diagnosis'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Recommendations</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_health_records[recommendation]" id="partners_health_records-recommendation" placeholder="Enter Recommendations" rows="4">{{ $record['partners_health_records.recommendation'] }}</textarea> 				</div>	
			</div>	</div>
</div>