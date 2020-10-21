<script type="text/javascript" src="<?php echo theme_path() ?>plugins/bootstrap-tagsinput/typeahead.js"></script>

<div class="modal-body">
	<div class="row">
		<!-- FORM -->
		<div class="col-md-7">
			<div class="portlet">
				<div class="portlet-body form">
                    <form class="form-horizontal" action="#">
                        <div style="padding-bottom:0px;" class="form-body">
							<div class="form-group">
								<label class="control-label col-md-4">Payroll Date</label>
								<div class="col-md-8">
									<input type="text" value="<?php echo $record['time_period_payroll_date']?>" id="time_period_payroll_date" readonly="" class="form-control">
								</div>
							</div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Coverage</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $record['time_period_date']?>" id="time_period_date" readonly="" class="form-control">
                            	</div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-4">Company</label>
                                <div class="col-md-8">
                                    <input type="text" value="<?php echo $record['time_period_company_id']?>" id="time_period_company_id" readonly="" class="form-control">
                            	</div>
                            </div>                            
                            
							<hr>
							
							<div class="form-group">
								<label class="control-label col-md-4">Cut-Off Date</label>
								<div class="col-md-8">
									<input type="text" value="<?php echo $record['time_period_cutoff']?>" id="time_period_cutoff" readonly="" class="form-control">
								</div>
							</div>
							
							<hr>
							
							<div class="form-group">
								<label class="control-label col-md-4">Previous Cut-Off Date</label>
								<div class="col-md-8">
									<input type="text" value="<?php echo $record['time_period_previous_cutoff']?>" id="time_period_previous_cutoff" readonly="" class="form-control">
								</div>
							</div>

							<div class="form-group">
		                        <label class="control-label col-md-4">Employee</label>
		                        <div class="col-md-8">
		                            <input type="hidden" name="user_id" type="text" class="form-control">
		                            <input type="text" name="partner_name" type="text" class="form-control" autocomplete="off">
		                            <div class="help-block text-muted small">
		                                Enter employeed name.
		                            </div>
		                        </div>
		                    </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		<!-- RIGHT-SIDE DETAILS -->
		<div class="col-md-5">
			<div class="portlet">
				<div class="portlet-body">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">Distribution</h4>
						</div>
						<table class="table">
							<thead>
								<tr>
									<th style="width:40%" class="small">Status</th>
									<th style="width:40%" class="small">&nbsp;</th>
									<th style="width:20%;text-align:right" class="small">Count</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$stat_count = $mod->_get_stat_count( $record_id );
									foreach( $stat_count as $row )
									{ ?>
										<tr>
											<td class="small"><?php echo $row->status ?></td>
											<td>
												<div style="margin-bottom:0px;" class="progress">
													<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
														<span class="sr-only"></span>
													</div>
												</div>
											</td>
											<td style="text-align:right" class="small text-info"><?php echo $row->stat_count ?></td>
										</tr>
									<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
	<button class="btn blue" type="button" onclick="process_period(<?php echo $record['record_id']?>)"><i class="fa fa-spin"></i> Process this Period</button>
</div>

<script>
    $('input[name="partner_name"]').typeahead({
        source: function(query, process) {
            employees = [];
            map = {};
            
            $.getJSON(base_url + module.get('route') + '/user_lists_typeahead', function(data){
                var users = data.users;
                for( var i in users)
                {
                    employee = users[i];
                    map[employee.label] = employee;
                    employees.push(employee.label);
                }
             
                process(employees);    
            });
            
        },
        updater: function (item) {
            $('input[name="user_id"]').val(map[item].value);
            return item;
        },
        click: function (e) {
          e.stopPropagation();
          e.preventDefault();
          this.select();
        }
    });

    $('input[name="partner_name"]').focus(function(){
        $(this).val('');
        $('input[name="user_id"]').val('');
    });
</script>