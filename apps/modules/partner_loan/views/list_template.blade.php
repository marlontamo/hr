<tr class="record">
    <td><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>

    <td>
        <span class="text-success"> {{ $full_name }}</span><br>
        <span class="text-muted small">{{ $id_number }}</span><br>
        <span class="text-info small">{{ $payroll_partners_loan_loan_id }}</span>
    </td>
    <!-- td>
        <span>{{ $payroll_partners_loan_loan_id }}</span>
    </td -->
    <td class="hidden-xs">
        <span>{{ number_format(trim($payroll_partners_loan_amount), 2, '.', ',') }}</span>
    </td>
    <td class="hidden-xs">
        @if(!empty($payroll_partners_loan_running_balance))
            <span>{{ number_format(trim($payroll_partners_loan_running_balance), 2, '.', ',') }}</span>
        @else
            <span>{{ number_format(0, 2, '.', ',') }}</span>
        @endif
    </td>
    <td class="hidden-xs">
        <?php
            switch( $payroll_partners_loan_loan_status_id )
            {
                case "Entered":
                    $class="label-primary";
                    break;
                case "Active":
                    $class="label-info";
                    break;
                case "On-Hold":
                    $class="label-warning";
                    break;
                case "Fully Paid":
                    $class="label-success";
                    break;
            }
        ?>
        <span class="label {{ $class }}">{{ $payroll_partners_loan_loan_status_id }}</span><br>
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
