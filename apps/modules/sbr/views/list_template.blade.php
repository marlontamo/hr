<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        {{ $year }}
    </td>
    <td>
        {{ $month }}
    </td>
    <td align="left">
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $process_url }}"><i class="fa fa-gear"></i> Process</a>
        </div>
        <!-- <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $export_url }}" ><i class="fa fa-download"></i> Export</a>
        </div> -->
    </td>
</tr>