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
    <td class="text-muted hidden-xs">{{ $date_range }}
    </td>
    <td>
        <?php 
        if($form_status_id != 8){ //not cancelled
            switch($form_status_id){ 
                case 1: ?><span class="badge badge-info">{{ $form_status }}</span><?php break;
                case 2: ?><span class="badge badge-warning">{{ $form_status }}</span><?php break;
                case 3: ?><span class="badge badge-warning">{{ $form_status }}</span><?php break;
                case 4: ?><span class="badge badge-info">{{ $form_status }}</span><?php break;
                case 5: ?><span class="badge badge-info">{{ $form_status }}</span><?php break;
                case 6: ?><span class="badge badge-success">{{ $form_status }}</span><?php break;
                case 7: ?><span class="badge badge-important">{{ $form_status }}</span><?php break;
                case 8: 
                default: ?><span class="badge badge-default">{{ $form_status }}</span><?php break;
         }
        }else{ //cancelled
            ?><span class="badge badge-default">{{ $form_status }}</span><?php
        } ?>
    </td>
    <td>
        <div class="btn-group">
            <a href="{{ $detail_url }}" class="btn btn-xs text-muted"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
        </div>

        @if($form_status_id == 6 && $form_id == 5  && $form_code != 'DTRU')
            <div class="btn-group">
                <a href="{{ $edit_url }}" class="btn btn-xs text-muted"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
        @endif
        
        @if($form_status_id != 8 && $form_code != 'DTRU')
            @if( $form_status_id == 2 )
                <span onclick="get_form_details({{ $form_id }}, {{ $forms_id }})";data-forms-id="{{ $forms_id }}" data-form-id="{{ $form_id }}" id="manage_dialog-{{ $forms_id }}" 
                class="btn btn-sm custom_popover text-muted"  data-close-others="true" data-content="" data-placement="left" data-original-title="{{ $form }}">
                <i class="fa fa-gear"></i> {{ lang('common.options') }}
                </span>
            @endif
        @endif

    </td>
</tr>
