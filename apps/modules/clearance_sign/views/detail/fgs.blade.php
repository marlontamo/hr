<div class="portlet">
	<div class="portlet">
        <div class="portlet-title">
            <div class="caption">{{ lang('clearance_signatories.clearance_signatories_information') }} <span class="small text-muted"> {{ lang('clearance_signatories.edit') }}</span></div>
        </div>
            
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <!-- <form action="#" class="form-horizontal"> -->
                <div class="form-body">
                	<div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_signatories.signatory_layout') }}
                        	
                        </label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="partners_clearance_layout[layout_name]" id="partners_clearance_layout-layout_name" value="{{ $record['layout_name'] }}" placeholder="{{ lang('clearance_signatories.p_signatory_layout') }}" /> 	
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_signatories.company') }}
                        	
                        </label>
                        <div class="col-md-5">
                        	<?php
							$db->select('company_id, company');
							$db->where('deleted', '0');
							$options = $db->get('users_company');
							$company_id_options = array('0' => 'Select...');
								foreach($options->result() as $option)
								{
									$company_id_options[$option->company_id] = $option->company;
								} 
								// echo "<pre>";print_r($company_id_options);
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('partners_clearance_layout[company_id]',$company_id_options, $record['company_id'], 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout-company_id"') }}
							</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_signatories.department') }}
                        	
                        </label>
                        <div class="col-md-5">
                        	<?php
							$db->select('department_id, department');
							$db->where('deleted', '0');
							$options = $db->get('users_department');
							$department_id_options = array();
								foreach($options->result() as $option)
								{
									$department_id_options[$option->department_id] = $option->department;
								} 
								// echo "<pre>";print_r($department_id_options);
							?>
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('partners_clearance_layout[department_id][]',$department_id_options, explode(',', $record['department_id']), 'class="form-control select2" data-placeholder="Select..." multiple id="partners_clearance_layout-department_id"') }}
							</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">{{ lang('clearance_signatories.is_default') }} 
                        </label>
                        <div class="col-md-5">
	                        <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;{{ lang('clearance_signatories.option_no') }}&nbsp;">
	                            <input type="checkbox" value="1" @if( $record['default'] ) checked="checked" @endif name="partners_clearance_layout[default][temp]" id="partners_clearance_layout-default-temp" class="dontserializeme toggle"/>
	                            <input type="hidden" name="partners_clearance_layout[default]" id="partners_clearance_layout-default" value="@if( $record['default'] ) 1 else 0 @endif"/>
	                        </div> 
                        </div>
                    </div>
                  
					<br>
					<!--Signatories Remarks-->
                    <div class="portlet sign_remarks @if(!$record_id>0) hidden @endif">
						<div class="portlet-title">
							<div class="caption">{{ lang('clearance_signatories.signatories_remarks') }}</div>
							<div class="tools">
								<a class="collapse" href="javascript:;"></a>
							</div>
						</div>
						<p class="margin-bottom-25 small">{{ lang('clearance_signatories.signatories_note') }}</p>

						<div class="portlet-body">
							<!-- <div class="clearfix">
								<button type="button" class="btn btn-success pull-right margin-bottom-25" onclick="add_sign(0)">{{ lang('clearance_signatories.add_signatories') }}</button>
							</div> -->
                            <!-- /. Clearance: modal -->
							<?php //include "partners_clearance_signatory-add.php" ?>
							<!-- /.modal -->
							<div id="signatories" name="signatories">
							</div>
						
						</div>
					</div>
					<!--End-->


	<div class="modal fade modal-container modal-signatories" tabindex="-1" aria-hidden="true" data-width="600"></div>

                </div>

                <!-- <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-4 col-md-8">
                               <a href="clearance_emp-view.php" class="btn btn-default btn-sm" type="button"> Back to list</a>
                                                           
                            </div>
                        </div>
                    </div>
                </div> -->
            <!-- </form> -->
            <!-- END FORM--> 
        </div>
    </div>
</div>