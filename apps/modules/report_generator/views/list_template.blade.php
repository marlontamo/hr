<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a href="{{ $edit_url }}">{{ $report_generator_report_code }}</a>
    </td>
    <td>
        <a href="{{ $edit_url }}">{{ $report_generator_report_name }}</a>
		<span class="help-block small">By: {{ $report_generator_created_by }}</span>
		<span class="help-block small">{{ $report_generator_description }}</span>
    </td>
    <!-- td>
        {{ $report_generator_created_by }}
    </td -->
    <!-- td>
        {{ $report_generator_description }}
    </td -->
    <td>
        <!-- <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div> -->
        @if( isset($generate_url) )
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $generate_url }}"><i class="fa fa-download"></i> Generate</a>
        </div>
        @endif
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>