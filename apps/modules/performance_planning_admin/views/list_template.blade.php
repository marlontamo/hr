<tr class="record">
	<td>
		{{ $performance_planning_year }}
	</td>
	<td class="text-info">
		{{ $fullname }}
	</td>
	<td class="hidden-xs">
		<a class="text-success" href="{{ $edit_url }}/{{ $user_id }}">{{ $performance_type }}</a>
		<br>
		<span class="small" id="date_set">{{ date('M d, Y', strtotime( $performance_planning_date_from ) ) }} to {{ date('M d, Y', strtotime( $performance_planning_date_to ) ) }}</span>
	</td>
	<td class="hidden-xs">
		<?php	
			switch($performance_planning_performance_status_id){
				case 1: //Draft
					$color_class = 'orange';
				break;
				case 6: //For Employees Review
					$color_class = 'yellow';
				break;
				case 11: //For Immediate Superior Review
					$color_class = 'yellow';
				break;
				case 2: //For Approval
					$color_class = 'yellow';
				break;
				case 4: //Approved
					$color_class = 'green';
				break;				
				default:
					$color_class = 'default';
				break;
			}
		?>
		<span class="btn btn-xs text-muted <?php echo $color_class; ?>">
			{{$performance_planning_performance_status}}
		</span>
<!-- 		@if($performance_planning_performance_status_id == 4)
		<br>
		<span class="small text-danger >">
			ATTENTION: {{$attention_fullname}}
		</span>
		@endif -->
	</td>
	<td>
        <div class="btn-group">
        	<?php
				$href = get_mod_route('appraisal_individual_planning') . '/review_admin/'.$record_id.'/'.$user_id;
			?>
            <a class="small text-muted" href="{{ $href }}"><i class="fa fa-search"></i> View</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>