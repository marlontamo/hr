<tr class="record">
	<!-- this first column shows the year of this holiday item -->
	<td>

		<?php 
		$get_users = " SELECT us.*, pos.position FROM users_profile us
					JOIN ww_users_position pos ON us.position_id = pos.position_id
					WHERE us.user_id IN ({$involved_partners})";		
		$select_users = $db->query($get_users)->result_array();
		foreach($select_users as $value){
		?>
		<a href="#" class="text-success">{{$value['firstname']}} {{$value['lastname']}}</a>
		<br />
		<span class="small">{{$value['position']}}</span>
		<?php
		}
		?>
	</td>
    <td class="hidden-xs">
    	<?php $date_sent_created = (strtotime($date_sent)) ? $date_sent : $partner_incident_created_on;
    	echo date("M-d",strtotime($date_sent_created)); ?> 
    	<span class="text-muted small"><?php echo date("D",strtotime($date_sent_created)); ?></span>
    	<br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_sent_created)); ?></span>
    </td>
	<td>

		<?php 
		$get_users = " SELECT us.*, pos.position FROM users_profile us
					JOIN ww_users_position pos ON us.position_id = pos.position_id
					WHERE us.user_id IN ({$complainants})";		
		$select_users = $db->query($get_users)->result_array();
		foreach($select_users as $value){
		?>
		<a href="#" class="text-success">{{$value['firstname']}} {{$value['lastname']}}</a>
		<br />
		<span class="small">{{$value['position']}}</span><br />
		<?php
		}
		?>
	</td>
	
	<td class="hidden-xs">
		@if($status == 'Open')
		<span class="badge badge-warning">{{$status}}</span><br>
		@elseif($status == 'Close')
		<span class="badge badge-success">{{$status}}</span><br>
		@endif
		<span class="text-muted small">{{$incident_status}} </span>
	</td>
	<td>		
	    <div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
		</div>
	</td>
</tr>