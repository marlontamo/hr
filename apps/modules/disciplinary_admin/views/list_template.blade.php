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
    	{{$partners_incident_offense_id}}
    	<br>
    	<span class="small text-muted">01.00</span>
    </td>
	<td>
		{{$da_sanction}}
    	<br>
    	@if(strtotime($da_modified_on) && $da_modified_on != '0000-00-00 00:00:00')
    		<span class="small text-muted">{{date('M d, Y', strtotime($da_modified_on))}}</span>
    	@else
    		<span class="small text-muted">{{date('M d, Y', strtotime($da_created_on))}}</span>
    		@endif
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
		@if(!in_array($incident_status_id, array(6)))	
	    <div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
		</div>
		@endif
	    <div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
		</div>
	</td>
</tr>