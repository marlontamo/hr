<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employment Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Employee Status</label>
				<div class="col-md-7"><?php	                            	                            		$db->select('employment_status_id,employment_status');
	                            			                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_employment_status');
										$partners_status_id_options = array('' => 'Select...');
	                            		foreach($options->result() as $option)
	                            		{
	                            				                            				$partners_status_id_options[$option->employment_status_id] = $option->employment_status;
	                            				                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners[status_id]',$partners_status_id_options, $record['partners.status_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date Hired</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners[effectivity_date]" id="partners-effectivity_date" value="{{ $record['partners.effectivity_date'] }}" placeholder="Enter Date Hired" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>