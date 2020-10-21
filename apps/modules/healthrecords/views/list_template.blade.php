<tr class="record">
    <td class="hidden-xs">
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">
        {{ $partners_health_records_partner_id}}
        </a>
        <br>
        <span class="small">{{ $position}}</span>
    </td>
    <td>{{$partners_health_records_health_type_id}}</td>
    <td class="hidden-xs">
        {{ date('M-d', strtotime($partners_health_records_created_on)) }}
        <span class="text-muted small">{{ date('D', strtotime($partners_health_records_created_on)) }}</span>
        <br>
        <span class="text-muted small">{{ date('Y', strtotime($partners_health_records_created_on)) }}</span>
        </td>
    </td>    
    <td class="hidden-xs">
        <span class="badge badge-success">{{ $partners_health_records_health_type_status_id }}</span>
    </td> 
    <td>
        @if($edit_url != '#')
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
        @elseif($detail_url != '#')
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
            </div>
        @endif
        @if(!empty($options))
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                <ul class="dropdown-menu pull-right">
                    {{ $options }}
                </ul>
            </div>
        @endif
    </td>
</tr>