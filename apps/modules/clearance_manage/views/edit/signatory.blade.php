<div class="portlet">
	<div class="portlet">
        <div class="portlet-title">
            <div class="caption">{{ lang('clearance_manage.clear') }} <span class="small text-muted"> {{ lang('common.view') }}</span></div>
        </div>
            
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <!-- <form action="#" class="form-horizontal"> -->
                <div class="form-body">
                	<div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_manage.employee') }}
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['firstname'] }} {{ $partner_record['lastname'] }}" /> 	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_manage.department') }}
                        	<span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['dept'] }}" /> 	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_manage.company') }} <span class="required">*</span>
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" readonly value="{{ $partner_record['comp'] }}" /> 
                        </div>
                    </div>
                    
                    <div class="form-group">
						<label class="control-label col-md-4">{{ lang('clearance_manage.effectivity') }}<span class="required">*</span></label>
						<div class="col-md-5">							
                            <input type="text" class="form-control" readonly value="{{ date('F d, Y', strtotime($clearance_record['effectivity_date'])) }}" /> 
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">Turnaround Date{{ lang('clearance_manage.tat') }}<span class="required">*</span></label>
						<div class="col-md-5">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="partners_clearance[turn_around_time]" id="partners_clearance-turn_around_time" value="{{ $clearance_record['turn_around_time'] }}" placeholder="Enter Turnaround Date" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_manage.clearance_template') }}<span class="required">*</span>
                        </label>
                        <div class="col-md-5">                        
                        	<?php
							$db->select('clearance_layout_id, layout_name');
							$db->where('deleted', '0');
							$options = $db->get('partners_clearance_layout');
							$clearance_layout_id_options = array('0' => 'Select...');
								foreach($options->result() as $option)
								{
									$clearance_layout_id_options[$option->clearance_layout_id] = $option->layout_name;
								} 
								// echo "<pre>";print_r($clearance_layout_id_options);
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('partners_clearance[clearance_layout_id]',$clearance_layout_id_options, $layout_record['clearance_layout_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance-clearance_layout_id"') }}
							</div>
                        </div>
                    </div>

					<br>


					<!--Signatories Remarks-->
                    <div class="portlet margin-top-25">
						<div class="portlet-title">
							<div class="caption">{{ lang('clearance_manage.signatories_remark') }}</div>
							<div class="tools">
								<a class="collapse" href="javascript:;"></a>
							</div>
						</div>
						<p class="margin-bottom-25 small">{{ lang('clearance_manage.note_signatories') }}</p>

						<div class="portlet-body">
							<div class="clearfix">
								<button type="button" class="btn btn-success pull-right margin-bottom-25" data-toggle="modal" onclick="add_sign(0)">Add Signatories</button>
							</div>
                            <!-- /. Clearance: modal -->
							<?php //include "partners_clearance_signatory-add.php" ?>
							<!-- /.modal -->
							<div name="signatories" id="signatories">
							<?php 
								foreach( $sign_records as $value)
								{
							?>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h3 class="panel-title"><?php echo $value['panel_title'] ?>
												<span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['clearance_signatories_id']?>)" href="#">Delete</a></span>
												<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
												<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['clearance_signatories_id']?>)" href="#">Edit</a></span>
											</h3>
										</div>
											
										<table class="table">
											<tr>
												<td width="30%" class="active">
													<span class="bold">{{ lang('clearance_manage.sign') }}</span>
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
							                            // echo "<pre>";print_r($user_id_options);
							                        ?>
							                        <div class="input-group">
							                            <span class="input-group-addon">
							                                <i class="fa fa-list-ul"></i>
							                            </span>
							                            <?php echo form_dropdown('partners_clearance_layout_sign[user_id]',$user_id_options, $value['user_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id"') ?>
							                        </div>
												</td>
											</tr>
											<tr>
												<td class="active"><span class="bold">{{ lang('clearance_manage.accountabilities') }} </span></td>
												<td>
													<span class="pull-right small text-muted">
									                   <a class="pull-right small text-muted">{{ lang('common.delete') }}</a>
									                </span>
													<input type="text" class="form-control"><br>
													<span>
									                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" href="#temp_section">{{ lang('clearance_manage.add_item') }}</button>
									                </span>
									        	</td>
											</tr>
											<tr >
												<td class="active"><span class="bold">{{ lang('clearance_manage.remarks') }}</span></td>
												<td><textarea rows="2" class="form-control"></textarea></td>
											</tr>
											<tr>
												<td class="active"><span class="bold">{{ lang('clearance_manage.status') }}</span></td>
												<td>
													<select  class="form-control select2me" data-placeholder="Select...">
									                    <option>{{ lang('common.clear') }}</option>
									                    <option>Pending</option>
									                </select>
												</td>
											</tr>
										</table>
									</div>
							<?php
								}
							?>
						</div>
<!--
<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
    });
</script-->
							
						</div>
					</div>
					<!--End-->



                </div>

                <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-4 col-md-8">
                            	@if($clearance_record['status_id'] == 1)
        						<button type="button" class="btn yellow btn-sm" onclick="send_sign( $(this).closest('form'), 2)">Send to Signatories</button>
                                @endif
                                <a href="clearance_emp-view.php" class="btn btn-default btn-sm" type="button"> Back to list</a>
                                                           
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
            <!-- END FORM--> 
        </div>
    </div>
</div>
<!-- End Edit -->