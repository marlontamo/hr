<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ $edit_url }}">{{ $payroll_period_date }}</a>
    </td>
    <td>
        {{ $payroll_period_payroll_date }}
        <span class="text-muted small">
            <?php
                switch( $payroll_period_payroll_date_day )
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
        <span class="text-muted small">{{ $payroll_period_payroll_date_year }}</span>
    </td>
    <td>
        {{ $payroll_period_apply_to_id }}<br>
        <span class="text-muted small" id="company_name">{{ $applied_to }}</span>
    </td>
    <td>
        {{ $payroll_period_period_processing_type_id }}
    </td>
    <td>
        <?php
            switch( $payroll_period_period_status_id_id ) 
            {
                case 1:
                    $status = 'label-success';
                    break;
                case 2:
                    $status = 'label-info';
                    break;
                case 3:
                    $status = 'label-danger';
                    break;
            }
        ?>
        <span class="label {{ $status }}">{{ $payroll_period_period_status_id }}</span>
    </td>
    <td>
        <?php if($payroll_period_period_status_id_id != 3) { ?>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <?php } ?>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>