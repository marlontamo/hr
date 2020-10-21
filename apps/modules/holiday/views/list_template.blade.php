<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
        <a id="time_holiday_holiday" href="<?php echo $edit_url; ?>" class="text-success"><?php echo $time_holiday_holiday; ?></a>
        <br>
        <span id="time_holiday_holiday_date" class="small"><?php echo $time_holiday_holiday_date; ?></span>
    </td>
    <td class="hidden-xs">
        <span id="time_holiday_location;"><?php echo $locations; ?></span>
    </td>
    <td class="hidden-xs">
        <?php if( $time_holiday_legal == "Yes" ){ ?>
            <span class="badge badge-success">Regular</span>
        <?php }else{ ?>
            <span class="badge badge-warning">Special</span>
        <?php } ?>
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