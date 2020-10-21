<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Leave Balance</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Leave Balance</p>
		<div class="portlet-body form">			
			<div class="form-group">
				<?php
					$from_year = date('Y') - 1;
					$to_year = date('Y') + 1;
					for ($i=$from_year; $i <= $to_year; $i++) { 
						$year_option[$i] = $i;
					}

					$year_selected = ($record['time_form_balance.year'] && $record['time_form_balance.year'] != '') ? $record['time_form_balance.year'] : date('Y');
				?>
				<label class="control-label col-md-3"><span class="required">* </span>Year</label>
				<div class="col-md-7">							
					<div class="input-group">
						<span class="input-group-addon">
                			<i class="fa fa-list-ul"></i>
                		</span>
                		{{ form_dropdown('time_form_balance[year]',$year_option, $year_selected, 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance-year"') }}
           	 		</div> 									
					<!-- <input type="text" class="form-control" name="time_form_balance[year]" id="time_form_balance-year" value="{{ $record['time_form_balance.year'] }}" placeholder="Enter Year" /> -->
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Employee</label>
				<div class="col-md-7"><?php	
								$qry_category = $mod->get_role_category();	
								$db->select('users.user_id,users.display_name');
								$db->from('users');
								$db->join('partners', 'users.user_id = partners.user_id');
								$db->join('users_profile', 'users_profile.user_id = partners.user_id');							
								$db->join('payroll_partners', 'payroll_partners.user_id = users.user_id', 'inner join');
								$db->order_by('users.display_name', '0');
						        if ($qry_category != ''){
						            $db->where($qry_category, '', false);
						        }							
						  		$db->where('users.deleted', '0');
	 					        $options = $db->get();	 	                            
	                            $time_form_balance_user_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$time_form_balance_user_id_options[$option->user_id] = $option->display_name;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('time_form_balance[user_id]',$time_form_balance_user_id_options, $record['time_form_balance.user_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance-user_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Leave Type</label>
				<div class="col-md-7"><?php									                            		$options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT * FROM ww_time_form WHERE is_leave = 1")); 	                            $time_form_balance_form_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
									$class_code = $option->form_code.'-GRANT';
									$db->join('time_form_class_policy','time_form_class.class_id = time_form_class_policy.class_id');
									$result = $db->get_where('time_form_class',array('class_code' => $class_code));
									if ($result && $result->num_rows() > 0){                        			
										$row = $result->row();
										if ($row->class_value == 'YES'){                        			
                        					$time_form_balance_form_id_options[$option->form_id] = $option->form;
                        				}
                        			}
                        		} ?>							
								<div class="input-group">
									<span class="input-group-addon">
	                        			<i class="fa fa-list-ul"></i>
	                        		</span>
	                        		{{ form_dropdown('time_form_balance[form_id]',$time_form_balance_form_id_options, $record['time_form_balance.form_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_form_balance-form_id"') }}
	                   	 		</div> 				
	                    	</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Previous Credit</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="time_form_balance[previous]" id="time_form_balance-previous" value="{{ $record['time_form_balance.previous'] }}" placeholder="Enter Previous Credit" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Current Credit</label>
				<div class="col-md-7">							<input type="text" readonly class="form-control" name="time_form_balance[current]" id="time_form_balance-current" value="{{ $record['time_form_balance.current'] }}" placeholder="Enter Current Credit" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Period From</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_form_balance[period_from]" id="time_form_balance-period_from" value="{{ $record['time_form_balance.period_from'] }}" placeholder="Enter Period From" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Period To</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_form_balance[period_to]" id="time_form_balance-period_to" value="{{ $record['time_form_balance.period_to'] }}" placeholder="Enter Period To" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Period Extension</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_form_balance[period_extension]" id="time_form_balance-period_extension" value="{{ $record['time_form_balance.period_extension'] }}" placeholder="Enter Period Extension" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Leave Balance Accrual Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="actions" style="float:right">
		<a <?php echo ($record_id && $record_id != '' ? '' : 'style="display:none"') ?> id="goadd" href="javascript:void(0)" class="btn btn-sm btn-success" onclick="add_leave_accrual(<?php echo $record_id ?>)"><i class="fa fa-plus"></i></a>
	</div>	
	<br clear:all />
    <div class="portlet-body form">
		<table id="record-table" class="table table-condensed table-striped table-hover">
			<thead>
				<tr>
					<th width="28%">Leave Type</th>
					<th class="hidden-xs" width="29%">Credit</th>
					<th class="hidden-xs" width="17%">Month</th>							
					<th width="20%">Actions</th>
				</tr>
			</thead>
			<tbody id="record-list">
				@if ((($record_id && $record_id != '') && $leave_accrual && $leave_accrual->num_rows() > 0))
					@foreach ($leave_accrual->result() as $row)
						<tr class="record">
			    			<td class="hidden-xs">{{ $row->form_code }}</td>
			    			<td>{{ $row->accrual }}</td>
			    			<td>{{ date('M Y',strtotime($row->date_accrued)) }}</td>
			    			<td>
								<div class="btn-group">
					                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="edit_credits(<?php echo $record_id ?>,'<?php echo $row->date_accrued ?>')"><i class="fa fa-pencil"></i> Edit</a>
					                <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_credit(<?php echo $record_id ?>,'<?php echo $row->date_accrued ?>',this)"><i class="fa fa-trash-o"></i> Delete</a>
					            </div>	    				
			    			</td>
						</tr>				
					@endforeach
				@endif
			</tbody>
		</table>
    </div>	
</div>
<div class="modal fade modal-container-action" aria-hidden="true" data-width="800" ></div>