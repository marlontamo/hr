<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Section Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Section</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_section[section]" id="users_section-section" value="{{ $record['users_section.section'] }}" placeholder="Enter Section" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Section Code</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="users_section[section_code]" id="users_section-section_code" value="{{ $record['users_section.section_code'] }}" placeholder="Enter Section Code" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['users_section.status_id'] ) checked="checked" @endif name="users_section[status_id][temp]" id="users_section-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="users_section[status_id]" id="users_section-status_id" value="<?php echo $record['users_section.status_id'] ? 1 : 0 ?>"/>
							</div> 				</div>	
			</div>	</div>
</div>