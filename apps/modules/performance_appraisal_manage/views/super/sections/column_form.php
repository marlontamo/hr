<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" id="column-form">
                    <input type="hidden" name="section_column_id" value="{{ $section_column_id }}" />
                    <input type="hidden" name="template_section_id" value="{{ $template_section_id }}" />
                    <div class="form-body">                        
                        <div class="form-group">
                            <label class="control-label col-md-3"><?=lang('performance_appraisal_manage.col_title')?><span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="title" value="{{ $title }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?=lang('performance_appraisal_manage.sequence')?><span class="required">*</span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" name="sequence" value="{{ $sequence }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3"><?=lang('performance_appraisal_manage.ui_type')?><span class="required">*</span></label>
                            <div class="col-md-7">
                                <?php
                                    $uitype_options = array('' => 'Select');
                                    $qry = " select * 
                                    FROM {$db->dbprefix}performance_template_section_column_uitype
                                    WHERE deleted = 0";
                                    $options = $db->query( $qry );
                                    foreach( $options->result() as $row )
                                    {
                                        $uitype_options[$row->uitype_id] =  $row->uitype;
                                    }
                                ?>
                                {{ form_dropdown('uitype_id',$uitype_options, $uitype_id, 'class="form-control"') }}
                                <div class="help-block small">
                                    <?=lang('performance_appraisal_manage.select_uitype')?>
                                </div>
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
    <button type="button" class="btn green btn-sm" onclick="save_column()"><?=lang('common.add')?></button>
</div>