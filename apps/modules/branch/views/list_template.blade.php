<tr class="record">
    <?php if( $can_delete != 0 ){ ?>
        <td>
            <div>
                <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
            </div>
        </td>
    <?php }else{ ?>
        <td>
            <div>
            </div>
        </td>
    <?php } ?>
    <td>
        <a id="users_section_section" href="<?php echo $detail_url; ?>"><?php echo $users_branch_branch; ?></a>
        <br>
        <span id="users_branch_branch_code" class="small"><?php echo $users_branch_branch_code; ?></span>
    </td>
    <td class="hidden-xs">
        <span id="users_branch_status_id" <?php echo $users_branch_status_id == 'Yes' ? 'class="badge badge-success"' : 'class="badge badge-error"' ; ?> ><?php echo $users_branch_status_id; ?></span>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('branch.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('branch.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>