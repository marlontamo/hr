
<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" />
<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/app.css">
<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
<div class="modal-body padding-bottom-0">
    <div class="row">
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
                            <label class="control-label col-md-3"><?=lang('performance_appraisal_manage.select')?></label>
                            <div class="col-md-7">
                                <input id="contributors" class="form-control" name="contributors" type="text" placeholder="Crowdsource..." />
                                <div class="help-block small">
                                    <?=lang('performance_appraisal_manage.multiple_emp_note')?>
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
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.cancel')?></button>
    <button type="button" class="btn green btn-sm" \ onclick="add_contributors()"><?=lang('common.add')?></button>
</div>
