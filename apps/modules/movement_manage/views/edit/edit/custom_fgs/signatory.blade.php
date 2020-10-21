<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"> Signatories <br/><small class="text-muted">This movement form is signed by each department to clear an employee leaving the company. Per policy, the employee’s last pay will not be released without a properly accomplished movement form.</small></h4>
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
						    <!-- <input type="hidden" name="partners_movement_action[user_id]" id="partners_movement_action-user_id" value="<?php echo $record['partners_movement_action.user_id']; ?>" /> -->
							<!-- <?php if($movement_record['status_id'] == 1) { ?>
								<button type="button" class="btn btn-success pull-right margin-bottom-25" data-toggle="modal" onclick="add_sign(0)">Add Signatories</button>
							<?php } ?> -->
							</div>
							<div class="clearfix"></div>
							<div name="signatories" id="signatories">
								<?php foreach( $sign_records as $key => $value): ?>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h3 class="panel-title"><?php echo $value['panel_title'] ?>
<!-- 												<?php if($value['status_id'] == 1) {  ?>
													<span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['movement_signatories_id']?>)" href="#">Delete</a></span>
													<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
													<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['movement_signatories_id']?>)" href="#">Edit</a></span>
												<?php } ?> -->
											</h3>
										</div>
											
										<table class="table">
											<tr>
												<td width="30%" class="active">
													<span class="bold">Signatory</span>
												</td>
												<td>						
							                        <?php
							                        $db->select('user_id, full_name');
							                        $db->where('deleted', '0');
							                        $options = $db->get('users');
							                        $user_id_options = array('0' => 'Select...');
							                            foreach($options->result() as $option)
							                            {
							                                $user_id_options[$option->user_id] = $option->full_name;
							                            } 
							                        ?>
							                        <div class="input-group">
							                            <span class="input-group-addon">
							                                <i class="fa fa-list-ul"></i>
							                            </span>
							                            <?php $disabled = "disabled" ;
							                            	 echo form_dropdown('partners_movement_signatories[movement_signatories_id]['.$value['movement_signatories_id'].']',$user_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_movement_layout_sign-user_id" '.$disabled) ?>
							                        </div>
												</td>
											</tr>
<!-- 											<tr >
												<td class="active"><span class="bold">Remarks</span></td>
												<td><textarea rows="2" class="form-control" {{ ($value['status_id'] == 4) ? "disabled" : '' }}  name="partners_movement_signatories[remarks][{{ $value['movement_signatories_id'] }}]"><?php echo $value['remarks'] ?></textarea></td>
											</tr>
											<tr>
												<td class="active"><span class="bold">Status</span></td>
												<td>
													<select  class="form-control select2me" data-placeholder="Select..." {{ ($value['status_id'] == 4) ? "disabled" : '' }} name="partners_movement_signatories[status_id][{{ $value['movement_signatories_id'] }}]" >
														<option value="">Select...</option>
									                    <option value="4" {{ ($value['status_id'] == 4) ? "selected='selected'" : '' }} >Cleared</option>
									                    <option value="3" {{ ($value['status_id'] == 3) ? "selected='selected'" : '' }} >Pending</option>
									                </select>
												</td>
											</tr> -->
										</table>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="modal-footer margin-top-0">
       <!--  <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="button" class="btn green" onclick="save_movement( $(this).parents('form'), 'modal' )">Save</button> -->
    </div>
</form>

