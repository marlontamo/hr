<?php
	$rows = array();
	$rows_multi = array();
	$qry = "select a.*, b.uitype
	FROM {$db->dbprefix}performance_template_section_column a
	LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
	WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
	ORDER BY a.sequence";
	$columns = $db->query( $qry );
	$first = true;

	$db->where('planning_id',$planning_id);
	$db->where('user_id',$user_id);
	$db->where('template_section_id',$section_id);
	$db->group_by('item');
	$db->join('performance_template_section_column','performance_planning_applicable_items.section_column_id = performance_template_section_column.section_column_id','left');
	$row_item_result = $db->get('performance_planning_applicable_items');

	if ($row_item_result && $row_item_result->num_rows() > 0){
		foreach ($row_item_result->result() as $row_item) {
			echo '<tr>';
			foreach( $columns->result() as $col )
			{
				switch( $col->uitype_id )
				{
					case 3:
							$where = array(
								'planning_id' => $planning_id,
								'user_id' => $user_id,
								'item' => $row_item->item,
								'section_column_id' => $col->section_column_id
							);
							$items = $this->db->get_where('performance_planning_applicable_items', $where);					
							if ($items && $items->num_rows() > 0){
								$items_row = $items->row();

								$where = array(
									'item_id' => $items_row->item_id,
								);
								$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
								if ($items_field && $items_field->num_rows() > 0){
									$fields = $items_field->row();
								}
							}
						?>
							<td rowspan="">
								<textarea class="form-control" rows="4" name="field[<?php echo $items_row->item_id?>]" readonly><?php echo $fields->value ?></textarea>
							</td> <?php
						break;	
					case 11:
							$where = array(
								'planning_id' => $planning_id,
								'user_id' => $user_id,
								'item' => $row_item->item,
								'section_column_id' => $col->section_column_id
							);
							$items = $this->db->get_where('performance_planning_applicable_items', $where);					
							if ($items && $items->num_rows() > 0){
								$items_row = $items->row();

								$where = array(
									'item_id' => $items_row->item_id,
								);
								$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
								if ($items_field && $items_field->num_rows() > 0){
									$fields = $items_field->row();
								}
							}					
							if ($fields->value == '') {				
						?>
								<td style='border-top:none'>

								</td>
						<?php  } else { ?>		
							<td rowspan="">
								<textarea class="form-control" rows="4" name="field[<?php echo $items_row->item_id ?>]" readonly><?php echo $fields->value?></textarea>
							</td> <?php }
						break;									
					case 4:
							$where = array(
								'planning_id' => $planning_id,
								'user_id' => $user_id,
								'item' => $row_item->item,
								'section_column_id' => $col->section_column_id
							);
							$items = $this->db->get_where('performance_planning_applicable_items', $where);					
							if ($items && $items->num_rows() > 0){
								$items_row = $items->row();

								$where = array(
									'item_id' => $items_row->item_id,
								);
								$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
								if ($items_field && $items_field->num_rows() > 0){
									$fields = $items_field->row();
								}
							}						
					?>
							<td rowspan="">
								<textarea class="form-control" rows="4" name="field[<?php echo $items_row->item_id?>]" readonly><?php echo $fields->value?></textarea>						
							</td> 
					<?php
						break;
					case 7: //weight
						$where = array(
							'planning_id' => $planning_id,
							'user_id' => $user_id,
							'item' => $row_item->item,
							'section_column_id' => $col->section_column_id
						);
						$items = $this->db->get_where('performance_planning_applicable_items', $where);					
						if ($items && $items->num_rows() > 0){
							$items_row = $items->row();

							$where = array(
								'item_id' => $items_row->item_id,
							);
							$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
							if ($items_field && $items_field->num_rows() > 0){
								$fields = $items_field->row();
							}
						}	

						echo '<td class="childItem-'.$items_row->item_id.'"><input type="text" class="form-control weight" name="field['. $items_row->item_id .']" value="'.$fields->value.'" readonly></td>';
						break;
					case 9: //dropdown
						$where = array(
							'planning_id' => $planning_id,
							'user_id' => $user_id,
							'item' => $row_item->item,
							'section_column_id' => $col->section_column_id
						);
						$items = $this->db->get_where('performance_planning_applicable_items', $where);					
						if ($items && $items->num_rows() > 0){
							$items_row = $items->row();

							$where = array(
								'item_id' => $items_row->item_id,
							);
							$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
							if ($items_field && $items_field->num_rows() > 0){
								$fields = $items_field->row();
							}
						}	
						echo '<td class="childItem-'.$child->item_id.'">
								<select class="form-control" name="field['. $items_row->item_id .']" readonly>';
									echo '<option value="">Select</option>';
									for ($i=1; $i < 11; $i++) { 
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
									
								echo '</select>
							  </td>';
						break;
					case 5: //rating
						$where = array(
							'planning_id' => $planning_id,
							'user_id' => $user_id,
							'item' => $row_item->item,
							'section_column_id' => $col->section_column_id
						);
						$items = $this->db->get_where('performance_planning_applicable_items', $where);					
						if ($items && $items->num_rows() > 0){
							$items_row = $items->row();

							$where = array(
								'item_id' => $items_row->item_id,
							);
							$items_field = $this->db->get_where('performance_planning_applicable_fields', $where);													
							if ($items_field && $items_field->num_rows() > 0){
								$fields = $items_field->row();
							}
						}					
						echo '<td><input type="text" class="form-control dontserializeme" value="'.$fields->value.'" readonly></td>';
						break;				
					default:
						echo '<td><input type="text" class="form-control dontserializeme"></td>';
				}
			}	
		}
		
	}
?>