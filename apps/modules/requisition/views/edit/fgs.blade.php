<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Purchase Request</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">
					<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Project Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="requisition[project_name]" id="requisition-project_name" value="{{ $record['requisition.project_name'] }}" placeholder="Enter Project Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Priority</label>
				<div class="col-md-7"><?php									                            		$db->select('priority_id,priority');
	                            			                            		$db->order_by('priority_id', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('requisition_priority'); 	                            $requisition_priority_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$requisition_priority_id_options[$option->priority_id] = $option->priority;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('requisition[priority_id]',$requisition_priority_id_options, $record['requisition.priority_id'], 'class="form-control select2me" data-placeholder="Select..." id="requisition-priority_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Approval From</label>
				<div class="col-md-7"><?php									                            		$db->select('user_id,full_name');
	                            			                            		$db->order_by('full_name', '0');
	                            		$db->where('deleted', '0');
	                            		$db->where('active', '1');
	                            		$options = $db->get('users'); 	                            $requisition_approver_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$requisition_approver_options[$option->user_id] = $option->full_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('requisition[approver]',$requisition_approver_options, $record['requisition.approver'], 'class="form-control select2me" data-placeholder="Select..." id="requisition-approver"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>

<div class="portlet">
	<div class="portlet-body form">
		<div class="portlet margin-top-25">
			<h5 class="form-section margin-bottom-10"><b>List of Items</b></h5>

			<div class="portlet-body" >
				<!-- Table -->
				<table class="table table-condensed table-striped table-hover" >
					<thead>
						<tr>
							<th width="20%" class="padding-top-bottom-10" >Item</th>
							<th width="20%" class="padding-top-bottom-10" >Reason</th>
							<th width="20%" class="padding-top-bottom-10" >Date</th>
							<th width="10%" class="padding-top-bottom-10" >Quantity</th>
							<th width="10%" class="padding-top-bottom-10" >Unit</th>
							<th width="15%" class="padding-top-bottom-10" >Amount</th>
							<th width="10%" class="padding-top-bottom-10" >Actions</th>
						</tr>
					</thead>
					<tbody class="item-list">
						@if( sizeof( $items ) > 0 )
							@foreach( $items as $item )
								<tr>
									<td>
										<textarea rows="2" name="requisition_items[item][]" class="form-control">{{ $item->item }}</textarea>
									</td>
									<td>
										<textarea rows="2" name="requisition_items[reason][]" class="form-control">{{ $item->reason }}</textarea>
									</td>
									<td>
										<div class="input-group date date-picker" data-date-format="MM dd, yyyy">
											<input type="text"  class="form-control" name="requisition_items[date][]" value="{{ date('M d, Y', strtotime($item->date)) }}">
											<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</td>
									<td><input type="text" name="requisition_items[quantity][]" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control" value="{{ $item->quantity }}"></td>
									<td><input type="text" name="requisition_items[unit_price][]" value="{{ $item->unit_price }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control"></td>
									<td><input type="text" name="requisition_items[amount][]" value="{{ number_format($item->quantity*$item->unit_price, 2, '.', ',') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control" readonly></td>
									<td><button class="btn btn-xs text-muted" onclick="delete_item($(this))"><i class="fa fa-trash-o"></i> Delete</button></td>
								</tr>
							@endforeach
						@else
							<tr class="add_reminder">
								<td colspan="7" align="center">
									ADD ITEMS BY CLICKING ADD BUTTON
								</td>
							</tr>
						@endif
						<tr  class="success">
							<td>
								<button class="btn btn-success btn-sm" onclick="add_item()" type="button"><i class="fa fa-plus"></i> Add Item</button>
							</td>
							<td colspan="4" class="text-right"><b>TOTAL AMOUNT</b></td>
							<td>
								<input type="hidden" class="form-control" name="requisition[no_of_items]" value="<?php if( !empty($record['requisition.no_of_items']) ) echo number_format($record['requisition.no_of_items'], 2, '.', ',') ?>" >
								<input type="text" class="form-control" name="requisition[total_price]" value="<?php if( !empty($record['requisition.total_price']) ) echo number_format($record['requisition.total_price'], 2, '.', ',') ?>" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" readonly></td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>