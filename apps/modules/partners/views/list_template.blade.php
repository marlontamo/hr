<tr class="record">
    <td class="hidden-xs"><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>
    <td>
        @if( !empty($users_profile_photo) )
            <a href="#"><img class="avatar img-responsive" src="{{ $users_profile_photo }}"></a>
        @else
            <a href="#"><img class="avatar img-responsive" src="{{ base_url('assets/img/avatar.png') }}"></a>
        @endif
    </td>
    <td>
        <a href="{{ $detail_url }}" id="date_name">{{ $users_profile_firstname }} {{ $users_profile_lastname }}</a>
        <br>
        <span class="small" id="date_set">{{ $users_profile_position_id }}</span>
    </td>
    <td class="hidden-xs">{{ $users_email }}</td>
    <td>
        @if( $users_active == 'Yes' )
            <span class="badge badge-success">{{ lang('partners.active') }}</span>
        @else
            <span class="badge badge-error">{{ lang('partners.inactive') }}</span>
        @endif
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>