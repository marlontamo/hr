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
	foreach( $columns->result() as $row ) :
		if( $row->uitype_id == 4 )
		{
			//get items
			$where = array(
				'section_column_id' => $row->section_column_id, 
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
		$size = sizeof( $row->children );
		echo '<tr>';
		foreach( $columns->result() as $col )
		{
			switch( $col->uitype_id )
			{
				case 4:
					if( $row->column_id == $col->section_column_id )
					{ ?>
						<td rowspan="<?php echo ($size > 0 ? $size : 1) ?>">
							<textarea class="form-control dontserializeme" rows="4" name="item[<?php echo $row->item_id?>]" readonly><?php echo $row->item?></textarea>
						</td> <?php
					}
					else{
						//children
						if( $size > 0 )
						{
							$child = $row->children[0];  ?>
							<td class="childItem-<?php echo $child->item_id?>">
								<textarea class="form-control dontserializeme" rows="1" name="item[<?php echo $child->item_id?>]" readonly><?php echo $child->item?></textarea>
								<?php if( $size == 1 && $col->max_items > 1 && !empty($col->max_items) ){ ?>
								<br/>
								<span>
                                	<button class="btn btn-success btn-xs" type="button" onclick="add_item(<?php echo $col->section_column_id?>,  '', <?php echo $row->item_id?>)" ><?=lang('appraisal_individual_planning.add_item')?></button>
                                </span><?php
								} ?>

							</td> <?php
						}
						else{ ?>
							<td>
								<span>
                                	<button class="btn btn-success btn-xs" type="button" onclick="add_item(<?php echo $col->section_column_id?>,  '', <?php echo $row->item_id?>)" ><?=lang('appraisal_individual_planning.add_item')?></button>
                                </span>
							</td><?php
						}
					}
					break;
				case 7: //weight
					if( $size > 0 )
					{
						$child = $row->children[0];
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
						echo '<td class="childItem-'.$child->item_id.'"><input type="text" class="form-control weight" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';
					}
					else{
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
						echo '<td class="childItem-'.$child->item_id.'"><input type="text" class="form-control weight" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'"></td>';
					}
					break;
				default:
					echo '<td><input type="text" class="form-control dontserializeme" readonly></td>';
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
						case 4:
							if( $row->column_id != $col->section_column_id )
							{ ?>
								<td class="childItem-<?php echo $child->item_id?>">
									<textarea class="form-control dontserializeme dontserializeme" rows="1" name="item[<?php echo $child->item_id?>]" readonly><?php echo $child->item?></textarea>
									<?php if( $i == ($size-1) && ( !empty($col->max_items) && $col->max_items > $size) && $to_user_id == $user_id){ ?>
									<br/>
									<span>
	                                	<button class="btn btn-success btn-xs" type="button" onclick="add_item(<?php echo $col->section_column_id?>,  '', <?php echo $row->item_id?>)" ><?=lang('appraisal_individual_planning.add_item')?></button>
	                                </span><?php
									} ?>
								</td> <?php
							}
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
							echo '<td class="childItem-'.$child->item_id.'"><input type="text" class="form-control weight" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';
							break;
						default:
							echo '<td></td>';
					}
				}
				echo '</tr>';
			}	
		}
	}