<div class="dtr-filter">
	<div class="margin-bottom-15">
		<span class="small text-muted">Select company to filter a specific user.</span>
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
		<div class="col-md-4">
			<div class="col-md-12">
				<div class="input-group">
                 <!--    <span class="input-group-addon">
                       <i class="fa fa-list"></i> -->
                     <!-- </span> -->
                    <div id="department_div">
                    <select id="department_id" name="department_id" class="select2me" 
                    data-placeholder="Select..." style="width:215px">                   
                    </select>
                    </div>

                    <div id="dept_loader" class="text-center" style="display: none;">
                        <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." />Fetching department(s)
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-4">
			<div class="col-md-12">
				<div class="input-group">
                  <!--   <span class="input-group-addon">
                       <i class="fa fa-list"></i> -->
                     <!-- </span> -->
                    <div id="partners_div">
                    <select id="user_id" name="user_id" class="select2me" 
                    data-placeholder="Select..." style="width:210px">
                    </select>
                    </div>
                        
                    </select>
                    <div id="partners_loader" class="text-center" style="display: none;">
                        <img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." />Fetching partner(s)
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>