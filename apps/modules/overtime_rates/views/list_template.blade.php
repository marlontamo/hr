<tr class="record">
    <td>
        <a id="company" href="<?php echo $detail_url; ?>">{{ $company }}</a>
    </td>
    <td>
        {{ $overtime_code }}
    </td>
    <td>
        {{ $overtime_rate }}
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