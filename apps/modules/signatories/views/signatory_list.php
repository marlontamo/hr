<div class="portlet-body">	
	<table class="table table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th width="1%"><input type="checkbox" class="group-checkable" data-set=".record-checker"></th>
				<th width="40%">Approver</th>
				<th width="18%" class="hidden-xs">Condition</th>
				<th width="17%" class="hidden-xs">Sequence</th>
				<th width="24%">Actions</th>
			</tr>
		</thead>
		<tbody> <?php
			foreach( $signatories as $signatory ): ?>
				<tr rel="0">
					<td><input type="checkbox" class="record-checker checkboxes" value="<?php echo $signatory->id?>" /></td>
					<td>
						<a id="date_name" href="#" class="text-success"><?php echo $signatory->alias?></a>
					</td>
					<td class="hidden-xs">
						<?php echo $signatory->condition ?>
					</td>
					<td class="hidden-xs">
						<?php echo $signatory->sequence ?>
					</td>
					<td>
						<div class="btn-group">
							<a class="btn btn-xs text-muted" href="javascript: edit_signatory(<?php echo $signatory->id?>)"><i class="fa fa-pencil"></i> Edit</a>
						</div>
						<div class="btn-group">
							<a class="btn btn-xs text-muted" href="javascript: delete_signatory(<?php echo $signatory->id?>)"><i class="fa fa-trash-o"></i> Delete</a>
						</div>
					</td>
				</tr><?php
			endforeach; ?>
		</tbody>
	</table>
</div>