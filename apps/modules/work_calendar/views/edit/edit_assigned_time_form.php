<form class="form-horizontal" name="edit-mtf-form" id="edit-mtf-form">
<!-- <div class="modal-dialog"> -->       
    <div class="modal-content">

        <input type="hidden" name="update_shift" value="1">
        <input type="hidden" name="date_shift" value="<?php echo $date; ?>">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="customCloseButtonCallback();"></button>
            <h4 class="modal-title"><?php echo $title; ?></h4>
            <h5 class="form-section" id="mpws_date"><?php echo $date; ?></h5>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-body form">

                            <!-- BEGIN FORM-->

                                <table class="table table-condensed table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="1%">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                            </th>
                                            <th width="30%">ID Number</th>
                                            <th width="45%" class="hidden-xs">Name</th>
                                            <th width="25%" class="hidden-xs">Shift</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php for($i=0; $i < count( $partners ); $i++){ ?>

                                        <tr rel="0">                                    
                                            <td>
                                                <input 
                                                    type="checkbox" 
                                                    class="checkboxes" 
                                                    name="user_id[<?php echo $i; ?>]" 
                                                    id="<?php echo $partners[$i]['user_id']; ?>"
                                                    value="<?php echo $partners[$i]['user_id']; ?>" />
                                            </td>
                                            <td>
                                                <a href="#" class="text-success"><?php echo $partners[$i]['id_number']; ?> </a>
                                            </td>
                                            <td>
                                                <?php echo $partners[$i]['display_name']; ?>   
                                            </td>
                                            <td>
                                                <select 
                                                        name="shift_id[<?php echo $i; ?>]" 
                                                        class="form-control selectM3" 
                                                        data-placeholder="Select...">
                                                    
                                                    <?php for($j=0; $j < count( $shifts ); $j++){ ?> 
                                                    <option value="<?php echo $shifts[$j]['shift_id']; ?>" <?php echo $shifts[$j]['shift_id'] === $partners[$i]['shift_id'] ? 'SELECTED' : ''; ?> >
                                                        <?php echo $shifts[$j]['shift']; ?>
                                                    </option>
                                                    <?php } ?>                                            
                                                </select>
                                            </td>
                                        </tr> 
                                        <?php } ?>                               
                                    </tbody>
                                </table>
                            <!-- </form> -->
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm" onclick="customCloseButtonCallback();">Close</button>
            <button type="button" class="btn green btn-sm" onclick="save_fg( $(this).parents('form') )">Save changes</button>
        </div>
    </div>
</form>
<!-- </div> -->


<script>

    var customHandleUniform = function () {
        if (!jQuery().uniform) {
            return;
        }

        var test = $("input[type=checkbox]:not(.toggle), input[type=radio]:not(.toggle, .star)");
        if (test.size() > 0) {
            test.each(function () {
                if ($(this).parents(".checker").size() == 0) {
                    $(this).show();
                    $(this).uniform();
                }
            });
        }
    }

    jQuery(document).ready(function() { 

        $('.selectM3').select2('destroy');   
        $('.selectM3').select2();
        customHandleUniform();
    });
</script>  