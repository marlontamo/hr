<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Additional Leave Credit</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">
			<!-- <input type="hidden" class="form-control" name="time_forms_ot_leave[forms_id]" value="{{ $record['forms_id'] }}" />  -->
			<div class="form-group">
				<label class="control-label col-md-3">
					Date
				</label>				
				<div class="col-md-7">
					<input type="text" class="form-control" disabled value="{{ date( 'F d, Y', strtotime($record['date_from']) ) }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">
					Reason
				</label>				
				<div class="col-md-7">
					<input type="text" class="form-control" disabled value="{{ $record['reason'] }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">
					Credit
				</label>				
				<div class="col-md-7">
					<input type="text" class="form-control" disabled value="{{ $record['credit'] }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">
					Used
				</label>				
				<div class="col-md-7">
					<input type="text" class="form-control" disabled value="{{ $record['used'] }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">
					Balance
				</label>				
				<div class="col-md-7">
					<input type="text" class="form-control" disabled value="{{ $record['balance'] }}" /> 				
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">
					Expiration Date
				</label>				
				<div class="col-md-7">
					<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
						<input type="text" class="form-control" name="time_forms_ot_leave[expiration_date]" id="time_forms_ot_leave-expiration_date" value="{{ date( 'F d, Y', strtotime($record['expiration_date']) ) }}" placeholder="">
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</div>	
			</div>

		</div>
</div>