<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>	
    <td>
        <a id="company" href="<?php echo $detail_url; ?>">{{ $ww_payroll_overtime_rates_amount_company_id }}</a>
    </td>
    <td>
        {{ $ww_payroll_overtime_rates_amount_employment_type_id }}
    </td>
    <td>
        {{ $ww_payroll_overtime_rates_amount_overtime_location_id }}
    </td>    
    <td>
        {{ $ww_payroll_overtime_rates_amount_overtime_code }}
    </td>    
    <td>
        {{ $ww_payroll_overtime_rates_amount_overtime_amount }}
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('overtime_rates.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('overtime_rates.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>