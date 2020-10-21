<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('bank_settings.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.bank_type') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[bank_type]" id="payroll_bank-bank_type" value="{{ $record['payroll_bank.bank_type'] }}" placeholder="{{ lang('bank_settings.p_bank_type') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.bank_code_num') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[bank_code_numeric]" id="payroll_bank-bank_code_numeric" value="{{ $record['payroll_bank.bank_code_numeric'] }}" placeholder="{{ lang('bank_settings.p_bank_code_num') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.bank_code_alp') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[bank_code_alpha]" id="payroll_bank-bank_code_alpha" value="{{ $record['payroll_bank.bank_code_alpha'] }}" placeholder="{{ lang('bank_settings.p_bank_code_alp') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.acc_name') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[bank]" id="payroll_bank-bank" value="{{ $record['payroll_bank.bank'] }}" placeholder="{{ lang('bank_settings.p_acc_name') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.acc_num') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[account_no]" id="payroll_bank-account_no" value="{{ $record['payroll_bank.account_no'] }}" placeholder="{{ lang('bank_settings.p_acc_num') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.batch_num') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[batch_no]" id="payroll_bank-batch_no" value="{{ $record['payroll_bank.batch_no'] }}" placeholder="{{ lang('bank_settings.p_batch_num') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.ceiling_amt') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[ceiling_amount]" id="payroll_bank-ceiling_amount" value="{{ $record['payroll_bank.ceiling_amount'] }}" placeholder="{{ lang('bank_settings.p_ceiling_amt') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.branch_code') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[branch_code]" id="payroll_bank-branch_code" value="{{ $record['payroll_bank.branch_code'] }}" placeholder="{{ lang('bank_settings.p_branch_code') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.description') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_bank[description]" id="payroll_bank-description" placeholder="{{ lang('bank_settings.p_description') }}" rows="4">{{ $record['payroll_bank.p_description'] }}</textarea> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.address') }}</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="payroll_bank[address]" id="payroll_bank-address" placeholder="{{ lang('bank_settings.p_address') }}" rows="4">{{ $record['payroll_bank.address'] }}</textarea> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.branch_off') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[branch_officer]" id="payroll_bank-branch_officer" value="{{ $record['payroll_bank.branch_officer'] }}" placeholder="{{ lang('bank_settings.p_branch_off') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.branch_pos') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[branch_position]" id="payroll_bank-branch_position" value="{{ $record['payroll_bank.branch_position'] }}" placeholder="{{ lang('bank_settings.p_branch_pos') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.sign1') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[signatory_1]" id="payroll_bank-signatory_1" value="{{ $record['payroll_bank.signatory_1'] }}" placeholder="{{ lang('bank_settings.p_sign1') }}" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('bank_settings.sign2') }}</label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="payroll_bank[signatory_2]" id="payroll_bank-signatory_2" value="{{ $record['payroll_bank.signatory_2'] }}" placeholder="{{ lang('bank_settings.p_sign2') }}" /> 				
			</div>	
		</div>	
	</div>
</div>