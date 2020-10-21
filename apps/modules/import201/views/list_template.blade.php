<tr class="record">
    <td class="hidden-xs"><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>
    <td>
        <?php $avatar = base_url('assets/img/avatar.png');?>
        @if( !empty($users_profile_photo) )
            <?php
                $filename = basename($users_profile_photo);
                $path = str_replace($filename, '', $users_profile_photo);
                $ftpath = FCPATH . $path .'thumbnail/' . $filename;
                $fpath = FCPATH . $path . $filename;
                if( file_exists( $ftpath ) ){
                    $avatar = base_url( $path .'thumbnail/' . $filename ) ;
                }
                else if( file_exists( $fpath ) ){
                    $avatar = base_url( $path . $filename );
                }
            ?>
        @endif
        <a href="#"><img src="{{ $avatar }}" width="45px"></a>
    </td>
    <td>
        <a href="{{ $edit_url }}" id="date_name">{{ $users_profile_firstname }} {{ $users_profile_lastname }}</a>
        <br>
        <span class="small" id="date_set">{{ $users_role_id }}</span>
    </td>
    <td class="hidden-xs">{{ $users_email }}</td>
    <td>
        @if( $users_active == 'Yes' )
            <span class="badge badge-success">active</span>
        @else
            <span class="badge badge-error">inactive</span>
        @endif
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