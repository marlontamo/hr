<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4 class="modal-title">Appraisal</h4>
	</div>
	<div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="col-md-8">
				<!-- Planning Logs Listing -->
				<div class="portlet">
                
                	<div class="breadcrumb hidden-lg hidden-md">
                        <div class="block input-icon right">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search..." class="form-control">
                        </div>
                    </div>
                
					<div class="portlet-title">
						<div class="caption">Appraisal Logs</div>
                        
					</div>		

					<div class="clearfix">
						<!-- Table -->
						<table class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									<!-- <th width="1%" class="hidden-xs"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th> -->
									<th width="45%">Name</th>
									<th width="30%" class="hidden-xs">Date and Time</th>
									<th width="25%" class="hidden-xs">Status</th>
								</tr>
							</thead>
							<tbody>
							<?php if(count($logs_list)>0){
								foreach($logs_list as $logs){
									?>
								<tr rel="1">
									<!-- this first column shows the year of this holiday item -->
									<!-- <td class="hidden-xs"><input type="checkbox" class="checkboxes" value="1" /></td> -->
									<td>
										<?php echo $logs['partner_name']?>
										<br />
										<span class="small text-muted"><?php echo $logs['position']?></span>
									</td>
									<td class="hidden-xs">
										<span class="text-success"><?php echo date('F d, Y', strtotime($logs['created_on'])) ?></span>
										<br />
										<span id="date_set" class="small text-muted"><?php echo date('h:i a', strtotime($logs['created_on'])) ?></span>
									</td>
									<td class="hidden-xs">
										<span class="<?php echo str_replace('btn', 'badge', $logs['class'] )?>"> <?php echo $logs['performance_status'] ?></span>
									</td>
								</tr>
								<?php		
									}
								}
								?>
							</tbody>
						</table>
						<!-- End Table -->
					</div>
				</div>
			</div>
			<div class="col-md-4">

				<div class="portlet">
					<div class="portlet-body">
						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">Approver/s</h4>
								</div>

								<ul class="list-group">
								<?php if(count($approvers_list)>0){
									foreach($approvers_list as $approver){
										?>
									<li class="list-group-item"><?php echo $approver['display_name']?><br><small class="text-muted"><?php echo $approver['position']?></small> </li>
								<?php		
									}
								}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer margin-top-0">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close Logs</button>
	</div>
</div>