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
				$where = array(
					'planning_id' => $planning_id,
					'item' => $row_item->item,
					'section_column_id' => $col->section_column_id
				);
				$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
				if ($items && $items->num_rows() > 0){
					$items_row = $items->row();
				}					
			?>
				<input type="hidden" class="form-control" name="item[<?php echo $col->section_column_id ?>][]" value="<?php echo (isset($items_row->parent_id) && $items_row->parent_id == 1 ? 1 : 0) ?>">
			<?php
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
								<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]" readonly><?php echo $fields->value ?></textarea>
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
							if ($items_row->parent_id == 1) {					
							?>
									<td style='border-top:none'>
										<input type="hidden" name="field[<?php echo $col->section_column_id ?>][]">
									</td>
							<?php  } else { ?>	
							<td rowspan="">
								<span class="pull-right small text-muted"><a class="pull-right small text-muted" href="javascript:delete_item(<?php echo $items_row->item_id?>, this)"><?=lang('common.delete')?></a></span>
								<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"><?php echo $fields->value?></textarea>
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
								$where_next = array(
									'planning_id' => $planning_id,
									'item' => $row_item->item + 1,
									'section_column_id' => $col->section_column_id,
									'sequence' => $items_row->sequence + 1,
									'parent_id' => 1,
								);
								$items_next = $this->db->get_where('performance_planning_applicable_items_header', $where_next);

								$to_show_button = true;
								if ($items_next && $items_next->num_rows() > 0){
									$to_show_button = false;
								}								
							}						
					?>
							<td rowspan="">
								<span class="pull-right small text-muted"><a class="pull-right small text-muted" href="javascript:delete_item(<?php echo $items_row->item_id?>, this)"><?=lang('common.delete')?></a></span>
								<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"><?php echo $fields->value?></textarea>
								<br />
								<?php if ($to_show_button && in_array($status_id,array(0,1,3))) { ?>
								<span>
		                        	<button class="btn btn-success btn-xs" type="button" onclick="add_item(<?php echo $col->section_column_id ?>, '1', 1,<?php echo $section_id ?>,this)" ><?=lang('appraisal_individual_planning.add_item')?></button>
		                        </span>	
		                        <?php  } ?>								
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

						echo '<td class="childItem-'.$items_row->item_id.'"><input type="text" class="form-control weight" name="field['.$col->section_column_id.'][]" value="'.$fields->value.'"></td>';
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
								<select class="form-control" name="field['.$col->section_column_id.'][]" readonly>';
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