<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Basic Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Profile Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="profiles[profile]" id="profiles-profile" value="{{ $record['profiles.profile'] }}" placeholder="Enter Profile Name"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Description</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="profiles[description]" id="profiles-description" value="{{ $record['profiles.description'] }}" placeholder="Enter Description"/> 				</div>	
			</div>	</div>
</div>