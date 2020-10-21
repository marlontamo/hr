<?php
	if ($list_coordinator && $list_coordinator->num_rows() > 0){
		$coordinator_existing = $this->db->get_where('users_coordinator',array('coordinator_id' => $record_id));
		$user_id_array = array();
		if ($coordinator_existing && $coordinator_existing->num_rows() > 0){
			$user_id = $coordinator_existing->row()->user_id;
			if (strlen($user_id) > 1){
				$user_id_array = explode(',', $user_id);
			}
			else{
				array_push($user_id_array, $user_id);
			}
		}
		foreach ($list_coordinator->result() as $row) {
			$coordinator = '';
			$query = "SELECT GROUP_CONCAT(DISTINCT full_name SEPARATOR '<br> ') AS list_name FROM ww_users WHERE user_id IN ({$row->coordinator_id})";
			$result = $this->db->query($query);
			if ($result && $result->num_rows() > 0){
				$coordinator = $result->row()->list_name;
			}

			$check = '';
			if (in_array($row->user_id, $user_id_array)){
				$check = 'checked="checked"';
			}
?>
			<tr class="record last-scroll-row">
			    <td>
			        <div>
			            <input name="user[]" type="checkbox" <?php echo $check ?>class="record-checker checkboxes" value="<?php echo $row->user_id ?>">
			        </div>
			    </td>
			    <td><?php echo $row->full_name?></td>
			    <td><?php echo $coordinator ?></td>
			</tr>			
<?php
		}
	}
?>