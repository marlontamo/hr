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
	
	//get contributors
	$qry = "select a.*, b.full_name, d.position
	FROM {$this->db->dbprefix}performance_appraisal_contributor a
	LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.contributor_id
	LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.contributor_id
	LEFT JOIN {$this->db->dbprefix}users_position d on d.position_id = c.position_id
	WHERE a.appraisal_id = {$appraisal_id} AND a.user_id = {$user_id} AND a.template_section_id = {$section_id}";
	$contributors = $this->db->query($qry)->result();
	
	foreach( $contributors as $index => $contributor ){
		$first = true;
		//build each parent row first then subrows
		foreach( $rows as $row )
		{
			$size = sizeof( $row->children ); ?>
			<tr>
				<td class="contributor contributor-<?php echo $contributor->contributor_id?>" contributor_id="<?php echo $contributor->contributor_id?>">
					<p class="bold">Crowdsource <?php echo ($index+1)?>:</p>
					<?php echo $contributor->full_name?>
					<br>
					<span class="small text-muted"><?php echo $contributor->position?></span>
					<div class="btn-grp">
						<a href="javascript:cs_discussion_form(<?php echo $appraisal_id?>, <?php echo $section_id?>, <?php echo $user_id?>, <?php echo $contributor->contributor_id?>, false,0)" class="btn btn-info btn-xs"> Discussion logs</a>
       				</div>	
				</td> <?php
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
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							} ?>
							<td>
								<textarea class="form-control" rows="1" name="xappraisal_field[<?php echo $col->section_column_id?>][<?php echo $child->item_id?>]" readonly><?php echo $value?></textarea>
							</td>
							<?php
						}
						else{
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $row->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							} ?>
							<td>
								<textarea class="form-control" rows="1" name="xappraisal_field[<?php echo $col->section_column_id?>][<?php echo $row->item_id?>]" readonly><?php echo $value?></textarea>
							</td><?php
						}
						break;
					case 4:
						if( $row->column_id == $col->section_column_id )
						{ ?>
							<td rowspan="<?php echo ($size > 0 ? $size : 1) ?>">
								<?php echo $row->item?>
							</td> <?
						}
						else{
							//children
							if( $size > 0 )
							{
								$child = $row->children[0];  ?>
								<td>
									<textarea class="form-control" rows="1" name="item[<?php echo $child->item_id?>]" readonly><?php echo $child->item?></textarea>
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
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}
						}
						else{
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $row->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
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
							echo '<td><select name="xappraisal_field['.$col->section_column_id.']['.$child->item_id.']" class="rating-field rating-field-'.$contributor->contributor_id.'-'.$section_id.'" cs_combo="'.$contributor->contributor_id.'-'.$section_id.'" item_id="'.$child->item_id.'" disabled>';
						}
						else{
							echo '<td><select name="xappraisal_field['.$col->section_column_id.']['.$row->item_id.']" class="rating-field rating-field-'.$contributor->contributor_id.'-'.$section_id.'" cs_combo="'.$contributor->contributor_id.'-'.$section_id.'" item_id="'.$row->item_id.'" disabled>';	
						}
						echo implode('', $options);
						echo '</select></td>';
						break;
					/*case 6:
						if( $size > 0 )
						{
							$child = $row->children[0];
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $child->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}
							echo '<td><input type="text" class="form-control" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'" contributor_id="'.$contributor->contributor_id.'" readonly></td>';
						}
						else{
							$where = array(
								'appraisal_id' => $appraisal_id,
								'user_id' => $user_id,
								'contributor_id' => $contributor->contributor_id,
								'item_id' => $row->item_id,
								'section_column_id' => $col->section_column_id
							);
							$checked = $this->db->get_where('performance_appraisal_contributor_fields', $where);
							$value = "";
							if($checked->num_rows() > 0)
							{
								$value = $checked->row()->value;
							}

							echo '<td><input type="text" class="form-control" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'" contributor_id="'.$contributor->contributor_id.'" readonly></td>';
						}
						break;*/
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
							echo '<td><input type="text" class="form-control" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'" readonly></td>';
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

							echo '<td><input type="text" class="form-control" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'" readonly></td>';
						}
						break;
				}
			}
			if( $first ) :?>
				<td class="contributor-total contributor-total-<?php echo $contributor->contributor_id?>" section_id="<?php echo $section_id?>" contributor_id="<?php echo $contributor->contributor_id?>">
					<input type="text" class="contributor-total form-control weighted_rating-field-<?php echo $contributor->contributor_id?>-<?php echo $section_id?>" section_id="<?php echo $section_id?>" name="total-<?php echo $contributor->contributor_id?>" readonly>
				</td><?php 
				$first = false;
			endif;?>
			</tr> <?
		}
	}

	$show_total = false;
	foreach( $columns->result() as $col )
	{
		switch( $col->uitype_id )
		{
			case 6:
				$show_total = true;
				break;
		}
	}

	if( $show_total )
	{
		foreach( $rows as $rindex => $row )
		{
			echo '<tr>';
			
			if( $rindex == 0 )
				echo '<td rowspan="'.sizeof($rows).'" align="right">AVERAGE RATING/AREA</td>';
			
			$result = $columns->result();
			foreach( $result as $index => $col )
			{
				$nxtcol = isset($result[$index+1]) ? $result[$index+1] : false;
				switch( $col->uitype_id )
				{
					case 5:
						echo '<td><input type="text" class="form-control average-cs-rating" item_id="'.$row->item_id.'" readonly></td>';
						break;
					case 6:
						switch( $rindex )
						{
							case 0:
								echo '<td><input type="text" class="form-control section_cs_avg_rating" section_id="'.$section_id.'" readonly></td>';
								break;
							case 1:
								echo '<td><input type="text" class="form-control section_cs_weight" section_id="'.$section_id.'" readonly value="'.$section->weight.'%"></td>';
								break;
							case 2:
								echo '<td><input type="text" class="form-control section_cs_war weight_rating-total" section_id="'.$section_id.'" readonly></td>';
								break;
							default:
								echo '<td></td>';
						}

						if( $rindex == 0 )
							
						break;
					case 7:
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
						echo '<td><input type="hidden" class="form-control average-weight" item_id="'.$row->item_id.'" value="'.$value.'" readonly></td>';
						break;
					default:
						if( $nxtcol && in_array( $nxtcol->uitype_id, array(5) ) )
						{
							echo '<td align="right">'.$row->item.'</td>';
						}
						else{
							switch( $rindex )
							{
								case 0:
									echo '<td align="right" class="warning">AVERAGE RATING</td>';
									break;
								case 1:
									echo '<td align="right" class="warning">WEIGHT</td>';
									break;
								case 2:
									echo '<td align="right" class="success">WEIGHTED AVERAGE RATING</td>';
									break;
								default:
									echo '<td></td>';
							}	
						}
				}
			}
			echo '</tr>';
		}
	}