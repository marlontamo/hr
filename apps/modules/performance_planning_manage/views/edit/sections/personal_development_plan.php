
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th width="30%">PERSONAL DEVELOPMENT PLAN</th>
				<th width="70%" colspan="3">DESCRIPTION</th>
			</tr>
		</thead>	
		<tbody class="get-section section-4" section="4" style="position: static;">
			<?php
				$db->where('planning_id',$planning_id);
				$db->where('template_section_id',$section_id);
				$db->group_by('item');
				$db->join('performance_template_section_column','performance_planning_applicable_items_header.section_column_id = performance_template_section_column.section_column_id','left');
				$row_item_result = $db->get('performance_planning_applicable_items_header');

				if ($row_item_result && $row_item_result->num_rows() > 0){
					foreach ($row_item_result->result() as $row_item) {	
						$where = array(
							'performance_planning_applicable_fields_header.planning_id' => $planning_id,
							'template_section_id' => $section_id,
							'item' => $row_item->item
						);
						$db->join('performance_planning_applicable_items_header','performance_planning_applicable_fields_header.item_id = performance_planning_applicable_items_header.item_id','left');			
						$db->join('performance_template_section_column','performance_planning_applicable_fields_header.section_column_id = performance_template_section_column.section_column_id','left');
						$items = $this->db->get_where('performance_planning_applicable_fields_header', $where);		
						if ($items && $items->num_rows() > 0){
							$items_array = $items->result_array();			
			?>			
							<tr>	
								<input type="hidden" class="form-control" name="item[13][]">				
								<td><textarea class="form-control" rows="4" name="field[13][]"><?php echo (isset($items_array[0]['value']) ? $items_array[0]['value'] : '') ?></textarea></td>
								<input type="hidden" class="form-control" name="item[14][]">
								<td colspan="3"><textarea class="form-control" rows="4" name="field[14][]"><?php echo (isset($items_array[1]['value']) ? $items_array[1]['value'] : '') ?></textarea></td>
							</tr>
							<tr>
								<input type="hidden" class="form-control" name="item[15][]">
								<td width="30%" style='border-top:none' rowspan="2"><textarea class="form-control" rows="4" name="field[15][]"><?php echo (isset($items_array[2]['value']) ? $items_array[2]['value'] : '') ?></textarea></td>
								<td width="15%" style='border-top:none'></td>
								<td width="35%" style='border-top:none'>Program Courses</td>
								<td width="20%" style='border-top:none'>Timeline</td>				
							</tr>				
							<tr>
								<input type="hidden" class="form-control" name="item[16][]">
								<td width="15%">
									<select class="form-control" name="field[16][]">
										<option value=""></option>
									</select>					
								</td>
								<input type="hidden" class="form-control" name="item[17][]">
								<td width="35%"><textarea class="form-control" rows="4" name="field[17][]"><?php echo (isset($items_array[4]['value']) ? $items_array[4]['value'] : '') ?></textarea></td>
								<input type="hidden" class="form-control" name="item[18][]">
								<td width="20%"><textarea class="form-control" rows="4" name="field[18][]"><?php echo (isset($items_array[5]['value']) ? $items_array[5]['value'] : '') ?></textarea></td>				
							</tr>
			<?php
						}
					}
				}
				else {
			?>
					<tr>
						<input type="hidden" class="form-control" name="item[13][]">				
						<td><textarea class="form-control" rows="4" name="field[13][]"></textarea></td>
						<input type="hidden" class="form-control" name="item[14][]">
						<td colspan="3"><textarea class="form-control" rows="4" name="field[14][]"></textarea></td>
					</tr>
					<tr>
						<input type="hidden" class="form-control" name="item[15][]">
						<td width="30%" style='border-top:none' rowspan="2"><textarea class="form-control" rows="4" name="field[15][]"></textarea></td>
						<td width="15%" style='border-top:none'></td>
						<td width="35%" style='border-top:none'>Program Courses</td>
						<td width="20%" style='border-top:none'>Timeline</td>				
					</tr>				
					<tr>
						<input type="hidden" class="form-control" name="item[16][]">
						<td width="15%">
							<select class="form-control" name="field[16][]" readonly>
								<option value=""></option>
							</select>					
						</td>
						<input type="hidden" class="form-control" name="item[17][]">
						<td width="35%"><textarea class="form-control" rows="4" name="field[17][]"></textarea></td>
						<input type="hidden" class="form-control" name="item[18][]">
						<td width="20%"><textarea class="form-control" rows="4" name="field[18][]"></textarea></td>				
					</tr>
		<!-- 			<tr>
						<td style='border-top:none'>&nbsp;</td>
						<td width="15%">
							<select class="form-control" name="field[4][]" readonly>
								<option value=""></option>
							</select>					
						</td>
						<td width="35%"><textarea class="form-control" rows="4" name="field[5][]"></textarea></td>
						<td width="20%"><textarea class="form-control" rows="4" name="field[6][]"></textarea></td>				
					</tr> -->
					<tr class="first-row">
						<td width="30%" style='border-top:none'>&nbsp;</td>
						<td width="70%" colspan="3" style='border-top:none'><button class="btn btn-success btn-xs add-kra add-kra-'.$row->section_column_id.'" onclick="add_item" type="button">Add Item</button></td>				
					</tr>
					<!-- Next Line-->	
					<tr>
						<input type="hidden" class="form-control" name="item[13][]">				
						<td><textarea class="form-control" rows="4" name="field[13][]"></textarea></td>
						<input type="hidden" class="form-control" name="item[14][]">
						<td colspan="3"><textarea class="form-control" rows="4" name="field[14][]"></textarea></td>
					</tr>
					<tr>
						<input type="hidden" class="form-control" name="item[15][]">
						<td width="30%" style='border-top:none' rowspan="2"><textarea class="form-control" rows="4" name="field[15][]"></textarea></td>
						<td width="15%" style='border-top:none'></td>
						<td width="35%" style='border-top:none'>Program Courses</td>
						<td width="20%" style='border-top:none'>Timeline</td>				
					</tr>				
					<tr>
						<input type="hidden" class="form-control" name="item[16][]">
						<td width="15%">
							<select class="form-control" name="field[16][]" readonly>
								<option value=""></option>
							</select>					
						</td>
						<input type="hidden" class="form-control" name="item[17][]">
						<td width="35%"><textarea class="form-control" rows="4" name="field[17][]"></textarea></td>
						<input type="hidden" class="form-control" name="item[18][]">
						<td width="20%"><textarea class="form-control" rows="4" name="field[18][]"></textarea></td>				
					</tr>
					<tr class="first-row">
						<td width="30%" style='border-top:none'>&nbsp;</td>
						<td width="70%" colspan="3" style='border-top:none'><button class="btn btn-success btn-xs add-kra add-kra-'.$row->section_column_id.'" onclick="add_item" type="button">Add Item</button></td>				
					</tr>	
				<?php } ?>	
		</tbody>			
	</table>
</div>