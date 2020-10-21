<table class="table table-bordered table-striped">
	<tbody>
		<tr class="success">
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">Requested By</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['requisition.requested_by'] }}" disabled>
					</div>
				</div>
			</td>
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">Department</label>
					<div class="col-md-9">
						<input type="text" class="form-control"  value="{{ $record['requisition.department'] }}" disabled>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">Project Name</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['requisition.project_name'] }}" disabled>
					</div>
				</div>
			</td>
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">PR #</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['record_id'] }}" disabled>
					</div>
				</div>
			</td>
		</tr>
		<tr class="success">
			<td >
				<div class="form-group">
					<label class="control-label col-md-3 bold">Urgency</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['requisition.priority'] }}" disabled>
					</div>
				</div>
			</td>
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">Approver</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['requisition.approver'] }}" disabled>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>