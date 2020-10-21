<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>a
    <td>
        <a href="{{ $edit_url }}" class="text-success">{{ $payroll_partners_user_id }}</a>
    </td>
    <!-- <td>
        {{ $payroll_partners_payroll_rate_type_id }}
    </td> -->
   <td>
        {{ $payroll_partners_payroll_schedule_id }}
        <br />
        <span class="text-muted small">{{ $payroll_partners_payroll_rate_type_id }}</span>
    </td>
    <td>
        {{ $payroll_partners_taxcode_id }}
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