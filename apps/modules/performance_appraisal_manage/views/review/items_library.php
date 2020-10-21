<?php
	$rows = array();
	$rows_multi = array();
	$qry = "select a.*, b.uitype
	FROM {$this->db->dbprefix}performance_template_section_column a
	LEFT JOIN {$this->db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
	WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
	ORDER BY a.sequence";
	$columns = $db->query( $qry );
	$first = true;
	foreach( $columns->result() as $row ) :
		if( $row->uitype_id == 4 )
		{
			//get items
			$where = array(
				'section_column_id' => $row->section_column_id
			);
			
			$items = $this->db->get_where('performance_template_section_column_item', $where);
			foreach( $items->result() as $item )
			{
				//check if has children
				$item->column_id = $row->section_column_id;
				$item->children = array();
				$children = $this->db->get_where('performance_template_section_column_item', array('parent_id' => $item->item_id));
				if( $children->num_rows() > 0 )
				{
					$item->children = $children->result();
				}

				$rows[] = $item;
			}
					
			$first = false;
		}

		if( !$first )
		{
			break;
		}
	endforeach;
	
	//build each parent row first then subrows
	foreach( $rows as $row )
	{
		$tripart = false;
		if($row->tripart) $tripart = true;
		$size = sizeof( $row->children );
		echo '<tr>';
		foreach( $columns->result() as $col )
		{
			switch( $col->uitype_id )
			{
				case 3: 
					if( $size > 0 )
					{
						$child = $row->children[0];
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $child->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						} ?>
						<td>
							<textarea class="form-control required_field" rows="1" name="appraisal_field[<?php echo $col->section_column_id?>][<?php echo $child->item_id?>]"><?php echo $value?></textarea>
						</td>
						<?php
					}
					else{
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $row->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
						if($tripart){ ?>
							<td>
								<table class="table">
									<thead>
										<tr>
											<td width="30%">&nbsp;</td>
											<td width="50%"><?=lang('performance_appraisal_manage.programs')?></td>
											<td width="20%"><?=lang('performance_appraisal_manage.target_date')?></td>
										</tr>
									</thead>
									<tbody class="tripart-<?php echo $row->item_id?>"> <?php
										$library = $this->db->get_where('performance_setup_library', array('deleted' => 0));
										$qry = "select a.*, b.library
										FROM {$this->db->dbprefix}performance_appraisal_pdp a
										LEFT JOIN {$this->db->dbprefix}performance_setup_library b on b.library_id=a.library_id
										WHERE a.appraisal_id = {$appraisal_id}
										AND a.user_id = {$user_id}
										AND a.item_id = {$row->item_id}
										AND column_id = {$col->section_column_id}
										";
										$pdps = $this->db->query( $qry );
										foreach( $pdps->result() as $pdp ):?>
											<tr>
											<td>
												<select name="pdp_library[<?php echo $row->item_id?>][<?php echo $col->section_column_id?>][]" class="form-control select2me" data-placeholder="Select...">
										       	<?php foreach($library->result() as $lib):?>
										       		<option value="<?php echo $lib->library_id?>" <?php if($lib->library_id == $pdp->library_id) echo 'selected'?>><?php echo $lib->library?></option>
										      	<?php endforeach;?>
										        </select>
										        <br>
												<span class="small text-muted">
													<a class="small text-muted" href="javascript:remove_pdp( $(this) )"><?=lang('common.delete')?></a>
												</span>
											</td>
											<td>
												<textarea name="pdp_comment[<?php echo $row->item_id?>][<?php echo $col->section_column_id?>][]" rows="3" class="form-control required_field"><?php echo $pdp->comment?></textarea>
											</td>
											<td>
												<div class="input-group input-medium">
													<input type="text" size="16" class="form-control" name="pdp_date[<?php echo $row->item_id?>][<?php echo $col->section_column_id?>][]" value="<?php echo $pdp->date?>">
												</div>
											</td>
										</tr> <?php
										endforeach;
									?>
									</tbody>
								</table>
								<span>
                                	<button class="btn btn-success btn-xs" type="button" onclick="add_tripart(<?php echo $col->section_column_id?>, <?php echo $row->item_id?>)"><?=lang('performance_appraisal_manage.add_new_line')?></button>
                                </span>	
							</td> <?php
						}
						else{ ?>
							<td>
								<textarea class="form-control required_field" rows="1" name="appraisal_field[<?php echo $col->section_column_id?>][<?php echo $row->item_id?>]"><?php echo $value?></textarea>
							</td><?php
						}
					}
					break;
				case 4:
					if( $row->column_id == $col->section_column_id )
					{ ?>
						<td rowspan="<?php echo ($size > 0 ? $size : 1) ?>">
							<textarea class="form-control" rows="4" name="item[<?php echo $row->item_id?>]" readonly><?php echo $row->item?></textarea>
						</td> <?
					}
					else{
						//children
						if( $size > 0 )
						{
							$child = $row->children[0];  ?>
							<td>
								<textarea class="form-control" rows="1" name="item[<?php echo $child->item_id?>]"  readonly><?php echo $child->item?></textarea>
							</td> <?
						}
						else{ ?>
							<td></td><?php
						}
					}
					break;
				case 5:
					$value = "";
					if( $size > 0 )
					{
						$child = $row->children[0];
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $child->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
					}
					else{
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $row->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
					}

					$ratings = $this->db->get_where('performance_setup_rating_score', array('status_id' => 1, 'rating_group_id' => $col->rating_group_id));
					$options = array();
					$options[] = '<option value="" score="0">Select...</option>';
					foreach( $ratings->result() as $rating )
					{
						$options[] = '<option value="'.$rating->rating_score_id.'" score="'.$rating->rating_score.'" '.($value == $rating->rating_score_id ? 'selected="selected"' : '').'>'. $rating->score .'</option>';
					}

					if( $size > 0 )
					{
						echo '<td><select name="appraisal_field['.$col->section_column_id.']['.$child->item_id.']" class="rating-field required_select">';
					}
					else{
						echo '<td><select name="appraisal_field['.$col->section_column_id.']['.$row->item_id.']" class="rating-field required_select">';	
					}
					echo implode('', $options);
					echo '</select></td>';
					break;
				case 6:
					if( $size > 0 )
					{
						$child = $row->children[0];
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $child->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
						echo '<td><input type="text" class="form-control weighted_rating-field" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';
					}
					else{
						$where = array(
							'appraisal_id' => $appraisal_id,
							'user_id' => $user_id,
							'item_id' => $row->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_appraisal_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}

						echo '<td><input type="text" class="form-control weighted_rating-field" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'"></td>';
					}
					break;
				case 7: //weight
					if( $size > 0 )
					{
						$child = $row->children[0];
						$where = array(
							'item_id' => $child->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_template_section_column_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
						echo '<td><input type="text" class="form-control weight-field" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'" readonly></td>';
					}
					else{
						$where = array(
							'item_id' => $row->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_template_section_column_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}

						echo '<td><input type="text" class="form-control weight-field" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'" readonly></td>';
					}
					break;
				default:
					echo '<td></td>';
			}
		}
		echo '</tr>';	
		if( $size > 0 )
		{
			for($i=1;$i<$size;$i++)
			{
				echo '<tr>';
				$child = $row->children[$i];
				foreach( $columns->result() as $col ){
					switch( $col->uitype_id )
					{
						case 3: //textarea
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							} ?>
							<td>
								<textarea class="form-control required_field" rows="1" name="appraisal_field[<?php echo $col->section_column_id?>][<?php echo $child->item_id?>]"><?php echo $value?></textarea>
							</td> <?php
							break;
						case 4:
							if( $row->column_id != $col->section_column_id )
							{ ?>
								<td>
									<textarea class="form-control" rows="1" name="item[<?php echo $child->item_id?>]" readonly><?php echo $child->item?></textarea>
								</td> <?php
							}
							break;
						case 5:
							$value = "";
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_fields', $where);
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}
							$ratings = $this->db->get_where('performance_setup_rating_score', array('status_id' => 1, 'rating_group_id' => $col->rating_group_id));
							$options = array();
							$options[] = '<option value="" score="0">Select...</option>';
							foreach( $ratings->result() as $rating )
							{
								$options[] = '<option value="'.$rating->rating_score_id.'" score="'.$rating->rating_score.'" '.($value == $rating->rating_score_id ? 'selected="selected"' : '').'>'. $rating->score .'</option>';
							}

							echo '<td><select name="appraisal_field['.$col->section_column_id.']['.$child->item_id.']" class="rating-field required_select">';
							echo implode('', $options);
							echo '</select></td>';
							break;
						case 6:
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}
							echo '<td><input type="text" class="form-control" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';	
							break;
						case 7:
							$where = array(
								'planning_id' => $planning_id,
								'user_id' => $user_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_planning_applicable_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}
							echo '<td><input type="text" class="form-control weight-field" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'" readonly></td>';
							break;
						default:
							echo '<td></td>';
					}
				}
				echo '</tr>';
			}	
		}
	}

	$show_total = false;
	foreach( $columns->result() as $col )
	{
		switch( $col->uitype_id )
		{
			case 5:
			case 6:
			case 7:
				$show_total = true;
				break;
		}
	}
	$result = $columns->result();
	if( $show_total )
	{
		echo '<tr class="total-row warning">';
		echo '<td colspan="'.(sizeof($result)-2).'" ></td>';
		echo '<td align="right">AVERAGE RATING</td>';
		echo '<td><input type="text" readonly="" name="section_avg_rating" section_id="'.$section_id.'" class="form-control section_avg_rating"></td>';
		echo '</tr>';
		echo '<tr class="total-row warning">';
		echo '<td colspan="'.(sizeof($result)-2).'" ></td>';
		echo '<td align="right">WEIGHT</td>';
		echo '<td align="right"><input type="text" name="section_weight_rating" value="'.$section->weight.'%" readonly="" section_id="'.$section_id.'" class="form-control section_weight"></td>';
		echo '</tr>';
		echo '<tr class="total-row success">';
		echo '<td colspan="'.(sizeof($result)-2).'" ></td>';
		echo '<td align="right">WEIGHTED AVERAGE RATING</td>';
		echo '<td align="right"><input type="text" name="section_wgtave_rating" readonly="" section_id="'.$section_id.'" class="form-control section_war weight_rating-total"></td>';
		echo '</tr>';
		/*$result = $columns->result();
		foreach( $result as $index => $col )
		{
			switch( true )
			{
				case $index == sizeof($result)-4:
					echo '<td align="right">WEIGHT</td>';
					break;
				case $index == sizeof($result)-3:
					echo '<td align="right"><input type="text" value="10%" readonly="" section_id="'.$section_id.'" class="form-control section_weight"></td>';
					break;
				case $index == sizeof($result)-2:
					echo '<td align="right">AVERAGE RATING</td>';
					break;
				case $index == sizeof($result)-1:
					echo '<td><input type="text" readonly="" section_id="'.$section_id.'" class="form-control section_avg_rating"></td>';
					break;
				default:
					echo '<td></td>';	
			}
		}
		*/
	}		