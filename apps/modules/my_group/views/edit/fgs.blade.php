<div class="portlet">
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">Group Name</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="groups[group_name]" id="groups-group_name" value="{{ $record['groups.group_name'] }}" placeholder="Enter Group Name" />
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Description</label>
			<div class="col-md-7">
				<textarea class="form-control" name="groups[description]" id="groups-description" placeholder="Enter Description" rows="4">{{ $record['groups.description'] }}</textarea>
			</div>	
		</div>

		<div class="form-group">
			<label class="control-label col-md-3">Members</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="groups_members[user_id]" id="groups_members-user_id" value="{{ $members }}" placeholder="Enter Members" />
			</div>	
		</div>
	</div>
</div>

<script>
	current_members = new Array();
    <?php if( !empty($members) )
    {
        $this->db->where('user_id in ('.$members.')');
        $users = $this->db->get('users');
        foreach( $users->result() as $row ): ?>
            current_members[<?php echo $row->user_id?>] = '<?php echo $row->full_name?>'; <?php
        endforeach;
    }?>
</script>