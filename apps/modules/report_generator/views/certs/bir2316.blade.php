<div class="portlet" style="margin-bottom:60px;">
	<div class="portlet-body form">
		<!-- add company filter -->
		<div class="form-group">
			<label class="control-label col-md-3">Company:</label>
			<div class="col-md-8">
				<?php
					$db->select('company_id, company');
					$db->where('deleted', '0');
					$db->order_by('company asc');
					$options = $db->get('users_company');
					$company_id_options = array();
					foreach($options->result() as $option)
					{
						$company_id_options[$option->company_id] = $option->company;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('company_id',$company_id_options, '', 'class="form-control company select2me" data-placeholder="Select..." id="company_id"') }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Partner:</label>
			<div class="col-md-8">
				<?php
					$db->select('user_id, alias');
					$db->where('deleted', '0');
					$options = $db->get('partners');
					$users_id_options = array();
					foreach($options->result() as $option)
					{
						$users_id_options[$option->user_id] = $option->alias;
					} 
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('users[]',$users_id_options, '', 'class="form-control select2me" multiple="multiple" data-placeholder="Select..." id="full_name"') }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Year:</label>
			<div class="col-md-8">
				<?php
					$db->select('DISTINCT(`pay_year`)');
					$db->where('deleted', '0');
					$options = $db->get('payroll_bir');
					$year_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$year_options[$option->pay_year] = $option->pay_year;
					}
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('pay_year',$year_options, '', 'class="form-control select2me" data-placeholder="Select..." id="pay_year"') }}
				</div>
			</div>	
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Signatory:</label>
			<div class="col-md-8">
				<?php
					$db->select('user_id, alias');
					$db->where('deleted', '0');
					$options = $db->get('partners');
					$users_id_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$users_id_options[$option->user_id] = $option->alias;
					}
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('signatory',$users_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="signatory"') }}
				</div>
			</div>	
		</div>

	</div>
</div>