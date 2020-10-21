<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        {{ $payroll_closed_transaction_payroll_date }}
        <span class="text-muted small">
            <?php
                switch( $payroll_closed_transaction_payroll_date_day )
                {
                    case 0:
                        echo 'Sun';
                        break;
                    case 0:
                        echo 'Mon';
                        break;
                    case 0:
                        echo 'Tue';
                        break;
                    case 0:
                        echo 'Wed';
                        break;
                    case 0:
                        echo 'Thu';
                        break;
                    case 5:
                         echo 'Fri';
                        break;
                    case 0:
                        echo 'Sat';
                        break;
                }
            ?>
        </span>
        <br>
        <span class="text-muted small">{{ $payroll_closed_transaction_payroll_date_year }}</span>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $payroll_closed_transaction_employee_id }}</a>
        <br>
        <span class="text-muted small">{{ $payroll_closed_transaction_id_number }}</span>
    </td>
    <td>
        {{ $payroll_closed_transaction_transaction_label }}
    </td>
    <td>
        {{ number_format( trim($payroll_closed_transaction_quantity), 2, '.', ',') }}
    </td>
    <td>
        {{ number_format( trim($payroll_closed_transaction_unit_rate), 2, '.', ',') }}
    </td>
    <td>
        {{ number_format( trim($payroll_closed_transaction_amount), 2, '.', ',') }}
    </td>
    <td>
        <!-- div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div -->&nbsp;
    </td>
</tr>
