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
        <span class="text-success">{{ $payroll_leave_conversion_company_id}}</span>
    </td>    
    <td>
        <a href="{{ $detail_url }}">{{ $payroll_leave_conversion_employment_type_id}}</a>
    </td>
    <td>
        <span class="text-success">{{ $payroll_leave_conversion_form_id}}</span>
    </td>
    <td>
        <span class="text-success">{{ $payroll_leave_conversion_convertible}}</span>
    </td>
    <td>
        <span class="text-success">{{ $payroll_leave_conversion_carry_over}}</span>
    </td>
    <td>
        <span class="text-success">{{ $payroll_leave_conversion_forfeited}}</span>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('leave_conversion.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('leave_conversion.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr> 