<div class="row">
	<div class="col-md-3">
		<div class="portlet ">
			<div class="portlet-title">
				<div class="caption">Filter</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<p class="small text-muted">Filter to view YTD records per employee.</p>
			<!-- <h4 class="bold">HDI Systech</h4> -->
			<div class="portlet-body margin-top-25">

				<div class="form-group">
                    <label class="control-label small text-success bold">Year:</label>
                    <?php
						$db->select('DISTINCT(`year`)');
						$db->where('deleted', '0');
						$options = $db->get('payroll_closed_summary');
						$payroll_year_options = array('' => 'Select Year...');
						foreach($options->result() as $option)
						{
							$payroll_year_options[$option->year] = $option->year;
						} 
					?>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						{{ form_dropdown('pay_year',$payroll_year_options, '', 'class="form-control select2me" data-placeholder="Select..." id="pay_year"') }}
					</div>
                </div>

                <div class="form-group">
                    <label class="control-label small text-success bold">Employee:</label>
                    <?php
						$db->select('user_id, alias');
						$db->where('deleted', '0');
						$db->order_by('alias');
						$options = $db->get('partners');
						$users_id_options = array('' => 'Select Partner...');
						foreach($options->result() as $option)
						{
							$users_id_options[$option->user_id] = $option->alias;
						} 
					?>
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
						{{ form_dropdown('user_id',$users_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="user_id"') }}
					</div>
                </div>
                
            </div>
        </div>
	</div>
	<div class="col-md-9">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">YTD SUMMARY</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<p class="small text-muted">This section shows the YTD summary of a specific employee.</p>
			<div class="portlet-body">
				<div class="table-responsive margin-top-25">					
	                <div id="no_record" class="well" >
						<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
						<span><p class="small margin-bottom-0">Please select year and partner.</p></span>
					</div>
					<table class="table table-striped table-bordered table-hover" id="ytd_table" style="display:none;">
						<thead>
							<tr>
								<th width="25%">Code</th>
								<th width="15%">YTD <br><span class="text-muted small">Total Amount</span></th>
								<th width="15%">1st Quarter</th>
								<th width="15%">2nd Quarter</th>
								<th width="15%">3rd Quarter</th>
								<th width="15%">4th Quarter</th>
							</tr>
						</thead>
						<tbody  id="ytd_body">							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
