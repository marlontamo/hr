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
                        <div class="portlet-body">
                             <div class="small text-muted margin-bottom-20">
                                <?php echo lang('form_application_manage.newapp_note')?>
                            </div>
                            <div class="clearfix">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo $approver_title; ?></h4>
                                    </div>
                                    <table class="table">
                                        <?php foreach($approver_list as $index => $value){ ?>
                                        <tr>
                                            <td><?=$value['lastname'].', '.$value['firstname'] ?>
                                                <br><small class="text-muted"><?=$value['position']?></small>
                                                <?php if($time_forms_form_status_id > 2){ 
                                                        $form_style = 'info';
                                                        switch($value['form_status_id']){
                                                            case 8:
                                                                $form_style = 'default';
                                                            break;
                                                            case 7:
                                                                $form_style = 'danger';
                                                            break;
                                                            case 6:
                                                                $form_style = 'success';
                                                            break;
                                                            case 5:
                                                            case 4:
                                                            case 3:
                                                            case 2:
                                                                $form_style = 'warning';
                                                            break;
                                                            case 1:
                                                                $form_style = 'info';
                                                            break;
                                                        }
                                                    ?>
                                                <br><p><span class="badge badge-<?php echo $form_style ?>"><?=$value['form_status']?></span></p> </li>
                                            <?php } ?>
                                            </td>
                                            <td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                    </div> 
                        </div>
                    </div>
                </div>
    			<div class="col-md-12">
    				<div class="portlet">
                        <div class="portlet-body form">

                                                      
                            <!-- BEGIN FORM-->
                            <!-- <form action="#" class="form-horizontal"> -->
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3"><?php echo lang('form_application_manage.approver')?><span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <select  name="new_approver" id="new_approver" class="form-control select2me"  data-placeholder="Select...">
                                                <option value=""><?php echo lang('form_application_manage.search_app')?></option>
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
        url: base_url + '<?=$form_application_manage_route?>' + '/get_approvers',
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

function update_approver(  )
{
    $.blockUI({ message: '<div>Updating approver, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            var new_approver = $('#new_approver').val();
            var current_approver_id = $('#current_approver_id').val();
            var forms_id = $('#forms_id').val();
            $.ajax({
                url: base_url + '<?=$form_application_manage_route?>' + '/update_approver',
                type:"POST",
                data: { new_approver : new_approver,
                        current_approver_id : current_approver_id,
                        forms_id : forms_id
                },
                dataType: "json",
                async: false,
                success: function ( response ) {
                    $('.modal').modal('hide');
                    handle_ajax_message( response.message );

                    if(response.saved )
                    {
                        setTimeout(function(){window.location.replace(base_url + module.get('route') + '/updating/manage')},1000);
                        // window.location.replace(base_url + module.get('route'));
                    }
                }
            });
        }
    });
    $.unblockUI();
}

</script>