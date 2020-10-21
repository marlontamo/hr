<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Nick Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="Enter Nick Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Maiden Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[maidenname]" id="users_profile-maidenname" value="{{ $record['users_profile.maidenname'] }}" placeholder="Enter Maiden Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Middle Initial</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[middleinitial]" id="users_profile-middleinitial" value="{{ $record['users_profile.middleinitial'] }}" placeholder="Enter Middle Initial"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Middle Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="Enter Middle Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">First Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="Enter First Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Last Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="Enter Last Name"/> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Company</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Work Schedule</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[shift_id]" id="partners-shift_id" value="{{ $record['partners.shift_id'] }}" placeholder="Enter Work Schedule"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Biometric Number</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[biometric]" id="partners-biometric" value="{{ $record['partners.biometric'] }}" placeholder="Enter Biometric Number"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">ID Number</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[id_number]" id="partners-id_number" value="{{ $record['partners.id_number'] }}" placeholder="Enter ID Number"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Role</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[role_id]" id="users_profile-role_id" value="{{ $record['users_profile.role_id'] }}" placeholder="Enter Role"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Position Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[position_id]" id="users_profile-position_id" value="{{ $record['users_profile.position_id'] }}" placeholder="Enter Position Title"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Location</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[location_id]" id="users_profile-location_id" value="{{ $record['users_profile.location_id'] }}" placeholder="Enter Location"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Company</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[company]" id="users_profile-company" value="{{ $record['users_profile.company'] }}" placeholder="Enter Company"/> 				</div>	
			</div>	</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employment</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Original Date Hired</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[orig_hired_date]" id="partners-orig_hired_date" value="{{ $record['partners.orig_hired_date'] }}" placeholder="Enter Original Date Hired"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Date Hired</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[effectivity_date]" id="partners-effectivity_date" value="{{ $record['partners.effectivity_date'] }}" placeholder="Enter Date Hired"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Employee Status</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="partners[status_id]" id="partners-status_id" value="{{ $record['partners.status_id'] }}" placeholder="Enter Employee Status"/> 				</div>	
			</div>	</div>
</div>