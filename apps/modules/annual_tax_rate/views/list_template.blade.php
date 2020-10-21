<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        {{ number_format($payroll_annual_tax_salary_from, 2) }}
    </td>
    <td>
        {{ number_format($payroll_annual_tax_salary_to, 2) }}
    </td>
    <td>
        {{ number_format($payroll_annual_tax_amount, 2) }}
    </td>
    <td>
        {{ $payroll_annual_tax_rate }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('annual_tax_rate.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('annual_tax_rate.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>