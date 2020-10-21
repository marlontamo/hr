<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $type; ?> <small class="text-muted">edit</small></h4>
</div>
<form class="form-horizontal" id="form_action" method="POST">
    <div class="modal-body padding-bottom-0">	
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="action_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                        <div class="form-horizontal">
                            <div class="form-body move_action_modal">
						    <input type="hidden" name="partners_movement_action[action_id]" 
						    id="partners_movement_action-action_id" value="<?php echo $record['partners_movement_action.action_id']; ?>" />
						    <input type="hidden" name="partners_movement_action[type_id]" 
						    id="partners_movement_action-type_id" value="<?php echo $type_id; ?>" />
								<div class="form-group">
									<label class="control-label col-md-3">
										Due to
									</label>
									<div class="col-md-7">
										<div class="input-group">
											<span class="input-group">
												<input disabled type="text" class="form-control" 
												value="<?php echo $cause ?>" >
											</span>
										</div> 				
									</div>	
								</div>		
								<div class="form-group">
									<label class="control-label col-md-3">
										Effective
									</label>
									<div class="col-md-7">							
										<div class="input-group input-medium" data-date-format="MM dd, yyyy">
											<input disabled type="text" class="form-control" name="partners_movement_action[effectivity_date]" 
											value="<?php echo $record['partners_movement_action.effectivity_date']; ?>"
											id="partners_movement_action-effectivity_date"  value="<?php echo $record['partners_movement_action.effectivity_date'] ?>" placeholder="Enter Effective" readonly>
											<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div> 				
									</div>	
								</div>			
								<div class="form-group">
									<label class="control-label col-md-3"><?php echo $type; ?> Remarks</label>
									<div class="col-md-7">							
										<textarea disabled class="form-control" name="partners_movement_action[remarks]" id="partners_movement_action-remarks" placeholder="Enter Additional Remarks" rows="4"><?php echo $record['partners_movement_action.remarks'] ?></textarea> 				
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
        <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
        <!-- <button type="button" class="btn green" onclick="save_movement( $(this).parents('form'), 'modal' )">Save</button> -->
    </div>
</form>

<script language="javascript">
    $(document).ready(function(){

        if (jQuery().datepicker) {
            $('#partners_movement_action-effectivity_date').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); 
        }

        $("#partners_movement_action-user_id").select2({
			placeholder: "Select a partner",
			allowClear: true
		});

		$('.partner_id').change(function(){
			var type = $(this).data('type');
			if(type==1 || type==3 || type==8 || type==9 || type==12){
				get_employee_details($(this).val(), $(this).data('count'));
			}else if(type==2 || type==4){
				get_current_salary($(this).val());
			}
		});

    });
</script>