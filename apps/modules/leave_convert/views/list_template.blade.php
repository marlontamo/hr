<tr class="record" rel="1">
    <td>
        <a class="text-success" href="{{ $detail_url }}" id="display_name">{{ $display_name }}</a>
    </td>
    <td>
        <span class="text-info">{{ $form }}</span><br>
        <span class="text-muted small"><?php
            //if( $localize_time ){
            //    echo $this->localize_timeline( $created_on, $user['timezone'] );
            //}
            //else{
               echo $createdon;
            //} ?>
        </span>
    </td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($date_from)); ?> <span class="text-muted small"><?php echo date("D",strtotime($date_from)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_from)); ?></span>
    </td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($date_to)); ?> <span class="text-muted small"><?php echo date("D",strtotime($date_to)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_to)); ?></span>
    </td>
    <td>
        {{ $hrs }}
    </td>
    <td>
        <?php 
            switch($status_id){ 
                case 1: ?><span class="badge badge-danger">{{ $status }}</span><?php break;
                case 3: ?><span class="badge badge-warning">{{ $status }}</span><?php break;
                case 4: ?><span class="badge badge-info">{{ $status }}</span><?php break;
                case 5: ?><span class="badge badge-info">{{ $status }}</span><?php break;
                case 6: ?><span class="badge badge-success">{{ $status }}</span><?php break;
                case 7: ?><span class="badge badge-important">{{ $status }}</span><?php break;
                case 8: ?><span class="badge badge-default">{{ $status }}</span><?php break;
                case 2:
                default: ?><span class="badge badge-warning">Pending</span><?php break;
            }  
         ?>
    </td>
    <td>
        <div class="btn-group">
            <a href="{{ $detail_url }}" class="btn btn-xs text-muted"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
        </div>

        @if($form_status_id == 6 && $form_id == 5 )
            <div class="btn-group">
                <a href="{{ $edit_url }}" class="btn btn-xs text-muted"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
        @endif
        
        @if($form_status_id != 8 )
            @if( $form_status_id == 2 )
                <span onclick="get_form_details({{ $form_id }}, {{ $forms_id }})";data-forms-id="{{ $forms_id }}" data-form-id="{{ $form_id }}" id="manage_dialog-{{ $forms_id }}" 
                class="btn btn-sm custom_popover text-muted"  data-close-others="true" data-content="" data-placement="left" data-original-title="{{ $form }}">
                <i class="fa fa-gear"></i> {{ lang('common.options') }}
                </span>
            @endif
        @endif

    </td>
</tr>
