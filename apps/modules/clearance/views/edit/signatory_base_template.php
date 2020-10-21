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
	                        <?php $disabled = (isset($value['status_id']) &&  $value['status_id'] == 4) ? "disabled" : '';
	                        	 echo form_dropdown('partners_clearance_signatories[clearance_signatories_id]['.$value["clearance_layout_sign_id"].']',$user_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id" '.$disabled) ?>
	                    </div>
					</td>
				</tr>
				<tr>
					<?php
		                    $query = "SELECT * FROM partners_personal_history_accountabilities
		                    		  WHERE user_id = {$clearance_record['partner_id']}
		                    		 ";
		                    $options = $this->db->query($query);

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
										if( !empty($signatories[$value['clearance_layout_sign_id']]['attachments']) ){
											$file = FCPATH . urldecode( $signatories[$value['clearance_layout_sign_id']]['attachments'] );
											if( file_exists( $file ) )
											{
												$f_info = get_file_info( $file );
											}
										}
									?>
									<input type="hidden" name="partners_clearance_signatories[attachments][<?php echo $value["clearance_layout_sign_id"] ?>]" id="clearace_signatories-attachments" value=""/>
									<div class="input-group">
										<span class="input-group-btn">
											<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview"></span>
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
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-list-ul"></i>
							</span>
							<?php echo form_dropdown('partners_clearance_signatories[accountabilities_id][]',$accountabilities_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="accountabilities"') ?>
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" onclick="add_account_from_201($(this),<?php echo $value["clearance_layout_sign_id"] ?>)"><i class="fa fa-plus"></i></button>
							</span>
						</div>
						<div class="accountability">
						</div>								 							
		        	</td>
				</tr>
				<tr >
					<input type="hidden" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
					<td class="active"><span class="bold">Remarks</span></td>
					<td><textarea disabled rows="2" class="form-control" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]"></textarea></td>
				</tr>
				<tr>
					<input type="hidden" name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
					<td class="active"><span class="bold">Status</span></td>
					<td>
						<select  disabled class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" >
							<option value="">Select...</option>
		                    <option value="4" <?php echo ($value['status_id'] == 4) ? "selected='selected'" : '' ?> >Cleared</option>
		                    <option value="3" <?php echo ($value['status_id'] == 3) ? "selected='selected'" : '' ?> >Pending</option>
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
	                        <?php echo form_dropdown('partners_clearance_signatories[clearance_signatories_id]['.$value["clearance_layout_sign_id"].']',$user_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id" ') ?>
	                    </div>
					</td>
				</tr>
				<tr>
					<?php
		                    $query = "SELECT * FROM partners_personal_history_accountabilities
		                    		  WHERE user_id = {$clearance_record['partner_id']}
		                    		 ";
		                    $options = $this->db->query($query);

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
										if( !empty($signatories[$value['clearance_layout_sign_id']]['attachments']) ){
											$file = FCPATH . urldecode( $signatories[$value['clearance_layout_sign_id']]['attachments'] );
											if( file_exists( $file ) )
											{
												$f_info = get_file_info( $file );
											}
										}
									?>
									<input type="hidden" name="partners_clearance_signatories[attachments][<?php echo $value["clearance_layout_sign_id"] ?>]" id="clearace_signatories-attachments" value=""/>
									<div class="input-group">
										<span class="input-group-btn">
											<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview"></span>
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
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-list-ul"></i>
							</span>
							<?php echo form_dropdown('partners_clearance_signatories[accountabilities_id][]',$accountabilities_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="accountabilities"') ?>
							<span class="input-group-btn">
								<button type="button" class="btn btn-default" onclick="add_account_from_201($(this),<?php echo $value["clearance_layout_sign_id"] ?>)"><i class="fa fa-plus"></i></button>
							</span>
						</div> 
						<div class="accountability">
						</div>							
		        	</td>
				</tr>
				<tr >
					<input type="hidden" name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
					<td class="active"><span class="bold">Remarks</span></td>
					<td><textarea rows="2" disabled class="form-control"  name="partners_clearance_signatories[remarks][<?php echo $value["clearance_layout_sign_id"] ?>]"></textarea></td>
				</tr>
				<tr>
					<td class="active"><span class="bold">Status</span></td>
					<td>
						<input type="hidden" name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" value="">
						<select  disabled class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id][<?php echo $value["clearance_layout_sign_id"] ?>]" >
							<option value="">Select...</option>
		                    <option value="4">Cleared</option>
		                    <option value="3">Pending</option>
		                </select>
					</td>
				</tr>
			</table>
		</div>
	<?php 
	}     
}
?>