<?php 
$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
$image_dir_full  = FCPATH.'uploads/users/';

$avatar = basename(base_url( $photo ));

$file_name_thumbnail = $image_dir_thumb . $avatar;
$file_name_full = $image_dir_full . $avatar;

if(file_exists(urldecode($file_name_thumbnail))){
    $file_name_full = base_url() . "uploads/users/" . $avatar;
    $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
}
else if(file_exists(urldecode($file_name_full))){
    $avatar = base_url() . "uploads/users/" . $avatar;
    $file_name_full = $avatar;
}
else{
    $avatar = base_url() . "uploads/users/avatar.png";
    $file_name_full = $avatar;
} ?>
<tr class="record">
    <td width="7%"><img class="avatar img-responsive" width="45px" src="{{ $file_name_full }}"> </td>
    <td>
        <span class="text-success">{{ $full_name }}</span><br>
        <span class="text-muted small">{{ $position }}</span></td>
    <td width="1%" class="text-right">
        @if( $admin )
            <span class="text-success text-sm">Admin</span>
        @elseif( $active )
            <span class="text-info text-sm">Member</span> 
        @else
            @if( $is_admin )
                <a class="btn btn-sm btn-primary" onclick="accept_request( {{ $group_id }}, {{$user_id}})"><i class='fa fa-thumbs-o-up'></i> Accept</a>
            @else
                <span class="label label-default">Request Pending</span> 
            @endif
        @endif
    </td>
</tr>
