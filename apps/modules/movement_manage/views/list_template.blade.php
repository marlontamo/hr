<tr class="record">
    <?php
        if ($partners_movement_created_by != $user_id){
            $status_id = $approver_movement_status_id;
            $status = $approver_movement_status;
        }
        else{
            $status_id = $partners_movement_status_id; 
            $status = $partners_movement_status;
        }

        switch ($status_id) {
            case 1:
                $class = 'badge badge-info';
                break;               
            case 2:
            case 6:
            case 7:
            case 9:
            case 10:
                $class = 'badge badge-warning';
                break;
            case 3:
            case 11:
                $class = 'badge badge-success';
                break;
            case 4:
                $class = 'badge badge-danger';   
                break;                                                                                   
            default:
                $class = '';
                break;
        }
    ?>
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td><a href="{{ $detail_url }}">
        {{ $partners_movement_action_type_id }}</a>
        <br /><span class="text-muted small">Date Created : <?php echo date("M d, Y",strtotime($partners_movement_created_on)); ?></span>
    </td>
    <td>{{ $partners_movement_due_to_id }}</td>
    <td>{{ $partners_movement_action_user_id }}</td>
    <td><span class="<?php echo $class ?>">{{ $status }}</span></td>
    <td>
        @if($partners_movement_status_id == 1 && $partners_movement_created_by == $user_id)
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        @endif        
        <div class="btn-group">
            <span class="btn-sm"><a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-info"></i> View</a></span>
        </div>
        @if (!in_array($partners_movement_status_id,array(1,4,5)) && $approver_movement_status_id != 1 && $partners_movement_created_by != $user_id)
            <div class="btn-group">
                <span onclick="get_movement_details({{ $record_id }})" id="manage_dialog-{{$record_id}}" class="btn btn-sm custom_popover text-muted" data-close-others="true" data-content="" data-placement="left" data-original-title="">
                <i class="fa fa-gear"></i> Options
                </span>
            </div>
        @endif
    </td>
</tr>