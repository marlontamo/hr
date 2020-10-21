<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $form_info->form_code ?> <small class="text-muted"><?php echo $form_info->form ?></small></h4>
</div>
<form class="form-horizontal" id="form_action" method="POST">
    <div class="modal-body padding-bottom-0">	
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="action_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                        <input type="hidden" name="form_id" value="<?php echo $form_info->form_id ?>">
                        <input type="hidden" name="user_id" value="<?php echo $form_info->user_id ?>">
                        <input type="hidden" name="form_code" value="<?php echo $form_info->form_code ?>">
                        <div class="form-horizontal">
                            <div class="form-body move_action_modal">
								<div class="form-group">
									<label class="control-label col-md-3">
										<span class="required">* </span>Year
									</label>
									<div class="col-md-7">
										<?php									                            		
											$db->select('payroll_year');
									        $db->order_by('payroll_year', '0');
		                            		$db->where('deleted', '0');
		                            		$options = $db->get('payroll_year'); 	                            
		                            		$year_options = array('' => 'Select...');
								            foreach($options->result() as $option){
								                $year_options[$option->payroll_year] = $option->payroll_year;
								            } 
								        ?>							
								        <div class="input-group">
											<span class="input-group-addon">
									        <i class="fa fa-list-ul"></i>
									        </span>
									        <?php echo form_dropdown('year',$year_options, $record['year_id'], 'class="form-control select2me month" data-placeholder="Select..."') ?>
									    </div> 				
									</div>	
								</div>										
								<div class="form-group">
									<label class="control-label col-md-3">
										<span class="required">* </span>Month
									</label>
									<div class="col-md-7">
										<?php									                            		
											$db->select('month_id,month');
									        $db->order_by('month_id', '0');
		                            		$db->where('deleted', '0');
		                            		$options = $db->get('month'); 	                            
		                            		$month_options = array('' => 'Select...');
								            foreach($options->result() as $option){
								                $month_options[$option->month_id] = $option->month;
								            } 
								        ?>							
								        <div class="input-group">
											<span class="input-group-addon">
									        <i class="fa fa-list-ul"></i>
									        </span>
									        <?php echo form_dropdown('month',$month_options, $record['month_id'], 'class="form-control select2me year" data-placeholder="Select..."') ?>
									    </div> 				
									</div>	
								</div>	
								<div class="form-group">
									<label class="control-label col-md-3">
										<span class="required">* </span>Credit
									</label>
									<div class="col-md-7">
										<div class="input-group">
											<input class="form-control" name="accrued" id="credit" placeholder="Enter credit" type="text" value="<?php echo $record['accrual'] ?>">
										</div> 				
									</div>	
								</div>																				
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="button" class="btn green" onclick="save_credits( $(this).parents('form'), 'modal' )">Save</button>
    </div>
</form>

<script language="javascript">
    $(document).ready(function(){
    	$('.month,.year').live('change',function(){
            var data = $(this).parents('form').find(":not('.dontserializeme')").serialize();
            data = data + '&record_id='+ $('#record_id').val(); 

            $.ajax({
                url: base_url + module.get('route') + '/get_credits',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                	$('#credit').val(response.leave_bal_info.accrual);
                }
            });              		
    	});
    });
</script>