<div class="portlet">
	<div class="portlet">
        <div class="portlet-title">
            <div class="caption">Clearance <span class="small text-muted"> view</span></div>
        </div>
            
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <!-- <form action="#" class="form-horizontal"> -->
                <div class="form-body">
                	<div class="form-group">
                        <label class="control-label col-md-4">Employee
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['firstname'] }} {{ $partner_record['lastname'] }}" /> 	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Department
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['dept'] }}" /> 	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Company <span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['comp'] }}" /> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Alternate Email
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="alternate_email" {{ ($clearance_record['status_id'] == 1 || $clearance_record['status_id'] == 2) ? '' : 'readonly' }} value="{{ $clearance_record['alternate_email'] }}" /> 
                        </div>
                    </div>
                    <div class="form-group">
						<label class="control-label col-md-4">Effectivity Date<span class="required">*</span></label>
						<div class="col-md-5">							
                            <input type="text" class="form-control" readonly value="{{ date('F d, Y', strtotime($clearance_record['effectivity_date'])) }}" /> 
						</div>
					</div>
					<?php
						$turn_around_time = '';
						if ($clearance_record['turn_around_time'] && $clearance_record['turn_around_time'] != '0000-00-00' && $clearance_record['turn_around_time'] != 'January 01, 1970' && $clearance_record['turn_around_time'] != '1970-01-01'){
							$turn_around_time = date("F d, Y", strtotime($clearance_record['turn_around_time']));
						}
					?>
					<div class="form-group">
						<label class="control-label col-md-4">Turnaround Date<span class="required">*</span></label>
						<div class="col-md-5">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_clearance[turn_around_time]" id="partners_clearance-turn_around_time" value="{{ $turn_around_time }}" placeholder="Enter Turnaround Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label col-md-4">Clearance Template<span class="required">*</span>
                        </label>
                        <div class="col-md-5">                        
                        	<?php
							$db->select('clearance_layout_id, layout_name');
							$db->where('deleted', '0');
							$options = $db->get('partners_clearance_layout');
							$clearance_layout_id_options = array('0' => 'Select...');
								foreach($options->result() as $option)
								{
									$clearance_layout_id_options[$option->clearance_layout_id] = $option->layout_name;
								} 
								// echo "<pre>";print_r($clearance_layout_id_options);
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('partners_clearance[clearance_layout_id]',$clearance_layout_id_options, (isset($layout_record['clearance_layout_id']) ? $layout_record['clearance_layout_id'] : null), 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance-clearance_layout_id"') }}
							</div>
                        </div>
                    </div>

					<br>

					<!--Signatories Remarks-->
                    <div class="portlet margin-top-25">
						<div class="portlet-title">
							<div class="caption">Signatories Remarks</div>
							<div class="tools">
								<a class="collapse" href="javascript:;"></a>
							</div>
						</div>
						<p class="margin-bottom-25 small">This clearance form is signed by each department to clear an employee leaving the company. Per policy, the employee’s last pay will not be released without a properly accomplished clearance form.</p>

						<div class="portlet-body">
							<div name="signatories" id="signatories">
								<?php if (!empty($records)) { ?>
								    <div class="panel panel-info">
								        <div class="panel-heading" style="background-color: #2e7af4;color:#FFF">
								            <h3 class="panel-title">Other Properties
								            </h3>
								        </div>  
								    </div>  

									<?php foreach ( $records as $key => $value) { ?>
										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="panel-title"><?php echo $value['panel_title'] ?>
													<span class="pull-right "><a class="small text-muted" onclick="delete_signatories($(this))" href="#">Delete</a></span>
												</h3>
											</div>
												
											<table class="table">
												<input type="hidden" name="partners_clearance_signatories[panel_title][<?php echo $value['clearance_layout_sign_id'] ?>]" value="<?php echo $value['panel_title'] ?>">
												<input type="hidden" name="partners_clearance_signatories[clearance_layout_sign_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="<?php echo $value['clearance_layout_sign_id'] ?>">
												<tr>
													<td width="30%" class="active">
														<span class="bold">Signatory</span>
													</td>
													<td>						
									                    <?php
										                    $db->select('user_id, full_name');
										                    $db->where('deleted', '0');
										                    $options = $db->get('users');
										                    $user_id_options = array('0' => 'Select...');
									                        foreach($options->result() as $option)
									                        {
									                            $user_id_options[$option->user_id] = $option->full_name;
									                        } 
									                    ?>
									                    <div class="input-group">
									                        <span class="input-group-addon">
									                            <i class="fa fa-list-ul"></i>
									                        </span>
									                        <?php $disabled = (isset($value['status_id']) && $value['status_id'] == 4) ? "disabled" : '';
									                        	 echo form_dropdown('partners_clearance_signatories[clearance_signatories_id]['.$value["clearance_layout_sign_id"].']',$user_id_options, $signatories[$value['clearance_layout_sign_id']]['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id" '.$disabled) ?>
									                    </div>
													</td>
												</tr>
												<tr>
													<?php
										                    $query = "SELECT * FROM partners_personal_history_accountabilities
										                    		  WHERE user_id = {$clearance_record['partner_id']}
										                    		 ";
										                    $options = $db->query($query);

										                    $accountabilities_id_options = array('0' => 'Select...');
										                    if ($options && $options->num_rows() > 0){
										                        foreach($options->result() as $option)
										                        {
										                            $accountabilities_id_options[$option->name] = $option->name;
										                        } 
									                        }					
													?>
													<td class="active"><span class="bold">Accountabilities </span></td>
													<td>
														<div class="form-group">
															<label class="control-label col-md-3">
																<span>
												                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" href="#temp_section" onclick="add_account($(this),<?php echo $value["clearance_layout_sign_id"] ?>)">Add Item</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                </span>																	
															</label>
															<div class="col-md-7">
																&nbsp;
												            </div>	
											            </div>														
														<div class="form-group">														
															<label class="control-label col-md-3">Attachments</label>
															<div class="col-md-7">
																<div data-provides="fileupload" class="fileupload fileupload-new" id="clearace_signatories-attachments-container">
																	<?php  
																		$f_info = '';
																		if( !empty($attachments_arr[$value['clearance_layout_sign_id']]) ){
																			$file = FCPATH . urldecode( $attachments_arr[$value['clearance_layout_sign_id']] );
																			if( file_exists( $file ) )
																			{
																				$f_info = get_file_info( $file );
																			}
																		}
																	?>
																	<input type="hidden" name="partners_clearance_signatories[attachments][<?php echo $value["clearance_layout_sign_id"] ?>]" id="clearace_signatories-attachments" value="{{ isset($attachments_arr[$value['clearance_layout_sign_id']]) ? $attachments_arr[$value['clearance_layout_sign_id']] : '' }}"/>
																	<div class="input-group">
																		<span class="input-group-btn">
																			<span class="uneditable-input">
																			<i class="fa fa-file fileupload-exists"></i> 
																			<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
																			</span>
																		</span>
																		<span class="btn default btn-file">
																			<span class="fileupload-new"><i class="fa fa-paper-clip"></i>Select File</span>
																			<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
																			<input type="file" class="clearace_signatories-attachments-fileupload" id="clearace_signatories-attachments-fileupload" type="file" name="files[]">
																		</span>
																		<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>Remove</a>
																	</div>
																</div>
															</div>
														</div>
										                <div class="form-group">
															<label class="col-md-3 col-sm-3 text-muted">Attachments</label>
															<div class="controls col-md-6">
																<?php
																	$attachments = $db->get_where('partners_clearance_signatories_attachment',array('clearance_signatories_id' => $signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id'], 'type' => 1));
																	if ($attachments && $attachments->num_rows() > 0){
																		$sign['attachments'] = $attachments->row()->attachments;
																	}
																?>																		
									                            <!-- <ul class="padding-none margin-top-10"> -->
									                            @if( !empty($sign['attachments']) )
																	<?php 
																		$file = FCPATH . urldecode( $sign['attachments']);
																		if( file_exists( $file ) )
																		{
																			$f_info = get_file_info( $file );
																			$f_type = filetype( $file );

									/*										$finfo = finfo_open(FILEINFO_MIME_TYPE);
																			$f_type = finfo_file($finfo, $file);*/

																			switch( $f_type )
																			{
																				case 'image/jpeg':
																					$icon = 'fa-picture-o';
																					echo '<a class="fancybox-button" href="'.base_url($sign['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            	<span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				case 'video/mp4':
																					$icon = 'fa-film';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				case 'audio/mpeg':
																					$icon = 'fa-volume-up';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				default:
																					$icon = 'fa-file-text-o';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																			}
																	        	// <li class="padding-3 fileupload-delete-'.$record_id.'" style="list-style:none;">
																	        	// </li>
																	            // <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$record_id.'" href="javascript:void(0)"></a></span>
																		}
																	?>
																@endif
									                            <!-- </ul> -->
															</div>
														</div>																 														
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-list-ul"></i>
															</span>
															<?php echo form_dropdown('partners_clearance_signatories[accountabilities_id][]',$accountabilities_id_options, (isset($value['user_id']) ? $value['user_id'] : 0), 'class="form-control select2me" data-placeholder="Select..." id="accountabilities"') ?>
															<span class="input-group-btn">
																<button type="button" class="btn btn-default" onclick="add_account_from_201($(this),<?php echo $value["clearance_layout_sign_id"] ?>)"><i class="fa fa-plus"></i></button>
															</span>
														</div>
														<div class="accountability">
															<?php 
																if (isset($accountabilities[$value['clearance_layout_sign_id']][$signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']]) && count($accountabilities[$value['clearance_layout_sign_id']][$signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']]) > 0){ 
																	foreach ($accountabilities[$value['clearance_layout_sign_id']][$signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']] as $key => $value_acct) {
															?>
																		<div>
																			<br>
																			<span class="pull-right small text-muted">
																		       <a style="cursor:pointer" class="pull-right small text-muted" onclick="delete_account(this)"><?=lang('common.delete')?></a>
																		    </span><br>
																			<input type="text" class="form-control act<?php echo $value["clearance_layout_sign_id"] ?>" name="partners_clearance_signatories_accountabilities[<?php echo $value['clearance_layout_sign_id'] ?>][accountability][]" value="<?php echo $value_acct['accountability'] ?>">
																		</div>							
															<?php
																	}
																} 
															?>																
														</div>														 							
										        	</td>
												</tr>
												<tr >
													<input type="hidden" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
													<td class="active"><span class="bold">Remarks</span></td>
													<td><textarea disabled rows="2" class="form-control" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]"><?php echo $signatories[$value['clearance_layout_sign_id']]['remarks'] ?></textarea></td>
												</tr>
												<tr>
													<input type="hidden" name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
													<td class="active"><span class="bold">Status</span></td>
													<td>
														<select disabled class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" >
															<option value="">Select...</option>
										                    <option value="4" <?php echo ($signatories[$value['clearance_layout_sign_id']]['status_id'] == 4) ? "selected='selected'" : '' ?> >Cleared</option>
										                    <option value="3" <?php echo ($signatories[$value['clearance_layout_sign_id']]['status_id'] == 3) ? "selected='selected'" : '' ?> >Pending</option>
										                </select>
													</td>
												</tr>
											</table>
										</div>   
								<?php 
									} 
								}
								?>

								<?php if (!empty($records_head_office)) { ?>
								    <div class="panel panel-info">
								        <div class="panel-heading" style="background-color: #2e7af4;color:#FFF">
								            <h3 class="panel-title">Head Office
								            </h3>
								        </div>  
								    </div>  

									<?php foreach( $records_head_office as $key => $value) { ?>
										<div class="panel panel-info">
											<div class="panel-heading">
												<h3 class="panel-title"><?php echo $value['panel_title'] ?>
													<span class="pull-right "><a class="small text-muted" onclick="delete_signatories($(this))" href="#">Delete</a></span>		
												</h3>
											</div>
												
											<table class="table">
												<input type="hidden" name="partners_clearance_signatories[panel_title][<?php echo $value['clearance_layout_sign_id'] ?>]" value="<?php echo $value['panel_title'] ?>">
												<input type="hidden" name="partners_clearance_signatories[clearance_layout_sign_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="<?php echo $value['clearance_layout_sign_id'] ?>">
												<tr>
													<td width="30%" class="active">
														<span class="bold">Signatory</span>
													</td>
													<td>						
									                    <?php
									                    $db->select('user_id, full_name');
									                    $db->where('deleted', '0');
									                    $options = $db->get('users');
									                    $user_id_options = array('0' => 'Select...');
									                        foreach($options->result() as $option)
									                        {
									                            $user_id_options[$option->user_id] = $option->full_name;
									                        } 
									                        // echo "<pre>";print_r($user_id_options);
									                    ?>
									                    <div class="input-group">
									                        <span class="input-group-addon">
									                            <i class="fa fa-list-ul"></i>
									                        </span>
									                        <?php echo form_dropdown('partners_clearance_signatories[clearance_signatories_id]['.$value["clearance_layout_sign_id"].']',$user_id_options, (isset($signatories[$value['clearance_layout_sign_id']]['user_id']) ? $signatories[$value['clearance_layout_sign_id']]['user_id'] : 0), 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id" ') ?>
									                    </div>
													</td>
												</tr>
												<tr>
													<?php
										                    $query = "SELECT * FROM partners_personal_history_accountabilities
										                    		  WHERE user_id = {$clearance_record['partner_id']}
										                    		 ";
										                    $options = $db->query($query);

										                    $accountabilities_id_options = array('0' => 'Select...');
										                    if ($options && $options->num_rows() > 0){
										                        foreach($options->result() as $option)
										                        {
										                            $accountabilities_id_options[$option->name] = $option->name;
										                        } 
									                        }					
													?>					
													<td class="active"><span class="bold">Accountabilities </span></td>
													<td>
														<div class="form-group">
															<label class="control-label col-md-3">
																<span>
												                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" href="#temp_section" onclick="add_account($(this),<?php echo $value["clearance_layout_sign_id"] ?>)">Add Item</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												                </span>																	
															</label>
															<div class="col-md-7">
																&nbsp;
												            </div>	
											            </div>														
														<div class="form-group">														
															<label class="control-label col-md-3">Attachments</label>
															<div class="col-md-7">
																<div data-provides="fileupload" class="fileupload fileupload-new" id="clearace_signatories-attachments-container">
																	<?php  
																		$f_info = '';
																		if( !empty($attachments_arr[$value['clearance_layout_sign_id']]) ){
																			$file = FCPATH . urldecode( $attachments_arr[$value['clearance_layout_sign_id']] );
																			if( file_exists( $file ) )
																			{
																				$f_info = get_file_info( $file );
																			}
																		}
																	?>
																	<input type="hidden" name="partners_clearance_signatories[attachments][<?php echo $value["clearance_layout_sign_id"] ?>]" id="clearace_signatories-attachments" value="{{ isset($attachments_arr[$value['clearance_layout_sign_id']]) ? $attachments_arr[$value['clearance_layout_sign_id']] : '' }}"/>
																	<div class="input-group">
																		<span class="input-group-btn">
																			<span class="uneditable-input">
																			<i class="fa fa-file fileupload-exists"></i> 
																			<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
																			</span>
																		</span>
																		<span class="btn default btn-file">
																			<span class="fileupload-new"><i class="fa fa-paper-clip"></i>Select File</span>
																			<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
																			<input type="file" class="clearace_signatories-attachments-fileupload" id="clearace_signatories-attachments-fileupload" type="file" name="files[]">
																		</span>
																		<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>Remove</a>
																	</div>
																</div>
															</div>
														</div>
										                <div class="form-group">
															<label class="col-md-4 col-sm-4 text-muted">Attachments by Signatories</label>
															<div class="controls col-md-5">
																<?php
																	$sign['attachments'] = '';
																	if (isset($signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id'])){
																		$attachments = $db->get_where('partners_clearance_signatories_attachment',array('clearance_signatories_id' => $signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id'], 'type' => 1));
																		if ($attachments && $attachments->num_rows() > 0){
																			$sign['attachments'] = $attachments->row()->attachments;
																		}
																		else{
																			$sign['attachments'] = '';
																		}
																	}
																?>																		
									                            <!-- <ul class="padding-none margin-top-10"> -->
									                            @if( !empty($sign['attachments']) )
																	<?php 
																		$file = FCPATH . urldecode( $sign['attachments']);
																		if( file_exists( $file ) )
																		{
																			$f_info = get_file_info( $file );
																			$f_type = filetype( $file );

									/*										$finfo = finfo_open(FILEINFO_MIME_TYPE);
																			$f_type = finfo_file($finfo, $file);*/

																			switch( $f_type )
																			{
																				case 'image/jpeg':
																					$icon = 'fa-picture-o';
																					echo '<a class="fancybox-button" href="'.base_url($sign['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            	<span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				case 'video/mp4':
																					$icon = 'fa-film';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				case 'audio/mpeg':
																					$icon = 'fa-volume-up';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																					break;
																				default:
																					$icon = 'fa-file-text-o';
																					echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
																	            <span>'. basename($f_info['name']) .'</span></a>';
																			}
																	        	// <li class="padding-3 fileupload-delete-'.$record_id.'" style="list-style:none;">
																	        	// </li>
																	            // <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$record_id.'" href="javascript:void(0)"></a></span>
																		}
																	?>
																@endif
									                            <!-- </ul> -->
															</div>
														</div>																									                                					
														<div class="input-group">
															<span class="input-group-addon">
																<i class="fa fa-list-ul"></i>
															</span>
															<?php echo form_dropdown('partners_clearance_signatories[accountabilities_id][]',$accountabilities_id_options, (isset($value['user_id']) ? $value['user_id'] : 0), 'class="form-control select2me" data-placeholder="Select..." id="accountabilities"') ?>
															<span class="input-group-btn">
																<button type="button" class="btn btn-default" onclick="add_account_from_201($(this),<?php echo $value["clearance_layout_sign_id"] ?>)"><i class="fa fa-plus"></i></button>
															</span>
														</div> 
														<div class="accountability">
															<?php 
																if (isset($accountabilities[$value['clearance_layout_sign_id']]) && isset($signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']) && count($accountabilities[$value['clearance_layout_sign_id']][$signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']]) > 0){ 
																	foreach ($accountabilities[$value['clearance_layout_sign_id']][$signatories[$value['clearance_layout_sign_id']]['clearance_signatories_id']] as $key => $value_acct) {
															?>
																		<div>
																			<br>
																			<span class="pull-right small text-muted">
																		       <a style="cursor:pointer" class="pull-right small text-muted" onclick="delete_account(this)"><?=lang('common.delete')?></a>
																		    </span><br>
																			<input type="text" class="form-control act<?php echo $value["clearance_layout_sign_id"] ?>" name="partners_clearance_signatories_accountabilities[<?php echo $value['clearance_layout_sign_id'] ?>][accountability][]" value="<?php echo $value_acct['accountability'] ?>">
																		</div>							
															<?php
																	}
																} 
															?>																
														</div>							
										        	</td>
												</tr>
												<tr >
													<input type="hidden" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
													<td class="active"><span class="bold">Remarks</span></td>
													<td><textarea disabled rows="2" class="form-control"  name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]"><?php echo (isset($signatories[$value['clearance_layout_sign_id']]['remarks']) ? $signatories[$value['clearance_layout_sign_id']]['remarks'] : '') ?></textarea></td>
												</tr>
												<tr>
													<td class="active"><span class="bold">Status</span></td>
													<td>
														<input type="hidden" name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
														<select  disabled class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" >
															<option value="">Select...</option>
										                    <option value="4" <?php echo ($signatories[$value['clearance_layout_sign_id']]['status_id'] == 4) ? "selected='selected'" : '' ?>>Cleared</option>
										                    <option value="3" <?php echo ($signatories[$value['clearance_layout_sign_id']]['status_id'] == 3) ? "selected='selected'" : '' ?>>Pending</option>
										                </select>
													</td>
												</tr>
											</table>
										</div>
									<?php 
									}     
								}
								?>								
							</div>	
						</div>
					</div>
					<!--End-->

                </div>

                <div class="form-actions fluid">
                    <div class="row" align="center">
                        <div class="col-md-12">
                            <div>
                            	@if($clearance_record['status_id'] == 1)
        							<button type="button" class="btn yellow btn-sm" onclick="save_sign( $(this).closest('form'), 1)">Save as Draft</button>
        							<button type="button" class="btn blue btn-sm" onclick="save_sign( $(this).closest('form'), 2)">Save and Send</button>
        						@endif
                                <a href="{{ $mod->url }}/edit/{{ $record_id }}" class="btn btn-default btn-sm" type="button"> Back</a>
                                                           
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
            <!-- END FORM--> 
        </div>
    </div>
</div>
<!-- End Edit -->