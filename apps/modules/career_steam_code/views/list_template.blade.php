<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
<td class="hidden-xs">
        <a href="<?php echo $edit_url; ?>">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAABwUlEQVRoQ+2YvavCQBDEJ4KCinZ+VIIEOy3FkH/fSguxE9uIVUArCyH63ruDDTEYkzhCeLipjJcdb+a3e6LO6XT6wT++HDVQMT0lUDEAKAElQCagLUQGSJcrATpCUkAJkAHS5UqAjpAUUAJkgHT59xA4HA7Y7/cYDAaYzWY2OXlPYpxOpxgOh4VT/YRmIQL3+x2r1QqXyyU2EEURlsslWq0WFosFNpsNzuczfN9Hs9nMNfEpzUIGdrsdwjCE2XSv17ME/n5LY7vdxvfmmePxCEOh0WjYtXa7bc0l14RQWc0ssrkGZKOj0QhBEMQbziMgRDzPw3q9jkkZNO9qPsP60oBgrtVqmEwmD4kbMTFxu93gOM5D+2StMZqlDTxriyItJLgNBZN2cvBZzbSJTALJIUsXdToddLtd2/Pj8Riu68YnktxLm9TrdVyvVzsb/X4/Pgze0SxNIFmQHtpXQywbNa01n8/tCWVem4E2huQqo/n2EGd92LPvAUlf2iRNJ9lKyWGWtnylmXUu555CuQd6xQ+ogYoB6D9zVQNQAkqATUCPUTZBtl4JsAmy9UqATZCtVwJsgmy9EmATZOuVAJsgW/8L+6U4/9EQxOwAAAAASUVORK5CYII="
            data-src="holder.js/48x48" alt="48x48" style="width: 48px; height: 48px;">
        </a>
    </td>
    <td>
        <a id="users_job_rank_code_job_rank_code" href="<?php echo $edit_url; ?>" class="text-success"><?php echo $users_job_rank_code_job_rank_code; ?></a>
        <br>
        <span id="users_job_rank_code_job_rank_code_code" class="small"><?php echo $users_job_rank_code_job_rank_code_code; ?></span>
    </td>
    <td class="hidden-xs">
        <span id="users_job_rank_code_status_id;"><?php echo $users_job_rank_code_status_id; ?></span>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>