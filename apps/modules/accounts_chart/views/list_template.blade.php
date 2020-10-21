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
        <a href="{{ $detail_url }}" >{{ $payroll_account_account_code }}</a>
    </td>
    <td>
        {{ $payroll_account_account_name }}
    </td>
    <td>
        {{ $payroll_account_account_type_id }}
    </td>
    <td>
        {{ $payroll_account_description }}
    </td>
    <td>
        {{ $payroll_account_arrangement }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('account_charts.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('account_charts.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>