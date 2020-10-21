<tr class="record">
    @if( $can_delete != '0')
        <td>
            <div>
                <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
            </div>
        </td>
    @else
        <td>
        </td>
    @endif
    <td>
        <a href="{{ $detail_url }}">{{ $payroll_loan_loan_code }}</a>
    </td>
    <td>
        <span class="text-success">{{ $payroll_loan_loan }}</span>
    </td>
    <td>
        {{ $payroll_loan_loan_type_id }}
        <br />
        <span class="text-info small">{{ $payroll_loan_loan_mode_id }}</span>
    </td>
    <!-- <td>
        {{ $payroll_loan_loan_mode_id }}
    </td> -->
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('loans.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('loans.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>