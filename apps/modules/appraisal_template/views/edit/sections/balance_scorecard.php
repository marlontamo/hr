<div class="panel-body">
	<a href="javascript:add_column( <?php echo $section_id?>, '' )" class="btn green btn-xs">Add Column</a>
	<!-- <a href="#" class="btn red btn-xs">Delete</a>      -->
</div>
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>UI Type</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="section-columns-<?php echo $section_id?>">
	<?php
		$qry = "select a.*, b.uitype
		FROM {$this->db->dbprefix}performance_template_section_column a
		LEFT JOIN {$this->db->dbprefix}performance_template_section_column_uitype b on b.uitype_id = a.uitype_id
		WHERE a.deleted = 0 AND a.template_section_id = {$section_id}
		ORDER BY a.sequence";
		$columns = $this->db->query( $qry );
		foreach( $columns->result() as $row ) : ?>
			<tr>
				<td><?php echo $row->sequence?></td>
				<td><?php echo $row->title?></td>
				<td><?php echo $row->uitype?></td>
				<td>
					<a class="" href="javascript:add_column( <?php echo $section_id?>, <?php echo $row->section_column_id?> )">Edit</a>
					<a class="" href="javascript:delete_column( <?php echo $row->section_column_id?> )">Delete</a>
				</td>
			</tr>
		<?php
		endforeach;
	?>		
	</tbody>
</table>