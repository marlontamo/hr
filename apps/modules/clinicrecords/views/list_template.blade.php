<tr class="record">
    <td class="hidden-xs">
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">
        {{ $partners_clinic_records_partner_id}}
        </a>
        <br>
        <span class="small">{{ $position}}</span>
    </td>    
    <td>
        <a class="text-success" href="{{ $edit_url }}">
        {{$department}}
        </a>
        <br>
        <span class="small">{{$company_code}}</span>
    </td>
    <td class="hidden-xs">
        {{ date('M-d', strtotime($clinic_created_on)) }}
        <span class="text-muted small">{{ date('D', strtotime($clinic_created_on)) }}</span>
        <br>
        <span class="text-muted small">{{ date('Y', strtotime($clinic_created_on)) }}</span>
        </td>
    </td>  <td>
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