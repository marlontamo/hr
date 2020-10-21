<div class="tab-pane active" id="tab_2-2">
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Background Investigation
            </div>
            <div class="tools">
                <a class="collapse" href="javascript:;"></a>
            </div>
        </div>
        <p>This section manage to add conducted background investigation.</p>

        <div class="portlet-body form">
            <!-- START FORM -->
            <form action="#" class="form-horizontal" name="bi-form">
                <div class="form-body">
                    <input type="hidden"  name="process_id" value="<?php echo $process_id?>">
                    <div class="portlet">
                        <!-- <span class="pull-right margin-bottom-15"><div class="btn btn-success btn-xs" onclick="add_bi_row()">+ Add Item</div></span> -->
                        <div class="portlet-body" >
                            <table class="table table-condensed table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th width="28%" class="padding-top-bottom-10" >Item</th>
                                        <th width="27%" class="padding-top-bottom-10" >Date Check</th>
                                        <!-- <th width="25%" class="padding-top-bottom-10" >Conducted By</th> -->
                                        <th width="20%" class="padding-top-bottom-10 hidden-xs" >Status</th>
                                        <!-- <th width="10%" class="padding-top-bottom-10" >Action</th> -->
                                    </tr>
                                </thead>
                                <tbody id="saved-bis"><?php
                                    if( count($bis) > 0 ):
                                        foreach( $bis as $bi ): ?>
                                    <tr class="bi_form">
                                        <!--  shows the bi items -->
                                        <td>
                                            <span class="text-success"><?php echo $bi['background'] ?></span>
                                            <input type="hidden" class="form-control" maxlength="64" name="background_item_id[]" value="<?php echo $bi['item_id'] ?>">
                                        </td>
                                        <td>
                                            <div class="input-group date " data-date-format="MM dd, yyyy">
                                                <input type="text" disabled size="16" class="form-control" name="date_check[]" value="<?php if(strtotime($bi['date_check']))echo date( 'F d, Y', strtotime($bi['date_check']) ) ?>">
                                                <!-- <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span> -->
                                            </div>
                                        </td>
                                        <td>  
                                            <?php
                                                $bi_status = $db->get_where('recruitment_background_status', array('deleted' => 0));
                                                $option = array();
                                                foreach( $bi_status->result() as $status )
                                                {
                                                    $option[$status->status_id] = $status->status;
                                                }
                                                $value = isset( $key->key_value ) ? $key->key_value : '';
                                                echo form_dropdown('status_id[]', $option, $bi['status_id'] , 'class="form-control select2me" data-placeholder="Select..." ');
                                            ?>
                                        </td>
                                       <!--  <td>
                                            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_bi_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
                                        </td> -->
                                    </tr>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                             <div id="no_record_bi" class="well" style="display:none">
                                <p class="bold"><i class="fa fa-exclamation-triangle"></i> <?php echo lang('common.no_record_found') ?></p>
                                <span><p class="small margin-bottom-0">
                                Zero (0) was found. Click Add Item button to add to item for investigation.
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
        <!-- <button type="button" data-loading-text="Loading..." onclick="save_bi()" class="demo-loading-btn btn btn-success btn-sm"><?=lang('common.save')?></button> -->
    </div>


<table style="display:none" id="bi-row">
    <tbody>
        <tr class="bi_form">
            <!--  shows the bi items -->
            <td>
                <input type="text" class="form-control" maxlength="64" name="bi_name[]" >
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
                 <input type="checkbox" value="0" checked="checked" name="status[temp][]" class="dontserializeme toggle bi_status"/>
                <input type="hidden" name="status[]" value="1"/>
                </div>
            </td>
            <!-- <td>
            <a class="btn btn-xs text-muted" href="javascript:void(0)" onclick="delete_bi_row($(this))"><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
            </td> -->
        </tr>
    </tbody>
</table>


<script type="text/javascript">
    var bi_form = $('.bi_form').length;
    if( !(bi_form > 1) ){
        $("#no_record_bi").show();
    }
</script>