<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Annual Manpower Planning</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Year</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="recruitment_manpower_plan[year]" id="recruitment_manpower_plan-year" value="{{ $record['recruitment_manpower_plan.year'] }}" placeholder="Enter Year" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Company</label>
				<div class="col-md-7"><?php									                            		$db->select('company_id,company');
	                            			                            		$db->order_by('company', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_company'); 	                            $recruitment_manpower_plan_company_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$recruitment_manpower_plan_company_id_options[$option->company_id] = $option->company;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('recruitment_manpower_plan[company_id]',$recruitment_manpower_plan_company_id_options, $record['recruitment_manpower_plan.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_manpower_plan-company_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Department </label>
				<div class="col-md-7"><?php									                            		$db->select('department_id,department');
	                            			                            		$db->order_by('department', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('users_department'); 	                            $recruitment_manpower_plan_department_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$recruitment_manpower_plan_department_id_options[$option->department_id] = $option->department;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('recruitment_manpower_plan[department_id]',$recruitment_manpower_plan_department_id_options, $record['recruitment_manpower_plan.department_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_manpower_plan-department_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Department Head</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="recruitment_manpower_plan[departmenthead]" id="recruitment_manpower_plan-departmenthead" value="{{ $record['recruitment_manpower_plan.departmenthead'] }}" placeholder="Enter Department Head" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Created By</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="recruitment_manpower_plan[created_by]" id="recruitment_manpower_plan-created_by" value="{{ $record['recruitment_manpower_plan.created_by'] }}" placeholder="Enter Created By" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachments</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="recruitment_manpower_plan-attachment-container">
                                <input type="hidden" name="recruitment_manpower_plan[attachment]" id="recruitment_manpower_plan-attachment" value="{{ $record['recruitment_manpower_plan.attachment'] }}"/>
                                <span class="btn default btn-sm btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse</span>
                                <input type="file" id="recruitment_manpower_plan-attachment-fileupload" type="file" name="files[]" multiple="">
                                </span>
                                <ul class="padding-none margin-top-10">
                                @if( !empty($record['recruitment_manpower_plan.attachment']) )
									<?php 
										$upload_ids = explode( ',', $record['recruitment_manpower_plan.attachment'] );
										foreach( $upload_ids as $upload_id )
										{
											$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id))->row();
											$file = FCPATH . urldecode( $upload->upload_path );
											if( file_exists( $file ) )
											{
												$f_info = get_file_info( $file );
												$f_type = filetype( $file );

/*												$finfo = finfo_open(FILEINFO_MIME_TYPE);
												$f_type = finfo_file($finfo, $file);*/

												switch( $f_type )
												{
													case 'image/jpeg':
														$icon = 'fa-picture-o';
														break;
													case 'video/mp4':
														$icon = 'fa-film';
														break;
													case 'audio/mpeg':
														$icon = 'fa-volume-up';
														break;
													default:
														$icon = 'fa-file-text-o';
												}
												echo '<li class="padding-3 fileupload-delete-'.$upload_id.'" style="list-style:none;">
										            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
										            <span>'. basename($f_info['name']) .'</span>
										            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id.'" href="javascript:void(0)"></a></span>
										        </li>';
											}
										}
									?>								@endif
                                </ul>
                            </div> 				</div>	
			</div>	</div>
</div>