<?php
	$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
	$image_dir_full  = FCPATH.'uploads/users/';

	$avatar = basename(base_url( $photo ));
	$file_name_thumbnail = urldecode($image_dir_thumb . $avatar);
	$file_name_full = urldecode($image_dir_full . $avatar);

	if(file_exists($file_name_thumbnail)){
		$file_name_full = base_url() . "uploads/users/" . $avatar;
        $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
    }
    else if(file_exists($file_name_full)){
        $avatar = base_url() . "uploads/users/" . $avatar;
		$file_name_full = $avatar;
    }
    else{
        $avatar = base_url() . "uploads/users/avatar.png";
		$file_name_full = $avatar;
    }
?>
<tr rel="1" class="record">
	<td class="hidden-xs" ><a href="#" ><img class="avatar img-responsive" src="{{ $avatar }}" style="width:45px"></a></td> 
	<td>
		<a id="bday-{{$celebrant_id}}" href="#" class="text-success">{{$display_name}}</a>
		<br />
		<span id="date_set" class="small text-muted">{{$position}}</span>
	</td>
	<td class="hidden-xs">
		<span id="period_from">{{date('F d', strtotime($cur_birth_date))}} <span id="period_from_dayname" class="small text-muted">{{date('D', strtotime($cur_birth_date))}}</span></span>
		<br />
		<span id="period_month" class="small text-muted">{{$cur_year}}</span>
	</td>
	<td>
		 <span class="{{$days_status === 'today' ? 'badge badge-success' : 'text-muted'}}">{{$days_status}}</span> 
	</td>
	<td>
		<div class="btn-group">
			<a class="btn btn-xs {{ !$greetings ? 'text-muted' : 'text-info'}} greetings" 
				data-celebrant-id="{{$celebrant_id}}" 
				data-birth-date="{{$cur_birth_date}}"
				data-celebrant-name="{{$display_name}}"
				href="#"><i class="fa fa-gift"></i> {{ lang('birthdays.greetings') }}</a>
		</div>
	</td>
</tr>
