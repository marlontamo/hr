<?php
	$rows = array();
	$rows_multi = array();
	$qry = "select a.*, b.uitype, c.section_type_id
	FROM {$db->dbprefix}performance_template_section_column a
	LEFT JOIN {$db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
	LEFT JOIN {$db->dbprefix}performance_template_section c on c.template_section_id = a.template_section_id
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
		$first_col = true;
		$first_tripart = true;
		echo '<tr>';
		foreach( $columns->result() as $col )
		{
		
			if($col->section_type_id == 4 && $first_col){
?>
				<td >&nbsp;
				</td>
<?php
			}
			$first_col = false;
			switch( $col->uitype_id )
			{
				case 4:
					if( $row->column_id == $col->section_column_id )
					{ ?>
						<td rowspan="<?php echo ($size > 0 ? $size : 1) ?>">
							<span class="pull-right small text-muted"><a class="pull-right small text-muted" >Delete</a></span>
							<textarea disabled class="form-control" rows="4" name="item[<?php echo $row->item_id?>]"><?php echo $row->item?></textarea>
						</td> <?php
					}
					else{
						//children
						if( $size > 0 )
						{
							$child = $row->children[0];  ?>
							<td>
								<span class="pull-right small text-muted"><a class="pull-right small text-muted" >Delete</a></span>
								<textarea class="form-control" disabled rows="1" name="item[<?php echo $child->item_id?>]"><?php echo $child->item?></textarea>
								<?php if( $size == 1 ){ ?>
								<br/>
								<span>
                                	<button class="btn btn-success btn-xs" type="button"  >Add Item</button>
                                </span><?php
								} ?>

							</td> <?php
						}
						else{ ?>
							<td>
								<span>
                                	<button class="btn btn-success btn-xs" type="button" >Add Item</button>
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
							'item_id' => $child->item_id,
							'section_column_id' => $col->section_column_id
						);
						$checked = $this->db->get_where('performance_template_section_column_fields', $where);
						$value = "";
						if($checked->num_rows() > 0)
						{
							$value = $checked->row()->value;
						}
						echo '<td><input disabled type="text" class="form-control" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';
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
						echo '<td><input disabled type="text" class="form-control" name="field['.$col->section_column_id.']['.$row->item_id.']" value="'.$value.'"></td>';
					}
					break;
				default:
					echo '<td></td>';
			}
			if($row->tripart && $first_tripart){
?>
	<td>
		<table class="table">
			<thead>
				<tr>
					<td width="30%">&nbsp;</td>
					<td width="50%">Programs/Courses</td>
					<td width="20%">Timeline</td>
				</tr>
			</thead>
			<tbody class="tripart-6">
				<tr>
					<td>
						<select data-placeholder="Select..." class="form-control select2me" name="pdp_library[6][19][]">
						</select>
						<br>
						<span class="small text-muted">
							<a class="small text-muted">Delete</a>
						</span>
					</td>
					<td>
						<textarea class="form-control" rows="3" name="pdp_comment[6][19][]"></textarea>
					</td>
					<td>
						<div data-date-format="MM dd, yyyy" class="input-group input-medium date date-picker">
							<input type="text" name="pdp_date[6][19][]" class="form-control" size="16">
							<span class="input-group-btn">
								<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<span>
        	<button type="button" class="btn btn-success btn-xs">Add New Line</button>
        </span>
		</td>
<?php
		$first_tripart = false;
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
								<td>
									<span class="pull-right small text-muted"><a class="pull-right small text-muted" >Delete</a></span>
									<textarea disabled class="form-control" rows="1" name="item[<?php echo $child->item_id?>]"><?php echo $child->item?></textarea>
									<?php if( $i == ($size-1) ){ ?>
									<br/>
									<span>
	                                	<button class="btn btn-success btn-xs" type="button" >Add Item</button>
	                                </span><?php
									} ?>
								</td> <?php
							}
							break;
						case 7:
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
							echo '<td><input disabled type="text" class="form-control" name="field['.$col->section_column_id.']['.$child->item_id.']" value="'.$value.'"></td>';
							break;
						default:
							echo '<td></td>';
					}
				}
				echo '</tr>';
			}	
		}
	}	