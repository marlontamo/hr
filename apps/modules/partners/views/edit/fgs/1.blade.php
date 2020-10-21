<div class="portlet">
	<div class="portlet-title">
		<div class="caption">General Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Last Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" value="{{ $record['users_profile.lastname'] }}" placeholder="Enter Last Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">First Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" value="{{ $record['users_profile.firstname'] }}" placeholder="Enter First Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Middle Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" value="{{ $record['users_profile.middlename'] }}" placeholder="Enter Middle Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Maiden Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[maidenname]" id="users_profile-maidenname" value="{{ $record['users_profile.maidenname'] }}" placeholder="Enter Maiden Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Nick Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_profile[nickname]" id="users_profile-nickname" value="{{ $record['users_profile.nickname'] }}" placeholder="Enter Nick Name"/> 				</div>	
			</div>	</div>
</div>