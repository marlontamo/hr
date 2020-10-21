<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $payroll_entry_batch_payroll_date }}</a>
    </td>
    <td>
        {{ $payroll_entry_batch_transaction_label }}<br>
        <span class="text-muted small">{{ $payroll_entry_batch_document_no }}</span>
    </td>
    <td>
        {{ $payroll_entry_batch_remarks }}
    </td>
    <td class="text-right text-muted">
        {{ number_format(trim($payroll_entry_batch_total), 2, '.', ',') }}
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
