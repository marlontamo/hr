<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Branch Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">			
			<div class="form-group">
				<label class="control-label col-md-3">Branch</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="users_branch[branch]" id="users_branch-branch" value="{{ $record['users_branch.branch'] }}" placeholder="Enter branch" /> 				
				</div>	
			</div>			
			<div class="form-group">
				<label class="control-label col-md-3">Branch Code</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="users_branch[branch_code]" id="users_branch-branch_code" value="{{ $record['users_branch.branch_code'] }}" placeholder="Enter branch Code" /> 				
				</div>	
			</div>	
            <div class="form-group">
                <label class="control-label col-md-3">SSS Branch Code</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="32" name="users_branch[sss_branch_code]" id="maxlength_defaultconfig" placeholder="Enter SSS Branch Code" value="{{ $record['users_branch.sss_branch_code'] }}">
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-3">SSS Branch Code Locator</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="32" name="users_branch[sss_branch_code_locator]" id="maxlength_defaultconfig" placeholder="Enter SSS Branch Code Locator" value="{{ $record['users_branch.sss_branch_code_locator'] }}">
                </div>
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">PAG-IBIG Branch Code</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="32" name="users_branch[hdmf_branch_code]" id="maxlength_defaultconfig" placeholder="Enter Pag-IBIG Branch Code" value="{{ $record['users_branch.hdmf_branch_code'] }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Company Name to Appear on COE</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" maxlength="32" name="users_branch[company_coe]" id="maxlength_defaultconfig" placeholder="Enter Company Name to Appear on COE" value="{{ $record['users_branch.company_coe'] }}">
                </div>
            </div>                                 
			<div class="form-group">
				<label class="control-label col-md-3">Active</label>
				<div class="col-md-7">							
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input type="checkbox" value="1" @if( $record['users_branch.status_id'] ) checked="checked" @endif name="users_branch[status_id][temp]" id="users_branch-status_id-temp" class="dontserializeme toggle"/>
				    	<input type="hidden" name="users_branch[status_id]" id="users_branch-status_id" value="<?php echo $record['users_branch.status_id'] ? 1 : 0 ?>"/>
					</div> 				
				</div>	
			</div>	
		</div>
</div>
