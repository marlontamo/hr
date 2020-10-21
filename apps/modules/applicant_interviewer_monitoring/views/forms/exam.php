<div class="tab-pane active" id="tab_2-2">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Assessment List</div>
            <div class="tools">
                <a class="collapse" href="javascript:;"></a>
            </div>
        </div>
        <p>This section manage to add exams and show summary of results.</p>

        <div class="portlet-body form">
            <!-- START FORM -->
            <form action="#" class="form-horizontal" name="exam-form">
                <div class="form-body">
                    <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                    <div class="portlet">
                        <?php //if($process->status_id < 4){ ?>
                       <!--  <span class="pull-right margin-bottom-15">
                            <div class="btn btn-success btn-xs" onclick="add_exam_row()">+ Add Exam</div>
                        </span> -->
                        <?php //} ?>
                        <div class="portlet-body" >
                            <!-- Table -->
                            <table class="table table-condensed table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th width="25%" class="padding-top-bottom-10" >Exam Name</th>
                                        <th width="25%" class="padding-top-bottom-10" >Date</th>
                                        <th width="20%" class="padding-top-bottom-10 hidden-xs" >Score</th>
                                        <th width="20%" class="padding-top-bottom-10 hidden-xs" >Status</th>
                                        <th width="10%" class="padding-top-bottom-10" >Action</th>
                                    </tr>
                                </thead>
                                <tbody id="saved-exams"><?php
                                    if( !empty($exams) ):
                                        foreach( $exams as $exam ): ?>
                                    <tr class="exam_assessment">
                                        <!--  shows the exam items -->
                                        <td>
                                            <input type="text" class="form-control" maxlength="64" name="exam_name[]" value="<?php echo $exam['exam_name'] ?>">
                                        </td>
                                        <td>
                                            <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                                                <input type="text" size="16" class="form-control" name="date_taken[]" value="<?php echo date( 'F d, Y', strtotime($exam['date_taken']) ) ?>">
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" maxlength="64" name="score[]" value="<?php echo $exam['score'] ?>" >
                                        </td> 
                                        <td>
                                            <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Passed&nbsp;&nbsp;" data-off-label="&nbsp;Failed&nbsp;">
                                             <input type="checkbox" value="0" <?php if( $exam['status_id'] ) echo 'checked="checked"'; ?> class="dontserializeme toggle exam_status"/>
                                            <input type="hidden" name="status[]" value="<?php echo ( $exam['status_id'] ) ? 1 : 0 ; ?>"/>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_exam_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
                                        </td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                             <div id="no_record_exam" class="well" style="display:none">
                                <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                <span><p class="small margin-bottom-0">
                                Zero (0) was found. Click Add Exam button to add to exam assessment.
                                </p></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
        <button type="button" data-loading-text="Loading..." onclick="save_exam()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button>
    </div>


<table style="display:none" id="exam-row">
    <tbody>
        <tr class="exam_assessment">
            <!--  shows the exam items -->
            <td>
                <input type="text" class="form-control" maxlength="64" name="exam_name[]" >
            </td>
            <td>
                <div class="input-group date date-picker" data-date-format="MM dd, yyyy">
                    <input type="text" size="16" class="form-control" name="date_taken[]">
                    <span class="input-group-btn">
                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                </div>
            </td>
            <td>
                <input type="text" class="form-control" maxlength="64" name="score[]" >
            </td> 
            <td>
                <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;Passed&nbsp;&nbsp;" data-off-label="&nbsp;Failed&nbsp;">
                 <input type="checkbox" value="0" checked="checked" name="status[temp][]" class="dontserializeme toggle exam_status"/>
                <input type="hidden" name="status[]" value="1"/>
                </div>
            </td>
            <td>
            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_exam_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
            </td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">

    var exam_assessment = $('.exam_assessment').length;
    if( !(exam_assessment > 1) ){
        $("#no_record_exam").show();
    }
</script>