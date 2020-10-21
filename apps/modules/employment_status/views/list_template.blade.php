<tr class="record">
    <?php if( $can_delete != 0 ){ ?>
        <td><input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}" /></td>
    <?php }else{ ?>
        <td></td>
    <?php } ?>
        <td class="hidden-xs">
           <a id="users_position_position" href="{{ $detail_url }}"> {{ $partners_employment_status_employment_status }} </a>
        </td>
    <td class="hidden-xs">
       <!-- <span class="badge {{ ($partners_employment_status_active == 'Yes') ? 'badge-success' : '' }}"> {{ $partners_employment_status_active }} </span> -->
        <span <?php echo $partners_employment_status_active == 'Active' ? 'class="badge badge-success"' : 'class="badge badge-error"' ; ?> >{{ $partners_employment_status_active }}</span>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('employment_status.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('employment_status.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>