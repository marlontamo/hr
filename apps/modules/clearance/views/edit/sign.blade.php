<form action="#" class="form-horizontal">
    <div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="portlet-body form">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group margin-bottom-25">
                            <label class="control-label col-md-3">Panel Title<span class="required">*</span></label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="partners_clearance_signatories[panel_title]" id="partners_clearance_signatories-panel_title" value="{{ $panel_title }}" placeholder="Enter Panel Name" />
                            <input type="hidden" class="form-control" name="partners_clearance_signatories[clearance_signatories_id]" id="partners_clearance_signatories-clearance_signatories_id" value="{{ $clearance_signatories_id }}"  /> 
                            <input type="hidden" class="form-control" name="partners_clearance_signatories[clearance_id]" id="partners_clearance_signatories-clearance_id" value="{{ $clearance_id }}"  /> 
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Company</label>
                            <div class="col-md-8">
                                <?php
                                $db->select('company_id, company');
                                $db->where('deleted', '0');
                                $options = $db->get('users_company');
                                $company_id_options = array('0' => 'Select...');
                                    foreach($options->result() as $option)
                                    {
                                        $company_id_options[$option->company_id] = $option->company;
                                    } 
                                ?>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-list-ul"></i>
                                    </span>
                                    {{ form_dropdown('partners_clearance_signatories[company_id]',$company_id_options, $company_id, 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_signatories-company_id"') }}
                                </div>
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label class="control-label col-md-3">Department</label>
                            <div class="col-md-8">
                                <?php
                                $db->select('department_id, department');
                                $db->where('deleted', '0');
                                $options = $db->get('users_department');
                                $department_id_options = array('0' => 'Select...');
                                    foreach($options->result() as $option)
                                    {
                                        $department_id_options[$option->department_id] = $option->department;
                                    } 
                                ?>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-list-ul"></i>
                                    </span>
                                    {{ form_dropdown('partners_clearance_signatories[department_id]',$department_id_options, $department_id, 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_signatories-department_id"') }}
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="control-label col-md-3">Signatory Name</label>
                            <div class="col-md-8">
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
                                    {{ form_dropdown('partners_clearance_signatories[user_id]',$user_id_options, $user_id, 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_signatories-user_id"') }}
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group ">
                            <label class="control-label col-md-3">Immediate Panel<span class="required">*</span></label>
                            <div class="col-md-8">
                                <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                    <input type="checkbox" value="1" @if( $is_immediate ) checked="checked" @endif name="partners_clearance_signatories[is_immediate][temp]" id="partners_clearance_signatories-is_immediate-temp" class="dontserializeme toggle"/>
                                    <input type="hidden" name="partners_clearance_signatories[is_immediate]" id="partners_clearance_signatories-is_immediate" value="@if( $is_immediate ) 1 else 0 @endif"/>
                                </div> 
                            </div>
                        </div> -->

                    </div>
                <!-- END FORM--> 
            </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn default btn-sm">Close</button>
		<button type="button" class="btn green btn-sm" onclick="save_signatory($(this).closest('form'))">Add Signatory</button>
	</div>
</form>

<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
        $('.make-switch').not(".has-switch")['bootstrapSwitch']();

        $('#partners_clearance_signatories-is_immediate-temp').change(function(){
            if( $(this).is(':checked') ){
                $('#partners_clearance_signatories-is_immediate').val('1');
            }else{
                $('#partners_clearance_signatories-is_immediate').val('0');
            }
        });
    });
</script>