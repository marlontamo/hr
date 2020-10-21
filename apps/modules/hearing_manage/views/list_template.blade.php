<tr class="record">
	<!-- this first column shows the year of this holiday item -->
	<td>
		<?php 
		$get_users = " SELECT us.* FROM users_profile us
					WHERE us.user_id IN ({$involved_partners})";		
		$select_users = $db->query($get_users)->result_array();
		foreach($select_users as $value){
		?>
		<a href="#" class="text-success">{{$value['firstname']}} {{$value['lastname']}}</a>
		<br />
		<span class="small">{{ lang('hearing_manage.involved') }}</span>
		<?php
		}
		?>
	</td>
	<td>{{$partners_incident_offense_id}}</td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($hearing_date)); ?> <span class="text-muted small"><?php echo date("D",strtotime($hearing_date)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($hearing_date)); ?></span>
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
		@if(in_array($incident_status_id, array(1,2)))
	        <div class="btn-group">
	            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
	        </div>
	    @else
		    <div class="btn-group">
				<a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
			</div>
	    @endif	
	</td>
</tr>