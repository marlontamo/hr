<div class="row">
	<div class="col-md-3">
		<div class="portlet ">
			<div class="portlet-title">
				<div class="caption">Filter</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<p class="small text-muted">Select by company, by department and date range to view data and analytics.</p>
				@if( $mod->method == "index" )
					<input type="hidden" value="" name="company_id">
					<div class="form-group">
	                    <label class="control-label small text-success bold">Company:</label>
	                    <select  class="form-control select2me" data-placeholder="Select..." name="temp-company_id">
	                    	<option value="">Select Company</option>
	                    	<?php
	                    		$db->order_by('company', 'asc');
	                    		$companies = $db->get_where('users_company', array('deleted' => 0));
	                    		foreach( $companies->result()  as $company )
	                    			echo '<option value="'.$company->company_id.'">'.$company->company.'</option>';
	                    	?>
	                    </select>
	                </div>
				@else
					<div class="form-group">
	                    <label class="control-label small text-success bold">Company:</label>
	                    <br/>{{ $company }}
	                </div>
					<input type="hidden" value="{{ $company_id }}" name="company_id">
				@endif

                <div class="form-group">
                    <label class="control-label small text-success bold">Department:</label>
                    <select  class="form-control select2me" data-placeholder="Select..." name="department_id">
                    	<option value="">Select Department</option>
                    	<?php
                    		$db->order_by('department', 'asc');
                    		$departments = $db->get_where('users_department', array('deleted' => 0));
                    		foreach( $departments->result()  as $department )
                    			echo '<option value="'.$department->department_id.'">'.$department->department.'</option>';
                    	?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label small text-success bold">As of:</label>
                    <div class="input-group input-large date-picker input-daterange" data-date-format="mm/dd/yyyy">
						<div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" >
							<input name="date" type="text" class="form-control" readonly>
							<span class="input-group-btn">
							<button class="btn green" type="button"><i class="fa fa-calendar"></i></button>
							</span>
						</div>
						<span class="help-block small">Select date</span>
					</div>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-8">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">Presentation</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<ul  class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Demographics</a></li>
					<li><a href="#tab2" data-toggle="tab">Maps</a></li>
					<!-- <li><a href="#tab3" data-toggle="tab">Employment Type</a></li>
					<li><a href="#tab4" data-toggle="tab">Tenure</a></li> -->
				</ul>
				<div  class="tab-content">
					<div class="tab-pane fade active in" id="tab1">
						<div class="portlet box green">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Gender per Employment Status</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" onclick="chart_gender_per_status();" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="gender_per_status" class="chart" style="width: 100%; min-height: 1px;"></div>
										<br/>
										<div class="table-responsive">
											<table id="gender_per_status_table" class="table table-bordered table-hover small">
												<thead>
													<tr>
														<th>Employment Status</th>
														<th style="text-align:center"><?php echo lang('common.male') ?></th>
														<th style="text-align:center">%</th>
														<th style="text-align:center"><?php echo lang('common.female') ?></th>
														<th style="text-align:center">%</th>
													</tr>
												</thead>
												<tbody></tbody>	
											</table>
										</div>
									
										<div class="well small hidden">
											<p>The graph shows consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>

											<ul>
												<li>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </li>
												<li>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet box yellow">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Age Profile</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" onclick="age_profile_pie();" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="age_profile_pie" class="chart" style="width: 100%; min-height: 1px;"></div>
										<br/>
										<div class="table-responsive">
											<table id="age_profile_table" class="table table-bordered table-hover small">
												<thead>
													<tr>
														<th>Age Bracket</th>
														<th style="text-align:center">Total</th>
														<th style="text-align:center">Percentage</th>
													</tr>
												</thead>
												<tbody></tbody>	
											</table>
										</div>
										<div class="well small hidden">
											<p>The graph shows consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
											<ul>
												<li>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </li>
												<li>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Employment Type per Status</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" onclick="chart_type_per_status();" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="chart_type_per_status" class="chart" style="width: 100%; min-height: 1px;"></div>
										<br/>
										<div class="table-responsive">
											<table id="chart_type_per_status_table" class="table table-bordered table-hover small">
												<thead>
													<tr>
														<th id="type">Employment Type</th>
														<th style="text-align:center">Total</th>
													</tr>
												</thead>
												<tbody></tbody>	
											</table>
										</div>
										<div class="well small hidden">
											<p>The graph shows consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
											<ul>
												<li>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </li>
												<li>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</li>
											</ul>
										</div>
									</div>
								</div>
							</div>		
						</div>
						<div class="portlet box purple">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Tenure (Work Force)</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" onclick="javascript:tenure_pie();" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="tenure_pie" class="chart" style="width: 100%; min-height: 1px;"></div>
										<br/>
										<div class="table-responsive">
											<table id="tenure_table" class="table table-bordered table-hover small">
												<thead>
													<tr>
														<th>Tenure</th>
														<th style="text-align:center">Total</th>
														<th style="text-align:center">Percentage</th>
													</tr>
												</thead>
												<tbody></tbody>	
											</table>
										</div>
										<div class="well small hidden">
											<p>The graph shows consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
											<ul>
												<li>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. </li>
												<li>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade in" id="tab2">
						<div class="col-md-6">
							<!-- BEGIN MARKERS PORTLET-->
						<!-- 	<div class="portlet solid yellow">
								<div class="portlet-title">
									<div class="caption"><i class="fa fa-reorder"></i>Markers</div>
									<div class="tools">
										<a href="javascript:;" class="collapse"></a>
										<a href="#portlet-config" data-toggle="modal" class="config"></a>
										<a href="javascript:;" onclick="get_long_lat();" class="reload"></a>
										<a href="javascript:;" class="remove"></a>
									</div>
								</div>
								<div class="portlet-body"> -->
									<div id="gmap_marker" class="gmaps"></div>
								<!-- </div>
							</div> -->
							<!-- END MARKERS PORTLET-->
						</div>
					</div>

					<!-- START MAP MODAL -->
					<div id="prompt_map"  class="modal fade" tabindex="-1" data-width="500">
					</div>
					<!-- END MAP MODAL -->
				</div>
			</div>
		</div>
	</div>
</div>
