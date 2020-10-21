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
										<span class="required">* </span>Emloyee
									</label>
									<div class="col-md-7">
										<?php
										$qry_category = $this->mod->get_role_category();
										if($type_id == 10){ //end of contract
											$db->select('users.user_id, users.display_name');
											$db->from('users');
											$db->join('partners', 'users.user_id = partners.user_id');
											$db->join('users_profile', 'users_profile.user_id = partners.user_id');

									        if ($qry_category != ''){
									            $this->db->where($qry_category, '', false);
									        }	
									        										
											$db->where('users.active', '1');
											$db->where('users.deleted', '0');
											$db->where('users.role_id <>', '1');
											$db->where_in('status_id', array(3, 4, 5, 6, 7));
											$db->order_by('users.display_name', '0');
											$options = $db->get(); 
										}else{
											$db->select('users.user_id,users.display_name');
											$db->join('partners', 'users.user_id = partners.user_id');
											$db->join('users_profile', 'users_profile.user_id = partners.user_id');
											$db->order_by('display_name', '0');
									        if ($qry_category != ''){
									            $this->db->where($qry_category, '', false);
									        }			

											if ($record['partners_movement_action.action_id'] < 1){
												$db->where('users.active', '1');
											}	

											$db->where('users.role_id <>', '1');
											$db->where('users.deleted', '0');
											$options = $db->get('users'); 
										}                          
											$partners_movement_action_user_id_options = array('' => 'Select...');

											$disable = 'disabled';
										?>
										<div class="input-group">
											<input type="hidden" class="form-control" name="partners_movement_action[user_id]" value="<?php echo $record['partners_movement_action.user_id']?>" />
											<span class="input-group-addon">
												<i class="fa fa-list-ul"></i>
											</span>
											<select <?php echo $disable ?> name="partners_movement_action[user_id]" data-count="<?php echo $count;?>" data-type="<?php echo $type_id?>"
											id="partners_movement_action-user_id"  class="form-control form-select partner_id" data-placeholder="Select...">
											<option value="">Select...</option>
												<?php 
													foreach($options->result() as $option)
													{
													$selected = ($option->user_id == $record['partners_movement_action.user_id'] ? "selected" : "");
												?>
													<option <?php echo $selected; ?> value="<?php echo $option->user_id ?>"><?php echo $option->display_name; ?> </option>
												<?php
													} 
												?>
											</select>
										</div> 				
									</div>	
								</div>		
								<div class="form-group">
									<label class="control-label col-md-3">
										Effective
									</label>
									<div class="col-md-7">			
										<input type="hidden" class="form-control" name="partners_movement_action[effectivity_date]" value="" />				
										<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
											<input disabled type="text" class="form-control" name="partners_movement_action[effectivity_date]" 
											value="<?php echo ($record['partners_movement_action.effectivity_date'] && $record['partners_movement_action.effectivity_date'] != '0000-00-00' && $record['partners_movement_action.effectivity_date'] != 'January 01, 1970' && $record['partners_movement_action.effectivity_date'] != 'November 30, -0001') ? $record['partners_movement_action.effectivity_date'] : '' ?>"
											id="partners_movement_action-effectivity_date"  value="<?php echo $record['partners_movement_action.effectivity_date'] ?>" placeholder="Enter Effective" readonly>
											<span class="input-group-btn">
												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div> 				
									</div>	
								</div>	
								<div class="form-group">
									<label class="control-label col-md-3">
										<span class="required">* </span>Reason
									</label>
									<div class="col-md-7">
										<?php									                            		
										$db->select('remarks_print_report_id,remarks_print_report');
										$db->order_by('remarks_print_report', '0');
										$db->where('deleted', '0');
										$options = $db->get('partners_movement_remarks'); 	                            
										$partners_movement_remarks_print_report_id_options = array('' => 'Select...');
										foreach($options->result() as $option)
										{
											$partners_movement_remarks_print_report_id_options[$option->remarks_print_report_id] = $option->remarks_print_report;
										} 
										?>							
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-list-ul"></i>
											</span>
											<?php echo form_dropdown('partners_movement_action[remarks_print_report_id]',$partners_movement_remarks_print_report_id_options, $record['partners_movement.remarks_print_report_id'], 'class="form-control select2me" data-placeholder="Select..." id="remarks_print_report_id"') ?>
										</div> 				
									</div>	
								</div>										
<!-- 								<div class="form-group">
									<label class="control-label col-md-3"><?php echo $type; ?> Remarks</label>
									<div class="col-md-7">							
										<textarea class="form-control" name="partners_movement_action[remarks]" id="partners_movement_action-remarks" placeholder="Enter Additional Remarks" rows="4"><?php echo $record['partners_movement_action.remarks'] ?></textarea> 				
									</div>	
								</div> -->
								<div class="form-group">
									<label class="control-label col-md-3">Attachments</label>
									<div class="col-md-7">
										<span class="btn green fileinput-button">
											<i class="fa fa-plus"></i>
											<span>
												Add files...
											</span>
											<input type="file" id="partners_movement-photo-fileupload" name="files[]" multiple>
										</span>										
										<!-- The table listing the files available for upload/download -->
										<br /><br />
										<table role="presentation" class="table table-striped clearfix">
										<tbody class="files">
											<?php
											if (!empty($record['attachement'])){
												foreach ($record['attachement'] as $key => $value) {
				                                	$filename = urldecode(basename($value->photo)); 
				                                	if(strtolower($filename) == 'avatar.png'){
				                                		$record['partners_movement_action.photo'] = '';
				                                		$filename = '';
				                                	}													
											?>
												    <tr class="template-download">
												    	<input type="hidden" name="partners_movement_action[photo][]" value="<?php echo $value->photo ?>"/>
												    	<input type="hidden" name="partners_movement_action[type][]" value="<?php echo $value->type ?>"/>
												    	<input type="hidden" name="partners_movement_action[filename][]" value="<?php echo $value->filename ?>"/>
												    	<input type="hidden" name="partners_movement_action[size][]" value="<?php echo $value->size ?>"/>												    	
												        <td>
												        	<?php if ($value->type == 'img') { ?>
												            <span class="preview">
												                   <a href="javascript:void(0)" title="<?php echo $value->photo ?>" data-gallery><img src="<?php echo base_url() ?>uploads/movement/thumbnail/<?php echo $filename?>"></a>
												            </span>
												            <?php } ?>
												        </td>
												        <td>
												            <p class="name">
												            	<a href="javascript:void(0)" title=""><?php echo $filename ?></a>
												            </p>
												        </td>
												        <td>
												            <span class="size"><?php echo $value->size ?></span>
												        </td>
												        <td>
												        	<a data-dismiss="fileupload" class="btn red delete_attachment">
											                    <i class="glyphicon glyphicon-trash"></i>
											                    <span>Delete</span>
												        	</a>
												        </td>
												    </tr>
											<?php
												}
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
			</div>
		</div>
	</div>

    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="button" class="btn green" onclick="save_movement( $(this).parents('form'), 'modal' )">Save</button>
    </div>
</form>

<script language="javascript">
    $(document).ready(function(){

        if (jQuery().datepicker) {
        	$("#partners_movement_action-effectivity_date").datepicker().datepicker('disable');
/*            $('#partners_movement_action-effectivity_date').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });*/
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
			}else if(type==15 || type==17){
				get_end_date($(this).val());
			}
		});

    });
</script>