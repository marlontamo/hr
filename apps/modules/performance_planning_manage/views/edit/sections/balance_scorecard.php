<?php
$qry = "select a.*, b.uitype
FROM {$db->dbprefix}performance_template_section_column a
LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
ORDER BY a.sequence";
$columns = $db->query( $qry );
$show_add = false;
?>

<div class="panel-body">
	<p class="small"><b><?php echo lang('appraisal_individual_planning.standard') ?>:</b><br>
		Below Standard: 1-4 &nbsp;&nbsp;&nbsp;
		Meet Standard - Low: 5-6 &nbsp;&nbsp;&nbsp;
		Meet Standard - High: 7-8 &nbsp;&nbsp;&nbsp;
		Exceed Standard: 9-10
	</p>   
</div>

<?php echo $header ?>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr><?php
				foreach( $columns->result() as $row ) : ?>
					<th width="<?php echo $row->width?>%" ><?php echo $row->title?></th><?php
				endforeach;?>	
			</tr>
		</thead>
		<tbody class="get-section section-<?php echo $section_id ?>" section="<?php echo $section_id ?>">
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
				$db->where('template_section_id',$section_id);
				$db->group_by('item');
				$db->join('performance_template_section_column','performance_planning_applicable_items_header.section_column_id = performance_template_section_column.section_column_id','left');
				$row_item_result = $db->get('performance_planning_applicable_items_header');
				
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
											'item' => $row_item->item,
											'section_column_id' => $col->section_column_id
										);
										$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
										if ($items && $items->num_rows() > 0){
											$items_row = $items->row();

											$where = array(
												'item_id' => $items_row->item_id,
											);
											$items_field = $this->db->get_where('performance_planning_applicable_fields_header', $where);													
											if ($items_field && $items_field->num_rows() > 0){
												$fields = $items_field->row();
											}
										}
									?>
										<td rowspan="">
											<?php
											if (!$col->readonly) { ?>
												<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
											<?php } ?>											
											<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"><?php echo $fields->value ?></textarea>
										</td> <?php
									break;	
								case 11:
										$where = array(
											'planning_id' => $planning_id,
											'item' => $row_item->item,
											'section_column_id' => $col->section_column_id
										);
										$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
										if ($items && $items->num_rows() > 0){
											$items_row = $items->row();

											$where = array(
												'item_id' => $items_row->item_id,
											);
											$items_field = $this->db->get_where('performance_planning_applicable_fields_header', $where);													
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
											<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
											<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"><?php echo $fields->value ?></textarea>
										</td> <?php }
									break;									
								case 4:
										$where = array(
											'planning_id' => $planning_id,
											'item' => $row_item->item,
											'section_column_id' => $col->section_column_id
										);
										$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
										if ($items && $items->num_rows() > 0){
											$items_row = $items->row();

											$where = array(
												'item_id' => $items_row->item_id,
											);
											$items_field = $this->db->get_where('performance_planning_applicable_fields_header', $where);													
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
											<span class="pull-right small text-muted"><a class="pull-right small text-muted delete_item" href="javascript:void(0)"><?=lang('common.delete')?></a></span>
											<textarea class="form-control" rows="4" name="field[<?php echo $col->section_column_id ?>][]"><?php echo $fields->value?></textarea>
											<br />											
											<?php if ($to_show_button) { ?>
											<span>
					                        	<button class="btn btn-success btn-xs" type="button" onclick="add_item(<?php echo $col->section_column_id ?>, '', 1,<?php echo $section_id ?>,this)" ><?=lang('appraisal_individual_planning.add_item')?></button>
					                        </span>	
					                        <?php  } ?>							
										</td> 
								<?php
									break;
								case 7: //weight
									$where = array(
										'planning_id' => $planning_id,
										'item' => $row_item->item,
										'section_column_id' => $col->section_column_id
									);
									$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
									if ($items && $items->num_rows() > 0){
										$items_row = $items->row();

										$where = array(
											'item_id' => $items_row->item_id,
										);
										$items_field = $this->db->get_where('performance_planning_applicable_fields_header', $where);													
										if ($items_field && $items_field->num_rows() > 0){
											$fields = $items_field->row();
										}
									}	

									echo '<td class="childItem-'.$items_row->item_id.'"><input type="text" class="form-control weight" name="field['. $col->section_column_id .'][]" value="'.$fields->value.'"></td>';
									break;
								case 9: //dropdown
									$where = array(
										'planning_id' => $planning_id,
										'item' => $row_item->item,
										'section_column_id' => $col->section_column_id
									);
									$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
									if ($items && $items->num_rows() > 0){
										$items_row = $items->row();

										$where = array(
											'item_id' => $items_row->item_id,
										);
										$items_field = $this->db->get_where('performance_planning_applicable_fields_header', $where);													
										if ($items_field && $items_field->num_rows() > 0){
											$fields = $items_field->row();
										}
									}	
									echo '<td>
											<select class="form-control" name="field['. $col->section_column_id .'][]" readonly>';
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
										'item' => $row_item->item,
										'section_column_id' => $col->section_column_id
									);
									$items = $this->db->get_where('performance_planning_applicable_items_header', $where);					
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
			<tr class="first-row markings">
				<td colspan="2">
					<span class="pull-right bold"><?php echo lang('appraisal_individual_planning.total_weight') ?>:</span>

				</td>
				<td><input type="text" class="form-control" id="total-weight"></td>
				<td colspan="3"></td>
			</tr> <?php
			echo '<tr class="first-row">';
			echo '<td colspan="'.$columns->num_rows().'">';
			$first = true;
			foreach( $columns->result() as $row ) :
				switch( $row->uitype_id )
				{
					case 4:
					case 3:
						if( $first )
						{
							echo '<button class="btn btn-success btn-xs add-kra add-kra-'.$row->section_column_id.'" onclick="add_item('.$row->section_column_id.', \'\', \'\','.$section_id.')" type="button">'.lang('appraisal_individual_planning.add_row').'</button>';
						}
						$first = false;
						break;
					default;
						break;
				}
			endforeach; 
			echo '</td>';
			echo '</tr>'; ?>
		</tbody>
	</table>
</div>
<?php echo $footer ?>