<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        {{ $payroll_whtax_table_payroll_schedule_id }}
    </td>
    <td>
        {{ $payroll_whtax_table_taxcode_id }}
    </td>
    <td>
        {{ number_format($payroll_whtax_table_salary_from, 2) }}
    </td>
    <td>
        {{ number_format($payroll_whtax_table_salary_to, 2) }}
    </td>
    <td>
        {{ number_format($payroll_whtax_table_fixed_amount, 2) }}
    </td>
    <td>
        {{ $payroll_whtax_table_excess_percentage }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('whtax_table.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('whtax_table.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>