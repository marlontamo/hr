<tr class="record" rel="1">
    <td>
        <span class="text-info">{{ $time_form_form }}</span><br>
        <span class="text-muted small"><?php echo date("F d, Y",strtotime($time_forms_created_on)); ?></span>
    </td>
    @if(strtotime($time_forms_time_from))
    <td class="hidden-xs"><?php echo date("M-d",strtotime($time_forms_time_from)); ?> 
        <span class="text-muted small"><?php echo date("D",strtotime($time_forms_time_from)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($time_forms_time_from)); ?></span>
    </td>
    @else
    <td class="hidden-xs"><?php echo date("M-d",strtotime($time_forms_date_from)); ?> 
        <span class="text-muted small"><?php echo date("D",strtotime($time_forms_date_from)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($time_forms_date_from)); ?></span>
    </td>
    @endif
    @if(strtotime($time_forms_time_to))
    <td class="hidden-xs"><?php echo date("M-d",strtotime($time_forms_time_to)); ?> 
        <span class="text-muted small"><?php echo date("D",strtotime($time_forms_time_to)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($time_forms_time_to)); ?></span>
    </td>
    @else
    <td class="hidden-xs"><?php echo date("M-d",strtotime($time_forms_date_to)); ?> 
        <span class="text-muted small"><?php echo date("D",strtotime($time_forms_date_to)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($time_forms_date_to)); ?></span>
    </td>
    @endif
    
    <td>
        <?php 
            switch($time_forms_form_status_id){ 
                case 1:
                    ?><span class="badge badge-info">{{ $time_form_status_form_status }}</span><?php
                break;
                case 2:
                    ?><span class="badge badge-warning">{{ $time_form_status_form_status }}</span><?php
                break;
                case 3:
                    ?><span class="badge badge-warning">{{ $time_form_status_form_status }}</span><?php
                break;
                case 4:
                    ?><span class="badge badge-info">{{ $time_form_status_form_status }}</span><?php
                break;
                case 5:
                    ?><span class="badge badge-info">{{ $time_form_status_form_status }}</span><?php
                break;
                case 6:
                    ?><span class="badge badge-success">{{ $time_form_status_form_status }}</span><?php
                break;
                case 7:
                    ?><span class="badge badge-important">{{ $time_form_status_form_status }}</span><?php
                break;
                case 8:
                    ?><span class="badge badge-default">{{ $time_form_status_form_status }}</span><?php
                break;
                default:
                    ?><span class="badge badge-default">{{ $time_form_status_form_status }}</span><?php
                break;
         } ?>
    </td>
    <td>
        <?php 
        if( $time_forms_form_status_id < 7 && (!(count($error) > 0) || $time_forms_form_status_id!=6) && $time_form_form != 'Daily Time Record Updating' ){ // can cancel forms of any status except disapproved/cancelled ?>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('form_application.edit') }}</a>
        </div>
        <?php } ?>

        <?php if( ($time_forms_form_status_id != 1 && $time_forms_form_status_id != 2) || $time_form_form == 'Daily Time Record Updating' ){ ?>
        <div class="btn-group">
            <a href="{{ $detail_url }}" class="btn btn-xs text-muted"><i class="fa fa-search"></i> {{ lang('form_application.view') }}</a>
        </div>
        <?php } ?>
        <?php //if( $time_forms_form_status_id == 6  ){ ?> 
        <!-- <div class="btn-group">
            <a href="javascript: cancel_record({{ $record_id }})" class="btn btn-xs text-muted"><i class="fa fa-ban"></i> Cancel</a>
        </div> -->
        <?php //} ?>
        <?php if( $options != "" && $time_form_form != 'Daily Time Record Updating'){ ?>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('form_application.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
        <?php } ?>
    </td>
</tr>