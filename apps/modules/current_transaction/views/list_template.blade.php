<tr class="record">
    <!-- td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td -->
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $payroll_current_transaction_employee_id }}</a>
        <br>
        <span class="text-muted small">{{ $payroll_current_transaction_id_number }} / </span>
        <span class="text-muted small">{{ $payroll_current_transaction_processing_type_id }}</span> 
    </td>
    <!-- td>
        {{ $payroll_current_transaction_processing_type_id }}
    </td -->
    <!-- td>
        {{ $payroll_current_transaction_payroll_date }}
        <span class="text-muted small">
            < ?php
                switch( $payroll_current_transaction_payroll_date_day )
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
        <span class="text-muted small">{{ $payroll_current_transaction_payroll_date_year }}</span>
    </td -->
    <td>
        <?php
            switch( $payroll_current_transaction_on_hold )
            {
                case "Yes":
                    $status = 'text-danger';
                    break;
                case "No":
                    $status = 'text-default';
                    break;
            }
        ?>
        <span class="text {{ $status }}">{{ $payroll_current_transaction_transaction_label }}</span><br>
        <span class="text-muted small">{{ $payroll_current_transaction_payroll_date }} {{ $payroll_current_transaction_payroll_date_year }}</span>
  </td>
    <td class="text-right text-muted">

        {{ number_format(trim($payroll_current_transaction_quantity), 2, '.', ',') }}
    </td>
    <td class="text-right text-muted">
        {{ number_format(trim($payroll_current_transaction_unit_rate), 2, '.', ',') }}
    </td>
    <td class="text-right">
        {{ number_format(trim($payroll_current_transaction_amount), 2, '.', ',') }}
    </td>
    <td class="text-right">
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
