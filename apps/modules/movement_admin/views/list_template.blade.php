<tr class="record">
    <?php
        switch ($partners_movement_status_id) {
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
    <td><span class="<?php echo $class ?>">{{ $partners_movement_status }}</span></td>
    <td>
        @if ($hr_admin_movement == 1 && in_array($partners_movement_status_id,array(1,6)) || in_array($hr_approver_movement_status_id,array(9,10)))
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>
        @endif
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>