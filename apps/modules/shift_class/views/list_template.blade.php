<tr class="record">
    <td>
        <a href="{{ $edit_url }}">
            {{ $company}}
        </a>
    </td>
    <td onclick="edit_value({{$record_id}})" style="cursor: pointer !important;">
        <div id="span_class_value-{{$record_id}}" class="span_class_value"> {{ $class_value}} </div>
        <input type="text" id="text_class_value-{{$record_id}}" class="hidden text_class_value"
        name="time_shift_class_company[class_value]" value="{{ $class_value }}" data-id="{{$record_id}}">
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <!-- <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div> -->
    </td>
</tr>