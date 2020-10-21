
<form class="form-horizontal" name="edit-mtf-list" id="form-calman-mplist" fg_id="calman-mplist">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Employee List Form</h4> 
        <span class="text-muted padding-3 small">
           <?php echo date("F d, Y - D", strtotime($start_date) ); ?> to <?php echo date("F d, Y - D", strtotime($end_date) ); ?>
        </span>
    </div>
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-3">
                <div class="portlet">
                    <div class="portlet-body" >

                        <input type="hidden" name="date[start]" value="<?php echo date("Y-m-d", strtotime($start_date) ); ?>">
                        <input type="hidden" name="date[end]" value="<?php echo date("Y-m-d", strtotime($end_date) ); ?>">

                        <div id="available_schedules" class="list-group">

                            <?php for($i=0; $i < count( $currentday_schedules ); $i++){ ?>
                                <a href="javascript:;" class="list-group-item small available_scheds" data-shift-id="<?php echo $currentday_schedules[$i]['form_id']; ?>">
                                    <?php echo $currentday_schedules[$i]['title']; ?>
                                </a>
                            <?php } ?>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="portlet">
                    <div class="portlet-body" >
                        <div class="clearfix margin-bottom-10">

                            <div class="col-md-4 padding-none">
                                <div class="input-icon right">
                                    <i class="fa fa-search"></i>
                                    <input id="search-partner" type="text" placeholder="Find employee ... " class="form-control tooltips" data-placement="bottom" data-original-title="Search employees based on selected schedule.">
                                </div>
                            </div>

                            <div class="col-md-3" id="loading"></div>

                            <div class="col-md-5 padding-none">

                                <div 
                                    id="batch_button" 
                                    class="batch_button" 
                                    onclick="toggleBatchUpdate()">

                                    <a class="btn btn-success pull-right tooltips" 
                                        id="goto_batch_edit" 
                                        data-placement="left" 
                                        data-original-title="Use to edit multiple selected employees.">Batch Update</a>
                                </div>

                                <div 
                                    id="batch_select" 
                                    class="col-md-offset-4 col-md-8 padding-none batch_select" 
                                    style="display:none"
                                    onclick="toggleBatchUpdate()">
 
                                    <select id="batch_update" class="form-control selectM3 input-sm" data-placeholder="Select...">
                                        <option value="" selected="selected">--</option>
                                        <?php for($j=0; $j < count( $shifts ); $j++){ ?>
                                        <option value="<?php echo $shifts[$j]['shift_id']; ?>">
                                            <?php echo $shifts[$j][ 'shift']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <a class="small text-muted pull-right" id="goback_batch_action" style="cursor: pointer">close</a>
                                </div>
                            </div> 
                        </div>



                        <!-- Table -->
                        <table id="partners-list-table" class="table table-condensed table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th width="1%">
                                        <input 
                                            type="checkbox" 
                                            class="group-checkable" 
                                            data-set="#sample_2 .checkboxes" 
                                            onclick="toggle_check_all(this)" />
                                    </th>
                                    <th width="30%">Employee</th>
                                    <th width="30%" class="hidden-xs">Current Schedule</th>
                                    <th width="35%" class="hidden-xs">
                                        Assign New Shift
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php for($i=0; $i < count( $partners ); $i++){ ?>
                                <tr rel="0">
                                    <td>
                                        <input 
                                            type="checkbox"                                            
                                            name="user_id[<?php echo $i; ?>]"
                                            id="chk_<?php echo $partners[$i]['user_id']; ?>" 
                                            class="checkboxes checkShift" 
                                            value="<?php echo $partners[$i]['user_id']; ?>"
                                            data-shift-id="<?php echo $shift_id ?>" 
                                           data-count="<?php echo $i; ?>"/>
                                    </td>
                                    <td>
                                        <span class="text-success"><?php echo $partners[$i]['display_name']; ?></span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">
                                            <?php echo $partners[$i]['id_number']; ?>
                                       </a>
                                    </td> 
                                    <td>
                                        <?php echo $partners[$i]['shift']; ?>
                                    </td>
                                    <td>
                                        <select  
                                            name="shift_id[<?php echo $i; ?>]" 
                                            id="select_<?php echo $partners[$i]['shift_id']; ?>"
                                            data-select-id="<?php echo $partners[$i]['user_id']; ?>"
                                            class="form-control shiftSelect" 
                                            data-placeholder="Select...">

                                            <option value="" selected="selected">--</option>

                                            <?php for($j=0; $j < count( $shifts ); $j++){ ?>
                                            
                                            <option value="<?php echo $shifts[$j]['shift_id']; ?>">
                                                <?php echo $shifts[$j]['shift']; ?>
                                            </option>

                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        <button type="button" class="btn green btn-sm" onclick="save_calendar( $(this).parents('form') )">Save changes</button>
    </div>
</form>


<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/select2/select2.min.js"></script>
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

    var gsd_is_processing = false;

    var getSearchData = function(keyword){

        if(gsd_is_processing) return;

        var data = {keyword: keyword};

        $.ajax({
            url: base_url + module.get('route') + '/get_search_data',
            type: "POST",
            async: false,
            data: data,
            dataType: "json",
            beforeSend: function () {

                gsd_is_processing = true;
                $('#loading').html('Please Wait...');
            },
            success: function (response) {
                $('#loading').html('');
                gsd_is_processing = false;

                if(response.partners_list.length){

                    $("table.table tbody tr").remove();
                    $("table.table tbody").append(response.partners_list);
                    
                    jQuery('select.selectM3').select2();
                    jQuery("select.shiftSelect").select2();

                    customHandleUniform();
                }
                else{

                    // will do something here...
                }
            },
            always: function(){

                gsd_is_processing = false;
            },
            error: function(request, status, error){

                console.log("Ooops! Something went wrong.");
            }
        }); 
    }

    jQuery(document).ready(function() {

        jQuery('select.selectM3').select2();
        jQuery("select.shiftSelect").select2();

        customHandleUniform();

        // THIS HAS BEEN TRANSFERED TO record_lsiting_custom.blade.php
        // no!, has not been, for it still don't work on stacked ajax built elements
        $('.shiftSelect').live('change', function(){

            var item_id = $(this).data('select-id');

            if( $(this).val() ){
                $('#chk_' + item_id).parents(".checker").children('span').addClass('checked');
                $('#chk_' + item_id).attr('checked', true);
            }
            else{
                $('#chk_' + item_id).parents(".checker").children('span').removeClass('checked');
                $('#chk_' + item_id).attr('checked', false);
            }            
        });

        $("#batch_update").live('change', function(){

            $(".shiftSelect").select2("val", $(this).val());

            if($(this).val()){
                
                $(".checkboxes").parents(".checker").children('span').addClass('checked');
                $(".checkboxes").attr('checked', true);
            }
            else {
                $(".checkboxes").parents(".checker").children('span').removeClass('checked');
                $(".checkboxes").attr('checked', false);
            }
        });

        $(".available_scheds").on('click', function(){

            var request_data = {shift_id: $(this).data('shift-id'), date: $("#current_date").val()}

            $.ajax({
                url: base_url + module.get('route') + '/get_available_schedules',
                type: "POST",
                async: false,
                data: request_data,
                dataType: "json",
                beforeSend: function () {
                    blockMe();
                },
                success: function (response) {

                    unBlockMe();

                    if (typeof (response.rows) != 'undefined') {

                        $("#partners-list-table tbody").empty();
                        $('#partners-list-table > tbody:last').append(response.rows);

                        //FormComponents.init();
                        customHandleUniform();                    
                    }

                    for (var i in response.message) {
                        if (response.message[i].message != "") {
                            notify(response.message[i].type, response.message[i].message);
                        }
                    }
                }
            });         
        });
        

        $("#search-partner").on('keyup', function(e){

            var keyword = $(this).val();

            if(e.keyCode == 13){
                getSearchData(keyword);
            }
        });

        $('.checkShift').change(function(){
            if (this.checked) {
                var index = $(this).data('count');
                var shift_id = $(this).data('shift-id');
                // $('select[name="shift_id['+index+']"] option[value="'+shift_id+'"]').attr('selected', 'selected');
                // $('select[name="shift_id['+index+']"]').val(shift_id);

                $('select[name="shift_id['+index+']"]').select2("val", shift_id);
            }
        });
    });
</script>  