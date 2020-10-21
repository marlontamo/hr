<tr class="record">
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
                        <div class='' style='padding:0;'>
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
        <span id="time_name">{{$date_tag}}</span>
        <span class="small text-muted">{{ date('l', strtotime($date)) }}</span>
        <br>
        <?php if($aux_shift_id <> 0) { 
            $shiftid = $aux_shift_id;
            $shiftname = $aux_shift;
            ?>
            <span class="small text-danger">{{$aux_shift}}</span>
        <?php }else{ 
            $shiftid = $shift_id;
            $shiftname = $shift;
            ?>
            <span class="small text-muted">{{$shift}}</span>
        <?php } ?>
        <input type="hidden" name="date[]" value="{{ $date }}">
    </td>
    <td class="text-right" style="border-left:1px solid #eeeeee">
        <input type="hidden" value="{{ $shift_id }}" name="shift_id[{{ $date }}]">
        <select class="form-control select2me shift_id" data-placeholder="Select..." id="time_shift_id-{{ $record_id }}" name="shift[{{ $date }}]">
            @foreach ($time_shift_id_options as $key => $time_shift_id_option)
                <option value="{{ $key }}" {{ ($shiftid == $key) ? 'selected="selected"' : ''  }} shift="{{ $time_shift_id_option }}">{{ $time_shift_id_option }}</option>
            @endforeach
        </select>
        <input type="hidden" name="shiftname[{{ $date }}]" value="{{ $shiftname }}" class="shiftname">
    </td>
    <td class="text-right" style="border-left:1px solid #eeeeee">
        <?php $time_in = (!strtotime($time_in)) ? '': date('m/d/Y G:i', strtotime($time_in));  ?>                
        <div class="input-group date form_datetime" data-date-format="mm/dd/yyyy - hh:ii">                                       
            <input type="text" size="16" class="form-control datetime datetimein" name="timein[{{ $date }}]" 
            id="timein-<?php echo $record_id;?>" value="{{ $time_in }}" />
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div> 
        <input class="hidden" name="time_in_dtr[{{ $date }}]" value="{{$time_in_dtr}}"/>
        <span class="pull-left text-muted margin-left-10">

         <!-- <small>{{ (!strtotime($time_in_dtr)) ? '': date('F d Y G:i', strtotime($time_in_dtr)) }}</small> -->
            <small><?php if( $time_in_dtr && $time_in_dtr <> '0000-00-00 00:00:00'){
                            echo date('F d Y G:i', strtotime($time_in_dtr));
                        }
                    else {
                            echo '';
                        }  ?>
            </small>
        </span>
    </td>
    <td class="text-right" style="border-left:1px solid #eeeeee">
        <?php $time_out = (!strtotime($time_out)) ? '': date('m/d/Y G:i', strtotime($time_out));?>                
        <div class="input-group date form_datetime" data-date-format="mm/dd/yyyy - hh:ii">                                       
            <input type="text" size="16" class="form-control datetime datetimeout" name="timeout[{{ $date }}]" 
            id="timeout-<?php echo $record_id;?>" value="{{ $time_out }}" />
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
        <input class="hidden" name="time_out_dtr[{{ $date }}]" value="{{$time_out_dtr}}"/>
        <span class="pull-left text-muted margin-left-10">
        <!-- <small>{{ (!strtotime($time_out_dtr)) ? '': date('F d Y G:i', strtotime($time_out_dtr)) }}</small> -->
            <small><?php if( $time_out_dtr && $time_out_dtr <> '0000-00-00 00:00:00'){
                            echo date('F d Y G:i', strtotime($time_out_dtr));
                        }
                    else {
                            echo '';
                        }  ?>
            </small>
        </span>
    </td>
    <td class="text-right" style="border-left:1px solid #eeeeee">
        <textarea class="form-control"  placeholder="Enter Remarks" name="remarks[{{ $date }}]" style="height:37px">{{ $remarks or '' }}</textarea>
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
        $("input.datetime").datetimepicker({
            isRTL: App.isRTL(),
            format: "mm/dd/yyyy - hh:ii",
            autoclose: true,
            todayBtn: false,
            pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
            minuteStep: 1
        });

        $("#timein-{{ $record_id }}").datetimepicker('setStartDate', '{{ $timein_date }}');
        $("#timein-{{ $record_id }}").datetimepicker('setEndDate', '{{ $timeout_date }}');

        $("#timeout-{{ $record_id }}").datetimepicker('setStartDate', '{{ $date }}');
        $("#timeout-{{ $record_id }}").datetimepicker('setEndDate', '{{ $timeout_date2 }}');

        $('#time_shift_id-{{ $record_id }}').change(function() {
           var shiftname = $('option:selected', this).attr('shift');
           $(this).parents('td').find('.shiftname').val(shiftname);
        });

        @if($type == "manage")
            @if($status == 6 || ($status == 3 && $for_approval == 0))
                $('input, select.shift_id , textarea').attr("disabled", true); 

            @endif
        @else
            @if($status == 6 || $status == 2 || $status == 3)
                $('input, select.shift_id , textarea').attr("disabled", true); 
            @endif
        @endif
    });
</script>