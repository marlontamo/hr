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
                        $with_date_range = array(1, 2, 3, 4, 5, 6, 7, 8, 14, 16, 19, 20);
                        $with_date_time_range = array(9);
                        if (in_array($blanket_form_id, $with_date_range)){                        
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
                            }elseif (in_array($blanket_form_id, $with_date_time_range)){
                        ?>
                            <div class='clearfix'>
                                <label class='control-label col-md-3 text-muted text-left small'>From:</label>
                                <div class='col-md-9'>
                                    <span> {{ $blanket_date_time_from }}</span>
                                </div>
                            </div>
                            <div class='clearfix'>
                                <label class='control-label col-md-3 text-muted text-left small'>To:</label>
                                <div class='col-md-9'>
                                    <span> {{ $blanket_date_time_to }}</span>
                                </div>
                            </div>
                            <div class='clearfix'>
                                <label class='control-label col-md-3 text-muted text-left small'>Duration:</label>
                                <div class='col-md-9'>
                                    <span> {{ $blanket_detail }}</span>
                                </div>
                            </div>
                        <?php
                            } else {
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

    <td class="" style="border-right: 1px solid #eeeeee">
        <span data-original-title="Logs" data-content="You have incured 31 minutes of late, kindly file necessary form application" data-placement="right" data-trigger="hover" class="popovers">
            <i class="fa {{$remind_icon}}"></i>
        </span>
    </td>

    <td class="">
    </td>
    
    <td>
        <span id="time_name">{{$date_tag}}</span>
        <span class="small text-muted">{{$day_tag}}</span>
        <br>
        <?php if($aux_shift_id <> 0) { ?>
            <span class="small text-danger">{{$aux_shift}}</span>
        <?php }else{ ?>
            <span class="small text-muted">{{$shift}}</span>
        <?php } ?>
    </td>
    
    <td class="">
        <span class="" id="time_in"><?php echo $timein === NULL ? '': $timein;  ?>
        <span class="small text-muted">{{$timein_ampm}}</span></span>
        <span class="small" style="cursor:pointer">
            <!-- <i class="fa fa-pencil fa-border text-danger" data-toggle="modal" href="#cws_form"></i> -->
        </span>
        <span class="text-danger italic" style="font-size:75%"><br>
            <?php echo (empty($aux_time_in) || $aux_time_in == '0000-00-00 00:00:00') ? '' : '* '.date('g:i A', strtotime($aux_time_in)); ?>
        </span>
    </td>

    <td class="">
        <span class="" id="time_out"><?php echo $timeout === NULL ? '': $timeout;  ?>
        <span class="small text-muted">{{$timeout_ampm}}</span></span>
        <?php if(!empty($timeout_date)) : ?>
            <span class="small text-muted"><br>{{$timeout_date}}</span>
        <?php endif; ?>
        <span class="text-danger italic" style="font-size:75%"><br>
            <?php echo (empty($aux_time_out) || $aux_time_out == '0000-00-00 00:00:00') ? '' : '* '.date('g:i A', strtotime($aux_time_out)); ?>
        </span>
    </td>

    <td class="hidden-xs" style="border-left:1px solid #eeeeee">
        <span id=""> </span>
    </td>
    
    <td class="text-center">
        <span class="" id="hrs_worked"><?php echo $hrs_worked <> 0 ? $hrs_worked: '';  ?>
    </td>
    
    <td class="hidden-xs text-center" style="border-left:1px solid #eeeeee">
        <?php if($late <> 0) { ?>
        <a class="badge badge-important" href="javascript:void(0)"><?php echo $late ?></a>
        <?php } ?>
    </td>
    
    <td class="hidden-xs text-center" style="border-left:1px solid #eeeeee">
        <?php if($undertime <> 0) { ?>
        <a class="badge badge-important" href="javascript:void(0)"><?php echo $undertime ?></a>
        <?php } ?>
    </td>
    
    <td class="hidden-xs text-center" style="border-left:1px solid #eeeeee">
        <?php if($ot <> 0) { ?>
            <?php echo $ot ?>
        <?php } ?>
    </td>

    <td class="hidden-xs text-right" style="border-left:1px solid #eeeeee"> 
        <?php 
        foreach ($forms as $form) { 
            $form_style = 'info';
            switch($form['form_status_id']){
                case 8:
                    $form_style = 'default';
                break;
                case 7:
                    $form_style = 'danger';
                break;
                case 6:
                    $form_style = 'success';
                break;
                case 5:
                case 4:
                case 3:
                case 2:
                    $form_style = 'warning';
                break;
                case 1:
                    $form_style = 'info';
                break;
            }
        ?>
        <span class="badge badge-<?php echo $form_style; ?> custom_popover" 
                onclick="get_form_details(<?php echo $form['form_id'] ?>, <?php echo $form['forms_id'] ?>, '<?php echo $form['date'] ?>')"
                style="cursor: pointer;"
                data-width="500"
                data-content="" 
                data-placement="left" 
                data-original-title="<?php echo $form['form'] ?>"
                id="manage_dialog-<?php echo $form['forms_id'] ?>-<?php echo $form['date'] ?>"><?php echo $form['form_code']; ?></span>
        <?php
            } 
            ?>
    </td>

    
    <!-- 
    <td class="hidden-xs">
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-hover="dropdown" data-toggle="dropdown-toggle"><i class="fa fa-pencil"></i> Leave</a>
            <ul class="dropdown-menu pull-right">
                <li class="small"><a data-toggle="modal" href="#sl_form"><i class="fa fa-medkit"></i> Sick Leave</a>
                </li>
                <li class="small"><a data-toggle="modal" href="#vl_form"><i class="fa fa-plane"></i> Annual Leave</a>
                </li>
                <li class="divider"></li>
                <li class="small"><a data-toggle="modal" href="#el_form"><i class="fa fa-ambulance"></i> Emergency</a>
                </li>
                <li class="small"><a data-toggle="modal" href="#bl_form"><i class="fa fa-plus-square"></i> Bereavement</a>
                </li>
                <li class="divider"></li>
                <li class="small"><a data-toggle="modal" href="#m_form"><i class="fa fa-stethoscope"></i> Maternity</a>
                </li>
                <li class="small"><a data-toggle="modal" href="#p_form"><i class="fa fa-hospital"></i> Paternity</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-hover="dropdown" data-toggle="dropdown-toggle"><i class="fa fa-pencil"></i> Others</a>
            <ul class="dropdown-menu pull-right">
                <li class="small"><a data-toggle="modal" href="#cws_form"><i class="fa fa-clock-o"></i> Change Work</a>
                </li>
                <li class="small"><a data-toggle="modal" href="#bt_form"><i class="fa fa-plane"></i> Business Trip</a>
                </li>
                <li class="divider"></li>
                <li class="small"><a data-toggle="modal" href="#bt_form"><i class="fa fa-money"></i> Overtime</a>
                </li>
                <li class="small"><a data-toggle="modal" href="#ut_form"><i class="fa fa-files-o"></i> Undertime</a>
                </li>
                <li class="small"><a href="#"><i class="fa fa-clock-o"></i> Dispute</a>
                </li>
            </ul>
        </div>
         -->
    </td>
</tr>