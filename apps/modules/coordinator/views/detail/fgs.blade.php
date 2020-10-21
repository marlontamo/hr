<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Coordinator Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">Company</label>
			<div class="col-md-7">						
				<?php echo $record['users_coordinator_company'] ?>				
            </div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3">Branch</label>
			<div class="col-md-7">
				<?php echo $record['users_coordinator_branch'] ?>
            </div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3">Coordinator</label>
			<div class="col-md-7">
				<?php echo $record['users_coordinator_coordinator'] ?>			
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
					<th width="20%">Employee</th>
					<th width="80%">Coordinator</th>						
				</tr>
			</thead>
			<tbody id="record-list-coordinator">
				<?php
					if ( $record['users_coordinator_user_id']){
						$user_id = $record['users_coordinator_user_id'];
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