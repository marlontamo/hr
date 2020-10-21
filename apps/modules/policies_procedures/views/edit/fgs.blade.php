<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('policies_procedures.pol_proc') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('policies_procedures.title') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="resources_policies[title]" id="resources_policies-title" value="{{ $record['resources_policies.title'] }}" placeholder="Enter Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('policies_procedures.category') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('category,category');
	                            			                            		$db->order_by('category', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('resources_category'); 	                            $resources_policies_category_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$resources_policies_category_options[$option->category] = $option->category;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('resources_policies[category]',$resources_policies_category_options, $record['resources_policies.category'], 'class="form-control select2me" data-placeholder="Select..." id="resources_policies-category"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('policies_procedures.description') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="resources_policies[description]" id="resources_policies-description" placeholder="Enter Description" rows="4">{{ $record['resources_policies.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('policies_procedures.attachments') }}</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="resources_policies-attachments-container">
								@if( !empty($record['resources_policies.attachments']) )
									<?php 
										$file = FCPATH . urldecode( $record['resources_policies.attachments'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="resources_policies[attachments]" id="resources_policies-attachments" value="{{ $record['resources_policies.attachments'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('policies_procedures.select_file') }}</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" id="resources_policies-attachments-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>