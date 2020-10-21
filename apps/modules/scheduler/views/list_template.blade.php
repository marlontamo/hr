<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
        <a id="scheduler_title" href="<?php echo $edit_url; ?>" class="text-success"><?php echo $scheduler_title; ?></a>
    </td>
    <td>
        <span id="scheduler_sp_function;"><?php echo $scheduler_sp_function; ?></span>
    </td>
    <td>
        <span id="scheduler_sp_function;"><?php echo $scheduler_arguments; ?></span>
    </td>    
    <td>
        <span id="scheduler_description;"><?php echo $scheduler_description; ?></span>
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