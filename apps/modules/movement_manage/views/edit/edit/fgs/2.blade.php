<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Nature of Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Nature of Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Effective</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_movement_action[effectivity_date]" id="partners_movement_action-effectivity_date" value="{{ $record['partners_movement_action.effectivity_date'] }}" placeholder="Enter Effective" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Remarks</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_movement_action[remarks]" id="partners_movement_action-remarks" placeholder="Enter Remarks" rows="4">{{ $record['partners_movement_action.remarks'] }}</textarea> 				</div>	
			</div>	</div>
</div>