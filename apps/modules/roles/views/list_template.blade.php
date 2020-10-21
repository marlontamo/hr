<tr class="record">
    @if($can_delete != 0 )
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    @else
    <td>
        <div>
        </div>
    </td>
    @endif
    <td>
        <a href="{{ $detail_url }}">
            {{ $roles_role }}
        </a>
    </td>
    <td>
        {{ $roles_description }}
    </td>
    <!-- <td>
        
    </td> -->
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('roles.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('roles.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>