<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('branch.branch_information') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.branch') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[branch]" id="users_branch-branch" value="{{ $record['users_branch_branch'] }}" placeholder="{{ lang('branch.p_branch') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.branch_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[branch_code]" id="users_branch-branch_code" value="{{ $record['users_branch_branch_code'] }}" placeholder="Enter branch Code" /> 				
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.users_branch_sss_branch_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[users_branch_sss_branch_code]" id="users_branch-users_branch_sss_branch_code" value="{{ $record['users_branch_sss_branch_code'] }}" placeholder="Enter branch Code" /> 				
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.users_branch_sss_branch_code_locator') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[users_branch_sss_branch_code_locator]" id="users_branch-users_branch_sss_branch_code_locator" value="{{ $record['users_branch_sss_branch_code_locator'] }}" placeholder="Enter branch Code" /> 				
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.users_branch_hdmf_branch_code') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[users_branch_hdmf_branch_code]" id="users_branch-users_branch_hdmf_branch_code" value="{{ $record['users_branch_hdmf_branch_code'] }}" placeholder="Enter branch Code" /> 				
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">* </span>{{ lang('branch.users_branch_company_coe') }}</label>
			<div class="col-md-7">							
				<input type="text" disabled="disabled" class="form-control" name="users_branch[users_branch_company_coe]" id="users_branch-users_branch_company_coe" value="{{ $record['users_branch_company_coe'] }}" placeholder="Enter branch Code" /> 				
			</div>	
		</div>											
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('branch.active') }}</label>
			<div class="col-md-7">							
				<div class="make-switch" data-on-label="&nbsp;{{ lang('branch.option_yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('branch.option_no') }}&nbsp;">
			    	<input type="checkbox" disabled="disabled" value="1" @if( $record['users_branch_status_id'] ) checked="checked" @endif name="users_branch[status_id][temp]" id="users_branch-status_id-temp" class="dontserializeme toggle"/>
			    	<input type="hidden" disabled="disabled" name="users_branch[status_id]" id="users_branch-status_id" value="<?php echo $record['users_branch_status_id'] ? 1 : 0 ?>"/>
				</div> 				
			</div>	
		</div>	
	</div>
</div>