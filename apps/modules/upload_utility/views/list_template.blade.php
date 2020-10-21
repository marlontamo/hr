<tr class="record">
	<td>{{ basename($system_upload_log_file_path) }}</td>
	<td>{{ $system_upload_log_valid_count }} out of {{ $system_upload_log_rows }}
		@if( $system_upload_log_error_count > 0 )
		<br>
		<span class="text-danger small">with error</span>
		@endif
	</td>
	<td>{{ ($system_upload_log_filesize/1000) }} KB</td>
	<td>{{ localize_timeline( $system_upload_log_created_on, $user['timezone'] ) }}</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>