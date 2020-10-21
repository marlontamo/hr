<div class="modal-body padding-bottom-0">
    <div class="clearfix row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="contributor-form">
                    <?php
                        foreach( $post as $var => $value )
                        {
                            echo '<input type="hidden" name="'.$var.'" value="'.$value.'">';
                        }
                    ?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Select</label>
                            <div class="col-md-7">
                                <input id="contributors" class="form-control" name="contributors" type="text" placeholder="Crowdsource..." value="<?php echo implode(',', $contributor)?>"/>
                                <div class="help-block small">
                                    You can select multiple crowdsource but the maximum number is 5.
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>
    <button type="button" class="btn green btn-sm" onclick="add_contributors()">Finalize Crowdsource</button>
</div>

<script>
    var current_draft = new Array();
    var current_approve = new Array();
    <?php if( sizeof($contributor ) )
    {
        $this->db->where('user_id in ('.implode(',', $contributor).')');
        $users = $this->db->get('users');
        foreach( $users->result() as $row ): 
            if(in_array($row->user_id, $approved_con)):?>
                current_approve[<?php echo $row->user_id?>] = '<?php echo $row->full_name?>';
            <?php endif; ?>
            current_draft[<?php echo $row->user_id?>] = '<?php echo $row->full_name?>'; <?php
        endforeach;
    }?>
</script>