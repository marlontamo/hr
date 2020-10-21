<tr rel="3">

    <td class="hidden-xs" style="border-right: 1px solid #eeeeee">
        <span data-trigger="hover"
        data-placement="right" data-html="true" 
        data-content="
                    <?php 
                    $pop_title = '';
                    $class_change = '';
                    if ($notes_icon == 'fa-coffee'){
                        $pop_title = $shift;
                        $class_change = '1';
                    ?>
                    <?php    
                    }else
                    if ($notes_icon == 'fa-calendar'){
                        $pop_title = $shift;
                    ?> 
                    <div class='clearfix'>
                        <div class='pull-right' style='padding:0; width: 200px;'>
                        <p style='margin-bottom:10px;'>{{ $notes }}</p>
                        </div>
                    </div>
                    <?php
                    }else if($notes_icon == 'fa-bullhorn'){
                        $pop_title = $blanket_name;
                    ?>                    
                    <div>
                    <?php 
                        if ($blanket_form_id == 3){
                    ?>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>From:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_date_from }}</span>
                            </div>
                        </div>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>To:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_date_to }}</span>
                            </div>
                        </div>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>Duration:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_detail }}</span>
                            </div>
                        </div>
                    <?php        
                        }else{
                    ?>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>Date:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_date_from }}</span>
                            </div>
                        </div>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>Time:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_detail }}</span>
                            </div>
                        </div>
                    <?php 
                        }
                    ?>
                        <div class='clearfix'>
                            <label class='control-label col-md-3 text-muted text-left small'>Reason:</label>
                            <div class='col-md-9'>
                                <span> {{ $blanket_reason }}</span>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>"
            data-original-title="{{ $pop_title }}"
            class="reminders{{ $class_change }} popovers"  >
            <i class="fa {{$notes_icon}}"></i>
        </span>        
    </td>
    
    <td>
        <span id="time_name">{{$employee_name}}</span>
        <!-- <span class="small text-muted">{{$day_tag}}</span> -->
        <br>
        <?php if($aux_shift_id <> 0) { 
            $shiftid = $aux_shift_id; ?>
            <span class="small text-muted">{{$aux_shift}}</span>
        <?php }else{ 
            $shiftid = $shift_id;?>
            <span class="small text-muted">{{$shift}}</span>
        <?php } ?>
    </td>
    
    <td class="">
    {{ form_dropdown("time_shift_id-$record_id",$time_shift_id_options, $shiftid, 'class="form-control select2me" data-placeholder="Select..." id="time_shift_id-'.$record_id.'"') }}
    </td>
    <td class="">       
    <?php $time_in = (!strtotime($time_in)) ? '': date('m/d/Y G:i', strtotime($time_in));  ?>                
        <div class="input-group date form_datetime" data-date-format="mm/dd/yyyy - hh:ii">                                       
            <input type="text" size="16" class="form-control datetime datetimein" name="ttimein-<?php echo $record_id;?>" 
            id="timein-<?php echo $record_id;?>" value="{{ $time_in }}" />
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div> 
    </td>

    <td class="">
    <?php $time_out = (!strtotime($time_out)) ? '': date('m/d/Y G:i', strtotime($time_out));?>                
        <div class="input-group date form_datetime" data-date-format="mm/dd/yyyy - hh:ii">                                       
            <input type="text" size="16" class="form-control datetime datetimeout" name="timeout-<?php echo $record_id;?>" 
            id="timeout-<?php echo $record_id;?>" value="{{ $time_out }}" />
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div> 
    </td>
    <td style="display:block; text-align:center; margin:0 auto;">
        <?php 
            if ($form_code != '' || $form_code != null){
        ?>
                <span class="badge badge-success custom_popover" 
                    onclick="get_form_details(<?php echo $form_id ?>, <?php echo $forms_id ?>, '<?php echo $date ?>')" 
                    style="cursor: pointer;"
                    data-placement="bottom"
                    data-original-title="<?php echo $form_code ?> <a href='#' class='close close-pop pull-right' style='margin-top:5px'><i class='fa fa-times'></i></a>"
                    data-forms-id="<?php echo $forms_id ?>"
                    data-forms-date="<?php echo $date ?>"
                    data-form-id="<?php echo $form_id ?>"
                    id="manage_dialog-<?php echo $forms_id ?>-<?php echo $date ?>">
                    <?php echo $form_code ?>
                </span>                
        <?php
            }
        ?>
    </td>
    <td>
        <a href="<?php echo site_url('time/applicationadmin/edit') ?>" class="btn btn-success btn-sm">
            <?php echo lang('admin_timerecord.apply') ?>
        </a>      
        <button type="button" class="btn green btn-sm" onclick="save_timerecord( <?php echo $record_id;?>, 'by_date' )"><i class="fa fa-check"></i> {{ lang('common.save') }} </button>
    </td>
</tr>
<?php
    $date_timein = strtotime ( '-1 day' , strtotime ( $date ) ) ;
    $timein_date = date("Y-m-d 12:01", $date_timein);
    $date_timeout = strtotime ( '+0 day' , strtotime ( $date ) ) ;
    $timeout_date = date("Y-m-d 23:59", $date_timeout);

    $date_timeout2 = strtotime ( '+1 day' , strtotime ( $date ) ) ;
    $timeout_date2 = date("Y-m-d 23:59", $date_timeout2);
    ?>
<script>
    $(document).ready(function(){
        $.fn.asyncEach = function(callback){
              var i = 0;
              var elements = this;
              var timer = setInterval(function(){
                callback.call(elements[i],elements[i]);
                if(++i >= elements.length) clearInterval(timer);
              },0);
        }

        $('select.select2me').select2();
        $('input.datetime').asyncEach(function(){
            $(this).datetimepicker({
                isRTL: App.isRTL(),
                format: "mm/dd/yyyy - hh:ii",
                autoclose: true,
                todayBtn: false,
                pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
                minuteStep: 1
            });
        });

        $('input.datetimein').asyncEach(function(){
            $(this).datetimepicker('setStartDate', '<?php echo $timein_date;?>');
        });
        $('input.datetimein').asyncEach(function(){
            $(this).datetimepicker('setEndDate', '<?php echo $timeout_date;?>');
        });

        $('input.datetimeout').asyncEach(function(){
            $(this).datetimepicker('setStartDate', '<?php echo $date;?>');
        });
        $('input.datetimeout').asyncEach(function(){
            $(this).datetimepicker('setEndDate', '<?php echo $timeout_date2;?>');
        });

        // $('select.select2me').select2();
        // $("input.datetime").datetimepicker({
        //     isRTL: App.isRTL(),
        //     format: "mm/dd/yyyy - hh:ii",
        //     autoclose: true,
        //     todayBtn: false,
        //     pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
        //     minuteStep: 1
        // });

        // $("input.datetimein").datetimepicker('setStartDate', '<?php echo $timein_date;?>');
        // $("input.datetimein").datetimepicker('setEndDate', '<?php echo $timeout_date;?>');

        // $("input.datetimeout").datetimepicker('setStartDate', '<?php echo $date;?>');
        // $("input.datetimeout").datetimepicker('setEndDate', '<?php echo $timeout_date2;?>');
    });
</script>