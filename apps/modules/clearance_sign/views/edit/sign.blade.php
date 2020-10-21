<form action="#" class="form-horizontal">
    <div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="portlet-body form">
                <!-- BEGIN FORM-->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Item / Description<span class="required">*</span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="partners_clearance_layout_sign[item_description]" id="partners_clearance_layout_sign-item_description" value="{{ $item_description }}"  /> 
                                <input type="hidden" class="form-control" name="partners_clearance_layout_sign[clearance_layout_sign_id]" id="partners_clearance_layout_sign-clearance_layout_sign_id" value="{{ $clearance_layout_sign_id }}"  /> 
                                <input type="hidden" class="form-control" name="partners_clearance_layout_sign[clearance_layout_id]" id="partners_clearance_layout_sign-clearance_layout_id" value="{{ $clearance_layout_id }}"  /> 
                                <input type="hidden" class="form-control" name="partners_clearance_layout_sign[properties_tagging]" id="partners_clearance_layout_sign-properties_tagging" value="{{ $properties_tagging }}"  /> 
                            </div>
                        </div>

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
                                    {{ form_dropdown('partners_clearance_layout_sign[user_id]',$user_id_options, $user_id, 'class="form-control select2me" data-placeholder="Select..." id="partners_clearance_layout_sign-user_id"') }}
                                    <!-- <select id="partners_clearance_layout_sign-user_id" name="""partners_clearance_layout_sign[user_id]"></select> -->
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- END FORM--> 
            </div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn default btn-sm">Close</button>
		<button type="button" class="btn green btn-sm" onclick="save_sign($(this).closest('form'),'','',<?php echo $properties_tagging ?>)">Add Signatory</button>
	</div>
</form>

<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
        $('.make-switch').not(".has-switch")['bootstrapSwitch']();

        $('#partners_clearance_layout_sign-is_immediate-temp').change(function(){
            if( $(this).is(':checked') ){
                $('#partners_clearance_layout_sign-is_immediate').val('1');
            }else{
                $('#partners_clearance_layout_sign-is_immediate').val('0');
            }
        });
    });
</script>