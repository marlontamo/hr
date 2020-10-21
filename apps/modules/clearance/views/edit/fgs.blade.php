<div class="portlet">

	<div class="portlet-title">
		<div class="caption bold">CLEARANCE PROCESS FORM</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			</div>
	</div>

    <div class="portlet-body" >

    	<p class="margin-bottom-25 small">&nbsp;</span></p>
    	<!-- EMPLOYEES INFO-->
    	<div class="portlet">
			<div class="portlet-body">

            	<table class="table table-bordered table-striped">
					<tbody>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Employee</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['firstname']}} {{$record['lastname']}}">
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Department</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['department']}}">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Company</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['company']}}">
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Effectivity Date</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['effectivity_date']}}">
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
<!-- 								<div class="form-group">
									<label class="control-label col-md-3 bold">Turnaround Date</label>
									<?php
										if(date("Y-m-d") >= date("Y-m-d", strtotime($record['effectivity_date']))){
											$date1 = new DateTime(date("Y-m-d", strtotime($record['effectivity_date'])));
											$date2 = new DateTime(date("Y-m-d"));
											$interval = $date1->diff($date2);
											$turn_around_time = $interval->d . ' day/s';
										}
										else{
											$turn_around_time = '';
										}
									?>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$turn_around_time}}">
									</div>
								</div> -->
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">Clearance Status</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['clearance_status']}}">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

        <!-- BEGIN OF FORM-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">PROCESS</div>
				<div class="tools">
					<a class="collapse" href="javascript:;"></a>
					</div>
			</div>
			<div class="portlet-body">
				
				<div class="clearfix">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">
								1. Employee Exit Interview Form
							</h3>
						</div>
						<div class="panel-body">
							<a class="btn btn-info btn-sm" data-toggle="modal" href="{{get_mod_route('clearance', 'view_exit_interview/'.$record_id)}}"> View Form</a>
							<a class="btn dark btn-sm" data-toggle="modal" href="#for_approval" onclick="print_exit_interview({{$record_id}})"> <i class="fa fa-print"></i> Print Form</a>
						</div>
					</div>

					<div class="panel panel-warning">
						<div class="panel-heading">
							<h3 class="panel-title">
								2. Employee Clearance Signatories
							</h3>
						</div>
						<div class="panel-body">
							<a class="btn btn-info btn-sm" href="{{get_mod_route('clearance', 'view_signatories/'.$record_id)}}"> View Form</a>
							<a class="btn dark btn-sm" data-toggle="modal" href="#" onclick="print_clearance_form({{$record_id}})"> <i class="fa fa-print"></i> Print Form</a>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								3. Quitclaim
							</h3>
						</div>
						<div class="panel-body">
							<a class="btn dark btn-sm" data-toggle="modal" href="#" onclick="print_release_quitclaim({{$record_id}})"> <i class="fa fa-print"></i> Print Form</a> 
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								4. Certificate of Employment
							</h3>
						</div>
						<div class="panel-body">
							<a class="btn dark btn-sm" data-toggle="modal" href="#" onclick="print_coe({{$record_id}})"> <i class="fa fa-print"></i> Print Form</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END OF FORM-->


    </div>
</div>