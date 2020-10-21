<?php 
    if( $time_forms_form_status_id < 7 && (!(count($error) > 0) || $time_forms_form_status_id!=6) ){
        $action = 'edit';
    }
    if( $time_forms_form_status_id != 1 && $time_forms_form_status_id != 2 ){
        $action = 'detail';
    } 
?>

<li class="record in2" form_id="<?php echo $record_id?>" action="<?php echo $action?>" href="#pop-ajax-container">
    <div class="iconlist">
        <?php 
            switch($time_forms_form_status_id){ 
                case 7:
                    $class = "btn-danger";
                break;
                case 2:
                case 3:
                    $class = "btn-warning";
                break;
                case 1:
                case 4:
                case 5:
                    $class = "btn-info";
                break;
                case 6:
                     $class = "btn-success";
                break;
                default:
                    $class = "btn-default";
                break;
         } ?>
        <a class="btn {{ $class }}" href="#">
            <i class="{{ $time_form_class }}"></i>
        </a>
    </div>
    <div class="datetime">
        <span class="small">
            @if(strtotime($time_forms_time_from))
                <?php echo date("M-d",strtotime($time_forms_time_from)); ?>
            @else
                <?php echo date("M-d",strtotime($time_forms_date_from)); ?>
            @endif
            -
            @if(strtotime($time_forms_time_to))
                <?php echo date("M-d",strtotime($time_forms_time_to)); ?><br>
                <span class="pull-right"><?php echo date("Y",strtotime($time_forms_time_to)); ?></span>
            @else
                <?php echo date("M-d",strtotime($time_forms_date_to)); ?><br>
                <span class="pull-right"><?php echo date("Y",strtotime($time_forms_date_to)); ?></span>
            @endif
        </span>
    </div>
    <div class="listname">
        <span>{{ $time_form_form }}</span>
    </div>

    <div class="listmsg">
        <span class="italic small">{{ $time_forms_reason }}</span>
    </div>
</li>