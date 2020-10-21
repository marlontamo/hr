<table class="table table-bordered table-striped">
	<tbody>
		<tr>
			<td class="success">
				<div class="form-group">
					<label class="control-label col-md-3 bold">Approver</label>
					<div class="col-md-9">
						<input type="text" class="form-control" value="{{ $record['requisition.approver'] }}" disabled>
						<input type="hidden" class="form-control" name="requisition[approver]" value="{{ $record['requisition.approver_id'] }}">
					</div>
				</div>
			</td>
			<td rowspan="2">
				<div class="form-group">
					<label class="control-label col-md-3 bold">Remarks</label>
					<div class="col-md-9">
						<textarea class="form-control" name="requisition_remarks[{{ $record['requisition.approver_id'] }}]" rows="3">@if( $approver_remark ){{ $approver_remark->remarks }}@endif</textarea>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="form-group">
					<label class="control-label col-md-3 bold">Date Approved</label>
					<div class="col-md-9">
						<input type="text" class="form-control" disabled value="@if( $approver_remark ){{ date('M d, Y', strtotime($approver_remark->date)) }}@endif">
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>