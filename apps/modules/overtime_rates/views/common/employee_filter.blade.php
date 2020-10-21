<div class="dtr-filter">
	<div class="margin-bottom-15">
		<span class="small text-muted">{{ lang('overtime_rates.select') }}</span>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="col-md-12">
    		<div class="input-group">
            <?php
                $db->order_by('company', 'asc');
                $companies = $db->get_where('users_company', array('deleted' => 0));
            ?>
            <select name="company_id" class="select2me" data-placeholder="Select..." 
                    style="width:215px">
                <option value="">Select...</option>
                <?php
                    foreach( $companies->result() as $company )
                    {
                        echo '<option value="'.$company->company_id.'">'. $company->company . '</option>';
                    }
                ?>
            </select>
          </div>
      </div>
		</div>
	</div>
</div>