<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>{{ $time_record_summary_payroll_date }}</td>
    <td>{{ $time_record_summary_user_id }}</td>
    <td><a href="{{ $edit_url }}">{{ $time_record_summary_date }}</a></td>
    <td>{{ $time_record_summary_hrs_actual }}<br>{{ $time_record_summary_late }}<br>{{ $time_record_summary_undertime }}</td>
    <!-- td>{{ $time_record_summary_late }}</td>
    <td>{{ $time_record_summary_undertime }}</td -->
    <td>{{ $time_record_summary_ot }}</td>
    <td>{{ $time_record_summary_absent }}</td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('dtr_summary.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('dtr_summary.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>
