<tr class="record">
	<td>
		{{ $performance_appraisal_year }}
	</td>
	<td>
		<a class="text-success" href="{{ $edit_url }}/{{ $user_id }}/{{$user['user_id']}}">
			<?php 
                $image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
                $image_dir_full  = FCPATH.'uploads/users/';

                $avatar = basename(base_url( $photo ));

                $file_name_thumbnail = $image_dir_thumb . $avatar;
                $file_name_full = $image_dir_full . $avatar;

                if(file_exists(urldecode($file_name_thumbnail))){
                    $avatar = base_url() . "uploads/users/thumbnail/" . $avatar;
                }
                else if(file_exists(urldecode($file_name_full))){
                    $avatar = base_url() . "uploads/users/" . $avatar;
                }
                else{
                    $avatar = base_url() . "uploads/users/avatar.png";
                }			
			?>
			<span class="pull-left margin-right-10"><img src="{{ $avatar }}" alt="photo" width="48px" /></span>
			<span class="pull-left">
				{{ $fullname }}
				<br>
				<span class="small text-muted" id="date_set">
					{{ $performance_type }} / {{ date('M d, Y', strtotime( $performance_appraisal_date_from ) ) }} to {{ date('M d, Y', strtotime( $performance_appraisal_date_to ) ) }}
				</span>				
			</span>
		</a>
	</td>
	<!-- td class="hidden-xs">
		<a class="text-success" href="{{ $edit_url }}/{{ $user_id }}/{{$user['user_id']}}">{{ $performance_type }}</a>
		<br>
		<span class="small" id="date_set">{{ date('M d, Y', strtotime( $performance_appraisal_date_from ) ) }} to {{ date('M d, Y', strtotime( $performance_appraisal_date_to ) ) }}</span>
	</td -->
	<td>
		<a href="{{ $edit_url }}/{{ $user_id }}/{{$user['user_id']}}">
			<span class="{{ $contributor_status_class }}">
				@if( $performance_appraisal_performance_status_id == 4 )
					Appraisee Review
				@else
					{{$performance_appraisal_performance_status}}
				@endif
			</span>
		</a>
	</td>
	<td>
        <div class="btn-group">
            <a class="small text-muted" href="{{ $edit_url }}/{{ $user_id }}/{{$user['user_id']}}"><i class="fa fa-search"></i> View</a>
        </div>
    </td>
</tr>
