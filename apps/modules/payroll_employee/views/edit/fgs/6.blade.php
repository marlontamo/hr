<div class="portlet">
	<div class="portlet-title">
		<div class="caption">ECOLA Setup </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Week</label>
				<div class="col-md-7"><?php                                                        		$db->select('week_id,week');
                            		                            		$db->where('deleted', '0');
                            		$options = $db->get('payroll_week');
									$payroll_partners_ecola_week_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			                            				$payroll_partners_ecola_week_options[$option->week_id] = $option->week;
                            			                            		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('payroll_partners[ecola_week][]',$payroll_partners_ecola_week_options, explode(',', $record['payroll_partners.ecola_week']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="payroll_partners-ecola_week"') }}
	                        </div> 				</div>	
			</div>	</div>
</div>