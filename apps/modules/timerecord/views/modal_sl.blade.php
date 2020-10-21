<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Sick Leave Form</h4>
</div>
<form id="edit-field-form" class="form-horizontal" name="edit-field-form" action="{{ site_url('timerecord/save') }}">
	<input id="record_id" type="hidden" value="" name="record_id">
	<div class="modal-body">
		<div class="row">
			<div class="col-md-8">
				<div class="portlet">
	                <div class="portlet-body form">
	                    <!-- BEGIN FORM-->
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-4">From<span class="required">*</span></label>
                                <div class="col-md-7">
                                    <div class="input-group input-medium date date-picker" data-date-format="dd-MM-yyyy">
                                        <input type="text" class="form-control" name="time_forms[date_from]">
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <div class="help-block small">
										Select Start Date
									</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">To<span class="required">*</span></label>
                                <div class="col-md-7">
                                    <div class="input-group input-medium date date-picker" data-date-format="dd-MM-yyyy">
                                        <input type="text" class="form-control" readonly name="time_forms[date_to]"> 
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                    <div class="help-block small">
										Select End Date
									</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Reason<span class="required">*</span></label>
                                <div class="col-md-7">
                                    <textarea rows="4" class="form-control" name="time_forms[reason]"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
								<label class="control-label col-md-4">File Upload</label>
								<div class="controls col-md-7">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" class="default" />
										</span>
										<span class="fileupload-preview" style="margin-left:5px;"></span>
										<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
									</div>
									<div class="help-block small">
										Supporting Documents
									</div>
								</div>
							</div>
                            
                        </div>
	                    <!-- END FORM--> 
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
									<h4 class="panel-title">Leave Credits</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">Type</th>
											<th class="small">Used</th>
											<th class="small">Bal</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">Annual Leave</td>
											<td class="small text-info">3</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Sick Leave</td>
											<td class="small text-info">3</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Leave Without Pay</td>
											<td class="small text-info">0</td>
											<td class="small text-success">4</td>
										</tr>
										<tr>
											<td class="small">Bereavement</td>
											<td class="small text-info">2</td>
											<td class="small text-danger">0</td>
										</tr>
										<tr>
											<td class="small">Emergency</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">Approver/s</h4>
								</div>

								<ul class="list-group">
									<li class="list-group-item">Mahistardo, John<br><small class="text-muted">Manager</small> </li>
									<li class="list-group-item">Mendoza, Joel<br><small class="text-muted">Director</small> </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
		<button type="button" class="btn green btn-sm" onclick="save_mod_field( $(this).parents('form') )">Save changes</button>
	</div>
</form>