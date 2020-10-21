<?php
	$readonly = '';
	if (!in_array($applicable_status_id,array(0,1,3))){
		$readonly = 'readonly';
	}

	$db->where('planning_id',$planning_id);
	$db->where('user_id',$user_id);
	$db->where('template_section_id',$section_id);
	$db->group_by('item');
	$db->join('performance_template_section_column','performance_planning_applicable_items.section_column_id = performance_template_section_column.section_column_id','left');
	$row_item_result = $db->get('performance_planning_applicable_items');

	if ($row_item_result && $row_item_result->num_rows() > 0){
		foreach ($row_item_result->result() as $row_item) {	
			$where = array(
				'performance_planning_applicable_fields.planning_id' => $planning_id,
				'performance_planning_applicable_fields.user_id' => $user_id,
				'template_section_id' => $section_id,
				'item' => $row_item->item
			);
			$db->join('performance_planning_applicable_items','performance_planning_applicable_fields.item_id = performance_planning_applicable_items.item_id','left');			
			$db->join('performance_template_section_column','performance_planning_applicable_items.section_column_id = performance_template_section_column.section_column_id','left');
			$items = $this->db->get_where('performance_planning_applicable_fields', $where);		
			if ($items && $items->num_rows() > 0){
				$items_array = $items->result_array();
?>			
				<tr>	
					<input type="hidden" class="form-control" name="item[13][]">				
					<?
						$where = array(
							'item_id' => $items_array[0]['item_id']
						);
						$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
						if ($items_field && $items_field->num_rows() > 0){
							$fields = $items_field->row();
						}					
					?>
					<td><textarea class="form-control" rows="4" name="appraisal_field[13][<?php echo $items_array[0]['item_id'] ?>]" readonly><?php echo $fields->value ?></textarea></td>
					<input type="hidden" class="form-control" name="item[14][]">
					<?
						$where = array(
							'item_id' => $items_array[1]['item_id']
						);
						$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
						if ($items_field && $items_field->num_rows() > 0){
							$fields = $items_field->row();
						}					
					?>					
					<td colspan="3"><textarea class="form-control" rows="4" name="appraisal_field[14][<?php echo $items_array[1]['item_id'] ?>]" <?php echo $readonly ?>><?php echo $fields->value ?></textarea></td>
				</tr>
				<tr>
					<input type="hidden" class="form-control" name="item[15][]">
					<?
						$where = array(
							'item_id' => $items_array[2]['item_id']
						);
						$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
						if ($items_field && $items_field->num_rows() > 0){
							$fields = $items_field->row();
						}					
					?>						
					<td width="30%" style='border-top:none' rowspan="2"><textarea class="form-control" rows="4" name="appraisal_field[15][<?php echo $items_array[2]['item_id'] ?>]" readonly><?php echo $fields->value ?></textarea></td>
					<td width="15%" style='border-top:none'></td>
					<td width="35%" style='border-top:none'>Program Courses</td>
					<td width="20%" style='border-top:none'>Timeline</td>				
				</tr>				
				<tr>
					<input type="hidden" class="form-control" name="item[16][]">
					<td width="15%">
						<?
							$where = array(
								'item_id' => $items_array[3]['item_id']
							);
							$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
							if ($items_field && $items_field->num_rows() > 0){
								$fields = $items_field->row();
							}					
						?>							
						<select class="form-control" name="appraisal_field[16][<?php echo $items_array[3]['item_id'] ?>]" <?php echo $readonly ?>>
							<option value=""></option>
						</select>					
					</td>
					<input type="hidden" class="form-control" name="item[17][]">
					<?
						$where = array(
							'item_id' => $items_array[4]['item_id']
						);
						$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
						if ($items_field && $items_field->num_rows() > 0){
							$fields = $items_field->row();
						}					
					?>						
					<td width="35%"><textarea class="form-control" rows="4" name="appraisal_field[17][<?php echo $items_array[4]['item_id'] ?>]" <?php echo $readonly ?>><?php echo $fields->value ?></textarea></td>
					<input type="hidden" class="form-control" name="item[18][]">
					<?
						$where = array(
							'item_id' => $items_array[5]['item_id']
						);
						$items_field = $this->db->get_where('performance_appraisal_fields', $where);													
						if ($items_field && $items_field->num_rows() > 0){
							$fields = $items_field->row();
						}					
					?>						
					<td width="20%"><textarea class="form-control" rows="4" name="appraisal_field[18][<?php echo $items_array[5]['item_id'] ?>]" <?php echo $readonly ?>><?php echo $fields->value ?></textarea></td>				
				</tr>
<?php
			}
		}
	}
?>