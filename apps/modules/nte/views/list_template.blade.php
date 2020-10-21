<tr class="record">
	<!-- this first column shows the year of this holiday item -->
	<td>
		<?php 
		$get_users = " SELECT us.* FROM users_profile us
					WHERE us.user_id IN ({$nte_id})";		
		$select_users = $db->query($get_users)->result_array();
		foreach($select_users as $value){
		?>
		<a href="#" class="text-success">{{$value['firstname']}} {{$value['lastname']}}</a>
		<br />
		<span class="small">{{$label}}</span>
		<?php
		}
		?>
	</td>
	<td>{{$partners_incident_offense_id}}</td>
    
    <td class="hidden-xs">
    	<?php $date_sent_created = (strtotime($date_sent)) ? $date_sent : $partner_incident_created_on;
    	echo date("M-d",strtotime($date_sent_created)); ?> 
    	<span class="text-muted small"><?php echo date("D",strtotime($date_sent_created)); ?></span>
    	<br>
        <span class="text-muted small"><?php echo date("Y",strtotime($date_sent_created)); ?></span>
    </td>
	
	<td class="hidden-xs">
		@if($status == 'Open')
		<span class="badge badge-warning">{{$status}}</span><br>
		@elseif($status == 'Close')
		<span class="badge badge-success">{{$status}}</span><br>
		@endif

		@if($nte_status_id == 1)
		<span class="text-muted small">{{ lang('common.draft') }} </span>
		@elseif($nte_status_id == 2)
		<span class="text-muted small">{{ lang('nte.for_im_review') }} </span>
		@else
		<span class="text-muted small">{{ lang('common.new') }} NTE </span>
		@endif

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