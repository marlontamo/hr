<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        {{ number_format($payroll_phic_table_from,2) }}
    </td>
    <td>
        {{ number_format($payroll_phic_table_to,2) }}
    </td>
    <td>
        {{ number_format($payroll_phic_table_eeshare,2) }}
    </td>
    <td>
        {{ number_format($payroll_phic_table_ershare,2) }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('phic_table.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('phic_table.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>