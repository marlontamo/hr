<tr class="record">
    <td class="hidden-xs">
	<input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes">
    </td>

    <td>
        {{ $memo_memo_title }}
    </td>

    <td class="hidden-xs">
        {{ $memo_memo_type_id }}
    </td>

    <td>
        {{ $memo_publish_from }} to {{ $memo_publish_to }}
    </td>
    
    <td>
        @if( isset( $permission['edit'] ) && $permission['edit'] )
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
        </div>
        @endif
        @if( !empty( $options ) )
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
        @endif
    </td>
</tr>