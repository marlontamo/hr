<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('formsdownload_admin.dl_forms') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('formsdownload_admin.title') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="resources_downloadable[title]" id="resources_downloadable-title" value="{{ $record['resources_downloadable.title'] }}" placeholder="Enter Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('formsdownload_admin.category') }}</label>
				<div class="col-md-7"><?php									                            		$db->select('category,category');
	                            			                            		$db->order_by('category', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('resources_category'); 	                            $resources_downloadable_category_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$resources_downloadable_category_options[$option->category] = $option->category;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('resources_downloadable[category]',$resources_downloadable_category_options, $record['resources_downloadable.category'], 'class="form-control select2me" data-placeholder="Select..." id="resources_downloadable-category"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('formsdownload_admin.description') }}</label>
				<div class="col-md-7">							<textarea class="form-control" name="resources_downloadable[description]" id="resources_downloadable-description" placeholder="Enter Description" rows="4">{{ $record['resources_downloadable.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('formsdownload_admin.attachments') }}</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="resources_downloadable-attachments-container">
								@if( !empty($record['resources_downloadable.attachments']) )
									<?php 
										$file = FCPATH . urldecode( $record['resources_downloadable.attachments'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="resources_downloadable[attachments]" id="resources_downloadable-attachments" value="{{ $record['resources_downloadable.attachments'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('formsdownload_admin.select_file') }}</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" id="resources_downloadable-attachments-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
								</div>
							</div> 				</div>	
			</div>	</div>
</div>