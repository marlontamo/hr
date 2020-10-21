<?php 
	foreach( $records as $value)
	{
?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $value['panel_title'] ?>
					<!-- <span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['clearance_layout_sign_id']?>)" href="#">Delete</a></span> -->
					<!-- <span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span> -->
					<!-- <span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['clearance_layout_sign_id']?>)" href="#">Edit</a></span> -->
				</h3>
			</div>
				
			<table class="table">
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
                            <?php echo form_dropdown('partners_clearance_layout_sign[user_id]',$user_id_options, $value['user_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id"') ?>
                        </div>
					</td>
				</tr>
				<!-- <tr>
					<td class="active"><span class="bold">Accountabilities</td>
					<td>
						<input type="text" class="form-control" disabled="disabled"><br>
		        	</td>
				</tr>
				<tr >
					<td class="active"><span class="bold">Remarks</td>
					<td><textarea rows="2" class="form-control" disabled="disabled"></textarea></td>
				</tr>
				<tr>
					<td class="active"><span class="bold">Status</td>
					<td>
						<select  disabled="disabled" class="form-control select2me" data-placeholder="Select...">
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