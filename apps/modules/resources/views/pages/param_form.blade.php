<div class="portlet">
		<div class="portlet-body form">
			<form class="form-horizontal">
				<div class="portlet">
					<div class="portlet-body form">
    					<div class="form-body">
    						<h3>Certificate of Employment</h3>
    						<table class="table">
								<tbody>
									<tr>
										<td>Type of Certificate</td>
										<td>
											<select name="coe" class="form-control select2me department" data-placeholder="Select...">
												<option value="coe_compensation">COE Compensation</option>
												<option value="coe_tenure">COE Tenure</option>
											</select>								
										</td>
									</tr>
									<tr>
										<td>Partner </td>
										<td>
											<select name="user_id" class="form-control select2me department" data-placeholder="Select...">
												<?php
													if ($list_employee && $list_employee->num_rows() > 0){
														foreach ($list_employee->result() as $row) {
												?>
															<option value="<?php echo $row->user_id ?>"><?php echo $row->full_name ?></option>
												<?php
														}
													}
												?>
											</select>								
										</td>
									</tr>
									<tr>
										<td>Purpose</td>
										<td>
											<textarea class="form-control" name="purpose" id="purpose" placeholder="Enter Purpose" rows="4"></textarea>																		
										</td>
									</tr>																		
		                		</tbody>
							</table>
        				</div>
   					</div>
				</div>				
				<div class="form-actions fluid">
				    <div class="col-md-12 text-center">
				        <button type="button" class="btn btn-sm btn-primary" onclick="ajax_export_custom( $(this).closest('form'))">PDF</button>
				      	<a class="btn default btn-sm" data-dismiss="modal">Close</a>
				    </div>
				</div>
			</form>
       	</div>  		
	</div>

<script>
	$(document).ready(function(){
        $('select.select2me').select2();
	});
</script>	