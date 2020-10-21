<tr class="record">
    <td class="hidden-xs">
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
<a class="text-success" href="{{ $edit_url }}">
{{ $partners_safe_manhour_partner_id}}
</a>
<br>
<span class="small">{{ $position}}</span>
</td>
    <td class="hidden-xs">{{$partners_safe_manhour_total_manhour}}</td>
    <td class="hidden-xs">{{$partners_safe_manhour_nature_id}}
        </td>
    </td>    
<td>
<span class="badge badge-success">{{ $partners_safe_manhour_status_id }}</span>
</td> <td>
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