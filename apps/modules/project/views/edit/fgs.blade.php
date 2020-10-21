<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Project Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Project</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_project[project]" id="users_project-project" value="{{ $record['users_project.project'] }}" placeholder="Enter Project" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>Project Code</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="users_project[project_code]" id="users_project-project_code" value="{{ $record['users_project.project_code'] }}" placeholder="Enter Project Code" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">Active</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
			    	<input type="checkbox" value="1" @if( $record['users_project.status_id'] ) checked="checked" @endif name="users_project[status_id][temp]" id="users_project-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" name="users_project[status_id]" id="users_project-status_id" value="@if( $record['users_project.status_id'] ) 1 else 0 @endif"/>
				</div> 	
			</div> 			
		</div>	
	</div>
</div>