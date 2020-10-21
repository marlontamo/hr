<div class="portlet">
	<div class="portlet-title">
		<div class="caption">End Service Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>End Service Movement</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>End Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_movement_action_moving[end_date]" id="partners_movement_action_moving-end_date" value="{{ $record['partners_movement_action_moving.end_date'] }}" placeholder="Enter End Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">Blacklisted</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['partners_movement_action_moving.blacklisted'] ) checked="checked" @endif name="partners_movement_action_moving[blacklisted][temp]" id="partners_movement_action_moving-blacklisted-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="partners_movement_action_moving[blacklisted]" id="partners_movement_action_moving-blacklisted" value="@if( $record['partners_movement_action_moving.blacklisted'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Reason</label>
				<div class="col-md-7"><?php									                            		$db->select('reason_id,reason');
	                            			                            		$db->order_by('reason', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_movement_reason'); 	                            $partners_movement_action_moving_reason_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$partners_movement_action_moving_reason_id_options[$option->reason_id] = $option->reason;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_movement_action_moving[reason_id]',$partners_movement_action_moving_reason_id_options, $record['partners_movement_action_moving.reason_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Further Reason</label>
				<div class="col-md-7">							<textarea class="form-control" name="partners_movement_action_moving[further_reason]" id="partners_movement_action_moving-further_reason" placeholder="Enter Further Reason" rows="4">{{ $record['partners_movement_action_moving.further_reason'] }}</textarea> 				</div>	
			</div>	</div>
</div>