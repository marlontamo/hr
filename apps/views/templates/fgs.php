<div class="portlet">
	<div class="portlet-title">
		<div class="caption"><?php echo $fg['label']; ?></div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<?php if( !empty( $fg['description'] ) ):?>
		<p><?php echo $fg['description']?></p>
	<?php endif;?>
	<div class="portlet-body form"><?php
		foreach($fg['fields'] as $f_name){
			$field = $fields[$f_name];
			$name = $field['table'].'['.$field['column'].']';
			$varname = $field['table'].'_'.$field['column'];
			$id = $field['table'].'-'.$field['column']; 
			$rules = explode('|', $field['datatype']);
			$data_attr = array();
			if(in_array( 'integer', $rules ))
			{
				$data_attr[] = "data-inputmask=\"'alias': 'integer', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false\"";
			}	
			if( in_array( 'numeric', $rules ) )
			{
				$data_attr[] = "data-inputmask=\"'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false\"";
			}

			$data_attr = implode(' ', $data_attr);			
			?>
			<div class="form-group">
				<label class="control-label col-md-3"><?php if( in_array('required', $rules) ):?><span class="required">* </span><?php endif; echo $field['label']; ?></label>
				<div class="col-md-7"><?php
					switch( $field['uitype_id'] )
					{
						case 1: //textfield
							if( in_array('valid_email', $rules) ):?>
								<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>	
							<?php endif;?>
							<input type="text" class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" placeholder="Enter <?php echo $field['label']?>" <?php echo $data_attr?>/> <?php
							if( in_array('valid_email', $rules) ):?>
								</div>	
							<?php endif;
							break;
						case 2: //textarea?>
							<textarea class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" placeholder="Enter <?php echo $field['label']?>" rows="4">{{ $record['<?php echo $f_name?>'] }}</textarea> <?php
							break;
						case 3: //Yes/No?>
							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['<?php echo $f_name?>'] ) checked="checked" @endif name="<?php echo $name?>[temp]" id="<?php echo $id?>-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="<?php echo $name?>" id="<?php echo $id?>" value="<?php echo '<?php echo $record[\'';?><?php echo $f_name?><?php echo '\'] ? 1 : 0 ?>';?>"/>
							</div> <?php
							break;
						case 4: //Searchable Dropdowns
								echo '<?php'; ?>
								<?php switch($field['searchable']['type_id']):
	                            	case 1: ?>
	                            		$db->select('<?php echo $field['searchable']['value']?>,<?php echo $field['searchable']['label']?>');
	                            		<?php if( !empty($field['searchable']['group_by']) ):?>
	                            			$db->select('<?php echo $field['searchable']['group_by']?>');
	                            		<?php endif;?>
	                            		$db->order_by('<?php echo $field['searchable']['label']?>', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('<?php echo $field['searchable']['table']?>'); <?php
	                            		break;
	                            	case 2: ?>
	                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "<?php echo $field['searchable']['table']?>")); <?php
	                            		break;
	                            endswitch; ?>
	                            $<?php echo $varname?>_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			<?php if( !empty($field['searchable']['group_by']) ):?>
                        				$<?php echo $varname?>_options[$option-><?php echo $field['searchable']['group_by']?>][$option-><?php echo $field['searchable']['value']?>] = $option-><?php echo $field['searchable']['label']?>;
                        			<?php else:?>
                        				$<?php echo $varname?>_options[$option-><?php echo $field['searchable']['value']?>] = $option-><?php echo $field['searchable']['label']?>;
                        			<?php endif;?>
                        		} <?php
	                            echo '?>'; ?>
							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('<?php echo $name?>',$<?php echo $varname?>_options, $record['<?php echo $f_name?>'], 'class="form-control select2me" data-placeholder="Select..." id="<?php echo $id?>"') }}
	                        </div> <?php
							break;
						case 5: //WYSIWYG?>
							<textarea class="ckeditor form-control" name="<?php echo $name?>" id="<?php echo $id?>" placeholder="Enter <?php echo $field['label']?>" rows="4">{{ $record['<?php echo $f_name?>'] }}</textarea> <?php
							break;
						case 6: //datepicker?>
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" placeholder="Enter <?php echo $field['label']?>" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> <?php
							break;
						case 7: //password?>
							@if( $record_id )
								<button class="btn btn-info btn-sm" type="button" onclick="show_pass_field('<?php echo $id?>', $(this))">Change Password?</button>
                                <small class="help-block">Click button to change password.</small>
							@endif
							<div class="input-group margin-bottom-15 @if( $record_id ) hidden @endif">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="<?php echo $name?>" id="<?php echo $id?>" value="" placeholder="Enter <?php echo $field['label']?>"/>
							</div>
							<?php
								$name = $field['table'].'['.$field['column'].'-confirm]';
							?>
							<div class="input-group @if( $record_id ) hidden @endif">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control @if( $record_id ) dontserializeme @endif" name="<?php echo $name?>" id="<?php echo $id?>-confirm" value="" placeholder="Confirm <?php echo $field['label']?>"/>
							</div> <?php
							break;
						case 8: //Single Upload?>
							<div data-provides="fileupload" class="fileupload fileupload-new" id="<?php echo $id?>-container">
								@if( !empty($record['<?php echo $f_name?>']) )
									<?php echo '<?php'?> 
										$file = FCPATH . urldecode( $record['<?php echo $f_name?>'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									<?php echo '?>'?>
								@endif
								<input type="hidden" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" id="<?php echo $id?>-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>  {{ lang('common.remove') }}</a>
								</div>
							</div> <?php
							break;
						case 9: //multiple Upload?>
							<div data-provides="fileupload" class="fileupload fileupload-new" id="<?php echo $id?>-container">
                                <input type="hidden" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}"/>
                                <span class="btn default btn-sm btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Browse</span>
                                <input type="file" id="<?php echo $id?>-fileupload" type="file" name="files[]" multiple="">
                                </span>
                                <ul class="padding-none margin-top-10">
                                @if( !empty($record['<?php echo $f_name?>']) )
									<?php echo '<?php'?> 
										$upload_ids = explode( ',', $record['<?php echo $f_name?>'] );
										foreach( $upload_ids as $upload_id )
										{
											$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id))->row();
											$file = FCPATH . urldecode( $upload->upload_path );
											if( file_exists( $file ) )
											{
												$f_info = get_file_info( $file );
												$f_type = filetype( $file );

												$finfo = finfo_open(FILEINFO_MIME_TYPE);
												$f_type = finfo_file($finfo, $file);

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
									<?php echo '?>'?>
								@endif
                                </ul>
                            </div> <?php
							break;
						case 10: //Multiselect Checkbox
							$name .= '[]';
							echo '<?php'; ?>
                            <?php switch($field['searchable']['type_id']):
                            	case 1: ?>
                            		$db->select('<?php echo $field['searchable']['value']?>,<?php echo $field['searchable']['label']?>');
                            		<?php if( !empty($field['searchable']['group_by']) ):?>
                            			$db->select('<?php echo $field['searchable']['group_by']?>');
                            		<?php endif;?>
                            		$db->where('deleted', '0');
                            		$options = $db->get('<?php echo $field['searchable']['table']?>');
									$<?php echo $varname?>_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			<?php if( !empty($field['searchable']['group_by']) ):?>
                            				$<?php echo $varname?>_options['<?php echo $field['searchable']['group_by']?>']['<?php echo $field['searchable']['value']?>'] = '<?php echo $field['searchable']['label']?>';
                            			<?php else:?>
                            				$<?php echo $varname?>_options[$option-><?php echo $field['searchable']['value']?>] = $option-><?php echo $field['searchable']['label']?>;
                            			<?php endif;?>
                            		} <?php
                            		break;
                            endswitch;
                            echo '?>'; ?>
							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('<?php echo $name?>',$<?php echo $varname?>_options, explode(',', $record['<?php echo $f_name?>']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="<?php echo $id?>"') }}
	                        </div> <?php
							break;
						case 11: //Auto/Readonly?>
							<input type="text" class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" placeholder="Enter <?php echo $field['label']?>" readonly/> <?php
							break;
						case 12: //Date From - Date To Picker
							$name_from = $field['table'].'['.$field['column'].'_from]';
							$name_to = $field['table'].'['.$field['column'].'_to]'; ?>
							<input type="hidden" name="<?php echo $name?>"/>
							<div class="input-group input-xlarge date-picker input-daterange" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="<?php echo $name_from?>" id="<?php echo $id?>_from" value="{{ $record['<?php echo $f_name?>_from'] }}" />
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control" name="<?php echo $name_to?>" id="<?php echo $id?>_to" value="{{ $record['<?php echo $f_name?>_to'] }}" />
							</div> <?php
							break;
						case 13: //place holder/label
							break;
						case 14: //Time From - Time To Picker ?>
							No UI for Time From - Time To Picker yet<?php
							break;
						case 15: //sex ?>
							<div class="radio-list">
								<label class="radio-inline">
									<input type="radio" name="<?php echo $name?>" id="<?php echo $id?>_male" value="male" @if( $record['<?php echo $f_name?>'] == 'male' ) checked="checked" @endif /> Male
								</label>
								<label class="radio-inline">
									<input type="radio" name="<?php echo $name?>" id="<?php echo $id?>_female" value="female" @if( $record['<?php echo $f_name?>'] == 'female' ) checked="checked" @endif /> Female
								</label>  
							</div> <?php
							break;
						case 16: //Date and Time Picker ?>
							<div class="input-group date form_datetime">                                       
								<input type="text" size="16" readonly class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" />
								<span class="input-group-btn">
									<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
								</span>
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> <?php
							break;
						case 17: //Time Picker ?>
							<div class="input-group bootstrap-timepicker">                                       
								<input type="text" class="form-control timepicker-default" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" />
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
								</span>
							</div> <?php
							break;
						case 18: //Month and Year Picker ?>
							<div class="input-group input-medium date date-picker" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
								<input type="text" class="form-control" name="<?php echo $name?>" id="<?php echo $id?>" value="{{ $record['<?php echo $f_name?>'] }}" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> <?php
							break;
						case 19: //Number Range ?>
							No UI for Number Range yet <?php
							break;
						case 20: //Time - Minute Second Picker ?>
							No UI for Time - Minute Second Picker yet <?php
							break;
						case 21: //Date and Time From - Date and Ti ?>
							No UI for Time - Minute Second Picker yet <?php
							break;
					} ?>
				</div>	
			</div><?php
		} ?>
	</div>
</div>