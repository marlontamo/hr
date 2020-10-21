<tr class="record">

    <td>
        <?php 
            $disabled = $payroll_leave_conversion_period_status_id == 3 ? 'disabled' : '';
        ?>
        <div>
            <input type="checkbox" class="record-checker checkboxes" {{$disabled}} value="{{ $record_id }}">
        </div>
        <td>
            <a class="text-success" href="{{ $edit_url }}">{{ $payroll_leave_conversion_period_payroll_date }}</a>
        </td>
        <td>
            <span>{{ $payroll_leave_conversion_period_year }}</span>
        </td>
        <td>
            <span>{{ $payroll_leave_conversion_period_apply }}</span>
        </td>
        <td>
            <span>{{ $payroll_leave_conversion_period_form }}</span>
        </td>
        <td>
            <span>{{ $payroll_leave_conversion_period_nontax_leave }}</span>
        </td>
        <td>
            <span>{{ $payroll_leave_conversion_period_taxable_leave }}</span>
        </td>
        
        <td>
        <?php
            switch( $payroll_leave_conversion_period_status_id )
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
        <span class="label {{ $status }}">{{ $payroll_leave_conversion_period_status }}</span>
    </td>
    </td>
    <td>
        @if(!empty($options))
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
                <ul class="dropdown-menu pull-right">
                    {{ $options }}
                </ul>
            </div>
        @endif
    </td>
</tr>