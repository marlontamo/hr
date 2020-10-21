<tr rel="{{ $f_id }}">
    <td><input type="checkbox" class="field-checker checkboxes" value="{{ $f_id }}" /></td>
    <td>
        <a id="date_name" href="#" class="text-success">{{ $label }}</a>
    </td>
    <td>{{ $uitype }}</td>
    <td>{{ $fieldgroup }}</td>
    <td align="center">{{ $sequence }}</td>
    <td>
        @if( $active )
            <span class="badge badge-info">enabled</span>
        @else
            <span class="badge badge-error">disabled</span>
        @endif
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="javascript:edit_field( {{ $f_id }} )" id="goto_fg_edit"><i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                <li><a href="javascript:_delete_field( {{ $f_id }} )"><i class="fa fa-trash-o"></i> Delete</a></li>
                <li><a href="javascript:disable_field( {{ $f_id }} )"><i class="fa fa-ban"></i> Disable</a></li>
            </ul>
        </div>
    </td>
</tr>