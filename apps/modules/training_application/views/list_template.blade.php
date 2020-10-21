<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
        <span class="text-success">{{ $training_application_course_id }}</span>
        <br>
        <span class="text-muted small">{{ $training_application_type_id }}</span>
    </td>
    <td>{{ date('F d, Y', strtotime(training_application_created_on) ) }}</td>
    <td class="hidden-xs">

        <?php 
            switch($training_application_status_code){ 
                case 'DRAFT':
                    ?><span class="badge badge-danger">{{ $training_application_status_id }}</span><?php
                break;
                case 'FORAPP':
                case 'PEND':
                    ?><span class="badge badge-warning">{{ $training_application_status_id }}</span><?php
                break;
                case 'FITWORK':
                case 'FORVALID':
                    ?><span class="badge badge-info">{{ $training_application_status_id }}</span><?php
                break;                case 'APPROVE':
                    ?><span class="badge badge-success">{{ $training_application_status_id }}</span><?php
                break;
                case 'DISAPPROVE':
                    ?><span class="badge badge-important">{{ $training_application_status_id }}</span><?php
                break;
                case 'CANCEL':
                default:
                    ?><span class="badge badge-default">{{ $training_application_status_id }}</span><?php
                break;
         } ?>
    </td> 
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>