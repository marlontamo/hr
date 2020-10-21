<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<form id="cancel-form">
				<input name="record_id" type="hidden" value="{{ $record_id }}" />
				<div class="form-group">
					<label class="control-label col-md-3">{{ lang('incident_report.remarks') }} <span class="required">*</span></label>
					<div class="col-md-9">
						<textarea class="form-control" name="remarks"></textarea>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer margin-top-0">
	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">{{ lang('common.cancel') }}</button>
	<button type="button" class="btn red btn-sm" onclick="cancel_report()">{{ lang('incident_report.cancel_report') }}</button>
</div>