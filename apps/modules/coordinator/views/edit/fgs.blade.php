<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Coordinator Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">Company</label>
			<div class="col-md-7">
				<?php									                            		
					$db->select('company_id,company');
	                $db->order_by('company', '0');
	                $db->where('deleted', '0');
            		$options = $db->get('users_company'); 	                            
            		$company_options = array('' => 'Select...');
                    foreach($options->result() as $option){
                        $company_options[$option->company_id] = $option->company;
                    } 
                ?>							
              	<div class="input-group">
					<span class="input-group-addon">
                    	<i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('users_coordinator[company_id]',$company_options, $record['users_coordinator.company_id'], 'class="form-control select2me" data-placeholder="Select..." id="users_coordinator-company_id"') }}
                </div> 				
            </div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3">Branch</label>
			<div class="col-md-7">
				<?php									                            		
					$db->select('branch_id,branch');
	                $db->order_by('branch', '0');
	                $db->where('deleted', '0');
            		$options = $db->get('users_branch'); 	                            
            		$branch_options = array('' => 'Select...');
                    foreach($options->result() as $option){
                        $branch_options[$option->branch_id] = $option->branch;
                    } 
                ?>							
              	<div class="input-group">
					<span class="input-group-addon">
                    	<i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('users_coordinator[branch_id]',$branch_options, $record['users_coordinator.branch_id'], 'class="form-control select2me" data-placeholder="Select..." id="users_coordinator-branch_id"') }}
                </div> 				
            </div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3">Coordinator</label>
			<div class="col-md-7">
				<?php									                            		
					$db->select('user_id,full_name');
	                $db->order_by('full_name', '0');
	                $db->where('deleted', '0');
            		$options = $db->get('users'); 	                            
            		$user_options = array(' ' => 'Select...');
                    foreach($options->result() as $option){
                    	if ($option->full_name != ''){
                        	$user_options[$option->user_id] = $option->full_name;
                    	}
                    } 
                ?>							
              	<div class="input-group">
					<span class="input-group-addon">
                    	<i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_multiselect('users_coordinator[coordinator_user_id][]',$user_options, explode(',', $record['users_coordinator.coordinator_user_id']), 'class="form-control select2me" data-placeholder="Select..." id="users_coordinator-coordinator_user_id"') }}
                </div> 				
            </div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3">&nbsp;</label>
			<div class="col-md-7">
				<button class="btn btn-success btn-sm" id="generate">Generate User</button>			
            </div>	
		</div>				
	</div>
	<div class="portlet-title">
		<div class="caption">User List</div>
	</div>
	<div class="clearfix">		
		<table id="record-table" class="table table-condensed table-striped table-hover">
			<thead>
				<tr>
                    <th width="1%" class="hidden-xs">
                        <div>
                            <span><input type="checkbox" class="group-checkable" data-set=".record-checker"></span>
                        </div>
                    </th>										
					<th width="20%">Employee</th>
					<th width="70%">Coordinator</th>						
				</tr>
			</thead>
			<tbody id="record-list-coordinator">
				<?php
					if ( $record['users_coordinator.user_id']){
						$user_id = $record['users_coordinator.user_id'];
						$query = "SELECT * FROM ww_users LEFT JOIN ww_users_profile ON ww_users.user_id = ww_users_profile.user_id WHERE ww_users.user_id IN ($user_id)";
						$result = $db->query($query);

						if ($result && $result->num_rows() > 0){
							foreach ($result->result() as $row) {
								$coordinator = '';
								$query = "SELECT GROUP_CONCAT(DISTINCT full_name SEPARATOR '<br> ') AS list_name FROM ww_users WHERE user_id IN ({$row->coordinator_id})";
								$result = $db->query($query);
								if ($result && $result->num_rows() > 0){
									$coordinator = $result->row()->list_name;
								}

				?>
								<tr class="record last-scroll-row">
								    <td>
								        <div>
								            <input name="user[]" type="checkbox" checked="checked" class="record-checker checkboxes" value="<?php echo $row->user_id ?>">
								        </div>
								    </td>
								    <td><?php echo $row->full_name?></td>
								    <td><?php echo $coordinator ?></td>
								</tr>				
				<?php
							}
						}
					}
				?>
			</tbody>						
		</table>
	</div>
</div>