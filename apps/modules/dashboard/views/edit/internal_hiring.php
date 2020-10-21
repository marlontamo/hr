<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo $position ?></h4>
    <input type="hidden" name="position" id="position" value="<?php echo $position ?>">
    <p class="text-muted small"><?php echo lang('dashboard.internal_hiring') ?></p>

</div>
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal">
                    <div class="form-body">
                        <h4 class="bold"><?php echo lang('dashboard.internal_jd') ?></h4>

                       <?php echo $job_description ?>
                       <br>

                        <hr>

                        <p><span class="bold"><?php echo lang('dashboard.internal_cletter') ?>:</span> <br>
                        <?php echo lang('dashboard.internal_why') ?></p>
                        <textarea class="form-control" width="100%" name="cover_letter" id="cover_letter"></textarea>
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">

    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?php echo lang('dashboard.internal_cancel') ?></button>
    <a type="button" class="btn green btn-sm" onclick="save_internal_hiring(<?php echo $request_id ?>)"><?php echo lang('dashboard.internal_submit') ?></a>
</div>