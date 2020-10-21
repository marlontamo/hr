<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="{{ $record_id }}">
        </div>
    </td>
    <td>
        <a class="text-success" href="{{ base_url( $report_results_filepath ) }}">{{ $report_results_report_id }}</a>
        <br>
        <span class="small">{{ $report_generator_report_code }} / {{ $report_results_file_type }}</span
    </td>
    <!-- td>
        {{ $report_results_file_type }}
    </td -->
    <!-- td>
        {{ $users_full_name }}
    </td -->
    <td>
		{{ $users_full_name }}
		<br>
        <span class="small">{{ $report_results_created_on }}</span
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ base_url( $report_results_filepath ) }}"><i class="fa fa-download"></i> Download</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>