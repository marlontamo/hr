<div id="edit-reassign-form">

    <form class="form-horizontal" name="edit-reassign-form" id="edit-reassign-form" fg_id="calman-range">

        <input type="hidden" id="current_approver_id" name="current_approver_id" value="<?php echo $approver_id; ?>">
        <input type="hidden" id="forms_id" name="forms_id" value="<?php echo $forms_id; ?>">

    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="customCloseButtonCallback();"></button>
    		<h4 class="modal-title"><?php echo lang('form_application_manage.select_newapp')?></h4>
    	</div>

    	<div class="modal-body padding-bottom-0">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="portlet">
                        <div class="portlet-body form">

                            <div class="small text-muted margin-bottom-20">
                                <?php echo lang('form_application_manage.newapp_note')?>
                            </div>
                            
                            <!-- BEGIN FORM-->
                            <!-- <form action="#" class="form-horizontal"> -->
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3"><?php echo lang('form_application_manage.approver')?><span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <select  name="new_approver" id="new_approver" class="form-control select2me"  data-placeholder="Select...">
                                                <option value=""><?php echo lang('form_application_manage.search_app')?></option>
                                                <?php 
                                                    // foreach($shifts as $index => $value){
                                                    // $selected = ($value['shift_id'] == $shift_to['val']) ? "selected" : "";
                                                ?>
                                                <!-- <option value="<?//=$value['shift_id']?>" ><?//=$value['shift']?></option> -->
                                                <?php //} ?>
                                            </select>
                                        </div>
                                    </div>                            
                                </div>                            
                            <!-- </form> -->
                            <!-- END FORM--> 
                        </div>
                	</div>
    			</div>
    		</div>
    	</div>
    	<div class="modal-footer margin-top-0">
            <a type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?php echo lang('form_application_manage.cancel')?></a>    
    		<a type="button" class="btn btn-success btn-sm" onclick="update_approver()"><?php echo lang('form_application_manage.reassign')?></a>
    	</div>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){

    $(document).on("keyup",".select2-input",function(event){
        var search_str = this.value;
        var trim_str = search_str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        if(trim_str != ""){
            update_approvers(trim_str);
        }
    })

});

function update_approvers(search_str)
{
    $.ajax({
        url: base_url + module.get('route') + '/get_approvers',
        type: "POST",
        async: false,
        data: { search_str: search_str,
                current_approver_id: $('#current_approver_id').val()
              },
        dataType: "json",
        beforeSend: function () {
            // need to do something 
            // on before send?
        },
        success: function (response) {  
            $('#new_approver').html(response.approver_list);
            $('#new_approver').select2('destroy');
            $('#new_approver').select2();
            $('#new_approver').select2("open");
            $('.select2-input').val(search_str);
        }
    });      
}
</script>