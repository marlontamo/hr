<?php 
	foreach( $records as $value)
	{
?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $value['panel_title'] ?>
					<span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['clearance_layout_sign_id']?>)" href="#">Delete</a></span>
					<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
					<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['clearance_layout_sign_id']?>)" href="#">Edit</a></span>
				</h3>
			</div>
				
			<table class="table">
				<tr>
					<td width="30%" class="active">
						<span class="bold">Signatory</span>
					</td>
					<td>						
                        <?php
                        $db->select('users.user_id, users.full_name, ud.department');
                        $db->where('users.deleted', '0');
                        $db->where('users.role_id > 1');
                        $db->join('users_profile up', 'up.user_id = users.user_id', 'left');
                        $db->join('users_department ud', 'ud.department_id = up.department_id', 'left');
                        $db->order_by('users.full_name');
                        $options = $db->get('users');
                        $user_id_options = array('0' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $user_id_options[$option->department][$option->user_id] = $option->full_name;
                            } 
                            // echo "<pre>";print_r($user_id_options);
                        ?>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <?php echo form_dropdown('partners_clearance_layout_sign[user_id]',$user_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id"') ?>
                        </div>
					</td>
				</tr>
				<!-- <tr>
					<td class="active"><span class="bold">Accountabilities</td>
					<td>
						<span class="pull-right small text-muted">
		                   <a class="pull-right small text-muted">Delete</a>
		                </span>
						<input type="text" class="form-control"><br>
						<span>
		                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" href="#temp_section">Add Item</button>
		                </span>
		        	</td>
				</tr>
				<tr >
					<td class="active"><span class="bold">Remarks</td>
					<td><textarea rows="2" class="form-control"></textarea></td>
				</tr>
				<tr>
					<td class="active"><span class="bold">Status</td>
					<td>
						<select  class="form-control select2me" data-placeholder="Select...">
		                    <option value="1">Pending</option>
		                    <option value="0">Cleared</option>
		                </select>
					</td>
				</tr> -->
			</table>
		</div>
<?php
	}
?>

<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
    });
</script>