<div class="panel-body">
	<a href="javascript:add_column( <?php echo $section_id?>, '' )" class="btn green btn-xs">Add Column</a>
	<!-- <a href="#" class="btn red btn-xs">Delete</a>      -->
</div>
<?php
	$qry = "select a.*, b.uitype
	FROM {$this->db->dbprefix}performance_template_section_column a
	LEFT JOIN {$this->db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
	WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
	ORDER BY a.sequence";
	$columns = $this->db->query( $qry );
?>
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr><?php
				foreach( $columns->result() as $row ) : ?>
					<th width="<?php echo $row->width?>%">
						<a class="" href="javascript:add_column( <?php echo $section_id?>, <?php echo $row->section_column_id?> )"><?php echo $row->title?></a><br/>
						<span class="small text-muted">
	                       <a class="small text-muted" href="javascript:delete_column('<?php echo $row->section_column_id?>')">Delete</a>
	                    </span>
					</th> <?php
				endforeach; ?>
			</tr>	
		</thead>
		<tbody class="get-section section-<?php echo $section_id ?>" section="<?php echo $section_id ?>">
			<tr class="first-row"><?php
				$first = true;
				foreach( $columns->result() as $row ) :
					echo '<td>';
					switch( $row->uitype_id )
					{
						case 4:
							if( $first )
							{
								echo '<button class="btn btn-success btn-xs" onclick="add_item('.$row->section_column_id.', \'\', \'\')" type="button">Add Row</button>';
							}
							$first = false;
							break;
						default;
							break;
					}
					echo '</td>';
				endforeach; ?>
			</tr>
		</tbody>
	</table>
</div>