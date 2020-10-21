<tr class="record">
    <td>
        @if( !empty($users_profile_photo) )
            <a href="#"><img class="avatar img-responsive" src="{{ base_url($users_profile_photo)}}" style="width:45px"></a>
        @else
            <a href="#"><img class="avatar img-responsive" src="{{ base_url('assets/img/avatar.png') }}"></a>
        @endif
    </td>
    <td>
        <a href="{{ $detail_url }}" id="date_name">{{ $users_profile_firstname }} {{ $users_profile_lastname }} {{ $users_profile_suffix or '' }}</a>
        <br>
        <span class="small" id="date_set">{{ $users_profile_position_id }}</span>
    </td>
    <td class="hidden-xs">{{ $users_email }}</td>
    <td class="hidden-xs">
        @if( $users_active == 'Yes' )
            <span class="badge badge-success">{{ lang('partners.active') }}</span>
        @else
            <span class="badge badge-error">{{ lang('partners.inactive') }}</span>
        @endif
        <br>
        <span class="text-muted small"> {{$employment_status}} {{ $blacklisted ? "/" : ""}} {{$blacklisted}}</span>
    </td>
    <td>
        @if( $permission['edit'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
            @if( $permission['detail'] == 1 AND $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                    <ul class="dropdown-menu pull-right">
                        {{ $options }}
                    </ul>
                </div> 
            @elseif( $permission['detail'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
                </div>
            @elseif( $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                </div>
            @endif
        @elseif( $permission['detail'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
            </div>
            @if( $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                </div>
            @endif
        @elseif( $permission['delete'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
            </div>
        @endif
    </td>
</tr>