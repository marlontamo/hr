<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Report</label>
				<div class="col-md-7"><?php									                            		$db->select('report_id,report_name');
	                            			                            		$db->order_by('report_name', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('report_generator'); 	                            $report_results_report_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$report_results_report_id_options[$option->report_id] = $option->report_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('report_results[report_id]',$report_results_report_id_options, $record['report_results.report_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>File Type</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="report_results[file_type]" id="report_results-file_type" value="{{ $record['report_results.file_type'] }}" placeholder="Enter File Type" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Path</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="report_results[filepath]" id="report_results-filepath" value="{{ $record['report_results.filepath'] }}" placeholder="Enter Path" /> 				</div>	
			</div>	</div>
</div>