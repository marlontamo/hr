
<div class="modal-body">
	<div class="row">
		<!-- FORM -->
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-body form">
                    <form id="form-period-options" class="form-horizontal" action="#">
						<div style="padding-bottom:0px;" class="form-body">
							<div class="form-group">
								<label class="control-label col-md-6">SBR Number <span class="required">*</span></label>
								<div class="col-md-6">
									<input type="hidden" name="year_month" id="year_month" value="<?php echo $record_id; ?>"/>
									<input id="sbr_no" class="form-control" type="text" value="" name="sbr_no">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-6">Transaction Date <span class="required">*</span></label>
								<div class="col-md-6">
									<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
										<input id="tran_date" readonly="" class="form-control" value="" name="tran_date">
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div> 
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-6">Acknowledgement Number <span class="required">*</span></label>
								<div class="col-md-6">
									<input id="ack_no" class="form-control" type="text" value="" name="ack_no">
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="control-label col-md-6">Type <span class="required">*</span></label>
								<div class="col-md-6">
									<input id="ack_no" class="form-control" type="text" value="" name="ack_no">
								</div>
							</div> -->
							<!-- <div class="form-group">
								<label class="control-label col-md-6">Type</label>
								<div class="select-input-wrap">	
									<span class="input-group-addon">
		                            	<i class="fa fa-list-ul"></i>
		                            </span>		
									<select id="statutory-type" name="statutory" clas="form-control select2me" data-placeholder="Select...">
										<option value="1">SSS</option>
										<option value="2">PhilHealth</option>
										<option value="3">PagIbig</option>
										<option value="4">SSS Loan</option>
										<option value="5">PagIbig Loan</option>
									</select>
								</div>
							</div> -->
							<div class="form-group">
								<label class="control-label col-md-6">Type</label>
								<div class="col-md-6">
									<?php
										$options = array('1'=>'SSS','2'=>'PhilHealth','3'=>'PagIbig','4'=>'SSS Loan','5'=>'PagIbig Loan');
									?>
				                    <div class="input-group">
										<span class="input-group-addon">
				                        <i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="statutory" id="statutory-type" class="form-control select2me" data-placeholder="Select...">
				                        	<?php foreach ($options as $key => $value) { ?>
				                        			<option value="<?php echo $key;?>"><?php echo $value;?></option>
				                        	<?php }?>
				                        </select>
				                    </div>
				                </div>	
							</div>
							<div class="form-group">
								<label class="control-label col-md-6">Category</label>
								<div class="col-md-6">
									<?php
										$options = array('employee_id'=>'By Employee','company_id'=>'By Company','division_id'=>'By Division',);
									?>
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="type" id="period-process-type" class="form-control select2me" data-placeholder="Select...">
				                        	<?php foreach ($options as $key => $value) { ?>
				                        			<option value="<?php echo $key;?>"><?php echo $value;?></option>
				                        	<?php }?>
				                        </select>
				                    </div>
				                </div>	
							</div>
							<!-- <div class="form-item">
								<label for="type" class="label-desc gray">Category</label>
								<div class="select-input-wrap">			
									<select id="period-process-type" name="type">
										<option value="employee_id">By Employee</option>
										<option value="company_id">By Company</option>
										<option value="division_id">By Division</option>
									</select>
								</div>
							</div> -->
							<div class="form-group" id="company_div" style="display:none;">
								<label class="control-label col-md-6">Company</label>
								<div class="col-md-6">
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="company_val[]" id="company_val" class="form-control select2me" data-placeholder="Select..." multiple></select>
				                    </div>
				                </div>	
							</div>
							<!-- <div class="form-item" id="company_div" style="display:none;">		
								<label class="label-desc gray">Company</label>
								<div class="multiselect-input-wrap">
									<select id="company_val" name="company_val[]" multiple="multiple"></select>				
								</div>
							</div> -->
							<div class="form-group" id="location_div" style="display:none;">
								<label class="control-label col-md-6">Location</label>
								<div class="col-md-6">
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="location_val[]" id="location_val" class="form-control select2me" data-placeholder="Select..." multiple></select>
				                    </div>
				                </div>	
							</div>
							<!-- <div class="form-item" id="location_div" style="display:none;">
								<label for="type" class="label-desc gray">Location</label>
								<div class="multiselect-input-wrap">			
									<select id="location_val" name="location_val[]" multiple="multiple">
									</select>
								</div>
							</div> -->
							<div class="form-group">
								<label class="control-label col-md-6">Employees </label>
								<div class="col-md-6">
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="values[]" id="values" class="form-control select2me " data-placeholder="Select..." multiple></select>
				                    </div>
				                </div>	
							</div>
							<!-- <div class="form-item">		
								<label class="label-desc gray">Employees <span class="font-color: red;">*</span></label>
								<div class="multiselect-input-wrap">
									<select id="values" name="values[]" multiple="multiple"></select>				
								</div>
							</div>	 -->	
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
	<button class="btn blue" type="button" onclick="process_sbr(<?php echo $record_id?>)"><i class="fa fa-spin"></i> Process</button>
</div>