<?php
	$rows = array();
	$rows_multi = array();
	$qry = "select a.*, b.uitype
	FROM {$db->dbprefix}performance_template_section_column a
	LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
	WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
	ORDER BY a.sequence";
	$columns = $db->query( $qry );

	echo '<tr>';
	foreach( $columns->result() as $col )
	{
	?>
		<input type="hidden" class="form-control" name="item[<?php echo $col->section_column_id ?>][]" value="<?php echo (isset($parent_id) && $parent_id == 1 ? 1 : 0) ?>">
	<?php
		switch( $col->uitype_id )
		{
			case 3:
				?>
					<td rowspan="">
						<?php
						if (!$col->readonly) { ?>
							<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
						<?php } ?>
						<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]" <?php echo ($col->readonly ? 'readonly' : '') ?>></textarea>
					</td> <?php
				break;	
			case 11:
					if (isset($parent_id) && $parent_id != 1) {
				?>
					<td rowspan="">
						<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
						<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"></textarea>
					</td> <?php } else { ?>
					<td style='border-top:none'>
						<input type="hidden" name="field[<?php echo $col->section_column_id ?>][]">
					</td>
					<?php }
				break;									
			case 4: ?>
					<td rowspan="">
						<label>
							<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
							<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"></textarea>
							<br />
						</label>
						<span>
                        	<button class="btn btn-success btn-xs" onclick="add_item(<?php echo $col->section_column_id ?>, '', 1,<?php echo $section_id ?>,this)" type="button" ><?=lang('appraisal_individual_planning.add_item')?></button>
                        </span>								
					</td> <?php
				break;
			case 7: //weight
				$where = array(
					'planning_id' => $planning_id,
					'user_id' => $user_id,
					'item_id' => $row->item_id,
					'section_column_id' => $col->section_column_id
				);
				$checked = $this->db->get_where('performance_planning_applicable_fields', $where);
				$value = "";
				if($checked->num_rows() > 0)
				{
					$value = $checked->row()->value;
				}
				echo '<td class="childItem-'.$child->item_id.'"><input type="text" class="form-control weight" name="field['.$col->section_column_id.'][]" value=""></td>';
				break;
			case 9: //dropdown
				echo '<td class="childItem-'.$child->item_id.'">
						<select class="form-control" name="field['. $col->section_column_id .'][]" readonly>';
							echo '<option value="">Select</option>';
							for ($i=1; $i < 11; $i++) { 
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							
						echo '</select>
					  </td>';
				break;
			case 5: //rating
				echo '<td><input type="text" class="form-control dontserializeme" name="field['. $col->section_column_id .'][]" readonly></td>';
				break;				
			default:
				echo '<td><input type="text" class="form-control dontserializeme" name="field['. $col->section_column_id .'][]></td>';
		}
	}
	echo '</tr>';	
?>