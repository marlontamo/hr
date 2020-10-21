<div class="modal-body padding-bottom-0">
    <div class="clearfix">
        <!-- BEGIN FORM-->
        <form id="crowdsource-form">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
            <input type="hidden" name="planning_id" value="<?php echo  $planning_id ?>" />
            <input type="hidden" name="section_id" value="<?php echo  $section_id ?>" />
            <div class="form-group">
                <label class="control-label col-md-12"><?php echo $section->template_section?><span class="required">*</span></label>
                <div class="col-md-12">
                    <input class="form-control" name="crowdsource_user_id" id="crowdsource_user_id" value="<?php echo $crowdsource_user_id?>">
                </div>
            </div>
        </form>
        <!-- END FORM--> 
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">Close</button>
    <?php if( in_array($planning->status_id, array( 0, 1, 3 )) ) : ?>
        <button class="btn green btn-sm" onclick="save_crowdsource_draft()" type="button">Save changes</button>
    <?php endif;?>
</div>

<script>
    var current_draft = new Array();
    <?php if( !empty($crowdsource_user_id) )
    {
        $this->db->where('user_id in ('.$crowdsource_user_id.')');
        $users = $this->db->get('users');
        foreach( $users->result() as $row ): ?>
            current_draft[<?php echo $row->user_id?>] = '<?php echo $row->full_name?>'; <?php
        endforeach;
    }?>

    function init_tags()
    {
        $('#crowdsource_user_id').tagsinput({
            itemValue: 'value',
            itemText: 'label',
            typeahead: {
                source: function(query) {
                    return $.getJSON(base_url + module.get('route') + '/tag_user' );
                }
            }
        });

        if( $('#crowdsource_user_id').val() != "" )
        {            
            var current = $('#crowdsource_user_id').val().split(',');
            for(var i in current)
            {
                $('#crowdsource_user_id').tagsinput('add', { "value": current[i], "label": current_draft[current[i]]});
            }
        }
    }

    function save_crowdsource_draft()
    {
       $.blockUI({ message: saving_message(),
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/save_crowdsource_draft',
                type: "POST",
                async: false,
                data: $('#crowdsource-form').serialize(),
                dataType: "json",
                success: function (response) {
                    handle_ajax_message( response.message );
                    if(response.success){
                        $('.crowdsource_list'+response.tsection_id).html(response.list_of_contributors);
                        $('.modal-container').modal('hide');
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();  
    }
</script>