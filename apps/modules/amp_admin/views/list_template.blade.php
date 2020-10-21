<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>{{$recruitment_manpower_plan_year}}</td>
    <td class="hidden-xs">
        <span class="text-success">{{ $recruitment_manpower_plan_company_id }}</span>
        <br/>
        <span id="date_set" class="small text-muted">{{ $recruitment_manpower_plan_department_id }}</span>
    </td>
    <td>
        <span>{{ $recruitment_manpower_plan_created_by }}</span>
		<br>
		<span class="text-muted small">{{ date('M d, Y', strtotime($recruitment_manpower_plan_created_on))}}</span>
    </td>
    <td class="hidden-xs">
        {{ $recruitment_manpower_plan_status_id }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i>{{ lang('common.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>
