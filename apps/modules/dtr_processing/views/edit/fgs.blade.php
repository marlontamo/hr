<div class="portlet" style="margin-bottom:60px;">
	<div class="portlet-title">
		<div class="caption">1. Payroll relation</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">Payroll Date</label>
			<div class="col-md-7">							
				<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_period[payroll_date]" id="time_period-payroll_date" value="{{ $record['time_period.payroll_date'] }}" placeholder="Enter Payroll Date" readonly>
				<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
			</div> 				
		</div>	
	</div>			
	<div class="form-group">
		<label class="control-label col-md-3">Coverage</label>
		<div class="col-md-7">							
			<input type="hidden" name="time_period[date]"/>
				<div class="input-group input-xlarge date-picker input-daterange" data-date-format="MM dd, yyyy">
				<input type="text" class="form-control" name="time_period[date_from]" id="time_period-date_from" value="{{ $record['time_period.date_from'] }}" />
				<span class="input-group-addon">to</span>
				<input type="text" class="form-control" name="time_period[date_to]" id="time_period-date_to" value="{{ $record['time_period.date_to'] }}" />
			</div> 				
		</div>	
	</div>
	<div class="form-group">
		<label class="control-label col-md-3"><span class="required">* </span>Company</label>
		<div class="col-md-7">
			<?php	                            	                            		
				$db->select('company_id,company');
            	$db->where('deleted', '0');
            	$options = $db->get('users_company');
				$time_period_company_id_options = array();
            	foreach($options->result() as $option){
            		$time_period_company_id_options[$option->company_id] = $option->company;
            	} 
	        ?>							
	    	<div class="input-group">
				<span class="input-group-addon">
                <i class="fa fa-list-ul"></i>
                </span>
                {{ form_dropdown('time_period[company_id][]',$time_period_company_id_options, $record['time_period.company_id'], 'class="form-control select2me" multiple="multiple" data-placeholder="Select..." id="time_period-company_id"') }}
	        </div> 				
	    </div>	
	</div>	
	<div class="form-group">
		<label class="control-label col-md-3"><span class="required">* </span>Apply To</label>
		<div class="col-md-7">
			<?php
				$db->select('apply_to_id,apply_to');
	            $db->order_by('apply_to', '0');
	            $db->where('deleted', '0');
	            $options = $db->get('time_period_apply_to'); 	                            
	            $time_period_apply_to_id_options = array('' => 'Select...');
                foreach($options->result() as $option){
                    $time_period_apply_to_id_options[$option->apply_to_id] = $option->apply_to;
            	} 
            ?>							
            <div class="input-group">
				<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	               {{ form_dropdown('time_period[apply_to_id]',$time_period_apply_to_id_options, $record['time_period.apply_to_id'], 'class="form-control select2me" data-placeholder="Select..." id="time_period-apply_to_id"') }}
	        </div> 				
	    </div>	
	</div>
	<div class="form-group">
		<label class="control-label col-md-3"></label>
		<div class="col-md-7">
			<?php
				$options = "";
				if( !empty( $record_id ) )
				{
					$options = $mod->_get_applied_to_options( $record_id, true );
				}
			?>
            <div class="input-group">
				<span class="input-group-addon">
                <i class="fa fa-list-ul"></i>
                </span>
                <select name="time_period[applied_to][]" id="time_period-applied_to" class="form-control select2me" data-placeholder="Select..." multiple>
                	{{ $options }}
                </select>
            </div>
        </div>	
	</div>				
</div>
</div><div class="portlet" style="margin-bottom:60px;">
	<div class="portlet-title">
		<div class="caption">2. Allowable time to process </div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Cut-Off Date</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_period[cutoff]" id="time_period-cutoff" value="{{ $record['time_period.cutoff'] }}" placeholder="Enter Cut-Off Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div><div class="portlet" style="margin-bottom:60px;">
	<div class="portlet-title">
		<div class="caption">3. Process date for all late approval</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Previous Cut-Off</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="time_period[previous_cutoff]" id="time_period-previous_cutoff" value="{{ $record['time_period.previous_cutoff'] }}" placeholder="Enter Previous Cutoff" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>	</div>
</div>