<tr class="record">
	<td>
		<a id="date_name" href="#" class="text-success">{{ $display_name }}</a>
		<br />
		<span id="date_set" class="small">{{ $position }}</span>
	</td>
<!-- 	<td class="hidden-xs">

		<?php 
		if ($effectivity_date && $effectivity_date != '0000-00-00' && $effectivity_date != 'January 01, 1970' && $effectivity_date != '1970-01-01'){

		}
		else{
			$effectivity_date =  date("Y-m-d");			
		}

		$pass_tat = 0;
		if ($date_cleared && $date_cleared != '0000-00-00' && $date_cleared != 'January 01, 1970' && $date_cleared != '1970-01-01'){
	    	$d_cleared = date("Y-m-d", strtotime($date_cleared));
	    	$pass_tat = no_days_between_dates( $effectivity_date, $d_cleared);
		}

		$date = date('Y-m-d');
		if( $date > $effectivity_date) {
			$tat = no_days_between_dates( $effectivity_date, $date );
			$ed_thirty_days = strtotime("+30 days", strtotime($effectivity_date));
    		$effectivity_thirty_days = date("Y-m-d", $ed_thirty_days);

			if($pass_tat > 0 && $pass_tat < 30) {
		?>
			<span class="badge badge-success">{{ ($tat > 0) ? $tat : 0}} day/s</span>		
		<?php } else {
				if($pass_tat > 30) { 
		?>
				<span class="badge badge-danger">{{ ($tat > 0) ? $tat : 0}} day/s</span>
			<?php } else if ($tat > 30) { ?>
				<span class="badge badge-danger">{{ ($tat > 0) ? $tat : 0}} day/s</span>
		<?php 
				}else { ?>
				<span class="badge badge-warning">{{ ($tat > 0) ? $tat : 0}} day/s</span>
		<?php 
				}
			}
		}
		?>
		<br>
		<?php if($date_cleared != '' && $date_cleared != '0000-00-00') { ?>
			<span class="small">Cleared Date: {{ date('F d, Y', strtotime($date_cleared))}}</span>
		<?php } ?>
		<!-- <span class="text-danger small">Turnaround Time Exceeded</span> -->
	</td> -->
	<td class="hidden-xs">{{date('F d, Y', strtotime($effectivity_date))}}</td>
	<td>
		@if( $clearance_status == 'Cleared' )
			<span class="badge badge-success">{{$clearance_status}}</span>
		@elseif($clearance_status == 'Cancelled')
			<span class="badge badge-default">{{$clearance_status}}</span>
		@else
			<span class="badge badge-warning">{{$clearance_status}}</span>
		@endif
	</td>
	
	<td>
	
		@if( $permission['edit'] == 1 )
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{$edit_url}}"><i class="fa fa-pencil"></i> Edit</a>
		</div>
		@endif

		@if($permission['decline'] && in_array($clearance_status, array('Open', 'Ongoing', 'Pending')))
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="#" data-close-others="true"  data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>

			<ul class="dropdown-menu pull-right">
				@if($clearance_status == "Pending")
					<form>
	        		<li><a href="#" onclick="send_sign( $(this).closest('form'), 4 , {{ $record_id }} )"><i class="fa fa-check text-success"></i> Cleared</a></li>
	        		</form>
	        	@endif
        		<li><a href="#" onclick="cancel_clearance({{ $user_id }}, {{ $action_id }}, {{ $record_id }})"><i class="fa fa-ban text-danger"></i> Cancel</a></li>
    		</ul>

		</div>
		@endif
	</td>
</tr>