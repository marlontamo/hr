	<div class="margin-bottom-15">
		<span class="small text-muted">Select company and shift to filter shift class policy.</span>
    </div>
	
	<div class="col-md-4 margin-bottom-25">
			
		<div class="input-group">
			<?php
				$db->order_by('company', 'asc');
				$companies = $db->get_where('users_company', array('deleted' => 0));
			?>
			<select name="company_id" class="select2me" data-placeholder="Select company..." 
					style="width:280px">
				<option value="">Select company...</option>
				<?php
					foreach( $companies->result() as $company )
					{
						echo '<option value="'.$company->company_id.'">'. $company->company . '</option>';
					}
				?>
			</select>
		</div>
			
	</div>
	
	<div class="col-md-4">
		<div class="col-md-12">
			<div class="input-group">
				<?php
					$db->order_by('shift', 'asc');
					$shifts = $db->get_where('time_shift', array('deleted' => 0));
				?>
				<select name="shift_id" class="select2me" data-placeholder="Select shift..." 
						style="width:215px">
					<option value="">Select shift...</option>
					<?php
						foreach( $shifts->result() as $shift )
						{
							echo '<option value="'.$shift->shift_id.'">'. $shift->shift . '</option>';
						}
					?>
				</select>
			</div>
		</div>
	</div>
	
	<div class="actions">
		<div class="btn-group">
			<a href="{{ $mod->url }}/edit" class="btn btn-success btn-sm">
				<i class="fa fa-plus"></i>
			</a>
		</div>
	</div>