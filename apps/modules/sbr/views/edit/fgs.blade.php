
<div class="modal-body">
	<div class="row">
		<!-- FORM -->
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-body form">
						<div style="padding-bottom:0px;" class="form-body">
							<div class="form-group">
								<label class="control-label col-md-5">SBR Number <span class="required">*</span></label>
								<div class="col-md-7">
									<input type="hidden" name="year_month" id="year_month" value="<?php echo $record_id; ?>"/>
									<input id="sbr_no" class="form-control" type="text" value="" name="sbr_no">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-5">Date Paid <span class="required">*</span></label>
								<div class="col-md-7">
									<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
										<input id="tran_date" readonly class="form-control" value="" name="tran_date">
										<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div> 
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-5">Type</label>
								<div class="col-md-7">
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
								<label class="control-label col-md-5">Category</label>
								<div class="col-md-7">
									<?php
										$options = array('employee_id'=>'By Employee','company_id'=>'By Company'/*,'division_id'=>'By Division',*/);
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
							<div class="form-group" id="company_div" style="display:none;">
								<label class="control-label col-md-5">Company</label>
								<div class="col-md-7">
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <select name="company_val[]" id="company_val" class="form-control select2me" data-placeholder="Select..." multiple></select>
				                    </div>
				                </div>	
							</div>
							<div class="form-group">
								<label class="control-label col-md-5">Employees </label>
								<div class="col-md-7">
				                    <div class="input-group">
										<span class="input-group-addon">
				                        	<i class="fa fa-list-ul"></i>
				                        </span>
				                        <?php	                            	                            		
				                        	$db->select('users.user_id,users.full_name');
	                            			$db->where('users.deleted', '0');
	                            			$db->where('partners.deleted', '0');
	                            			$db->join('partners','users.user_id=partners.user_id','left');
	                            			$db->order_by('users.full_name');
		                            		$options = $db->get('users');
											$employee_values = array();
		                            		foreach($options->result() as $option)
		                            		{
		                            				$employee_values[$option->user_id] = $option->full_name;
		                            		} ?>
				                        {{ form_dropdown('values[]',$employee_values, '', 'class="form-control select2me" multiple="multiple" data-placeholder="Select..." id="values"') }}
				                    </div>
				                </div>	
							</div>
						</div>
					<!-- </form> -->
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
	<button class="btn blue" type="button" onclick="process_sbr()"><i class="fa fa-spin"></i> Process</button>
</div>