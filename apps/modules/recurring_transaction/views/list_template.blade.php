<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $payroll_entry_recurring_document_no }}</a>
    </td>
    <td>
        {{ $payroll_entry_recurring_transaction_label }}
    </td>
    <td>
        {{ $payroll_entry_recurring_date }}
    </td>
    <td>
        {{ $payroll_entry_recurring_account_name }}
    </td>
    <td class="text-right text-muted">
        {{ number_format(trim($payroll_entry_recurring_total), 2, '.', ',') }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>