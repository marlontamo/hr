<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Movement Details</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">	
		<?php if($type_id == 12): ?>
			<div class="form-group">
				<label class="control-label col-md-5">
					End Date of Temporary Assignment
				</label>
				<div class="col-md-5">							
					<div class="input-group input-medium" data-date-format="MM dd, yyyy">
						<input disabled type="text" class="form-control" name="partners_movement_action_transfer[end_date]" 
						id="partners_movement_action_transfer-end_date" value="<?php echo $end_date; ?>" placeholder="Enter End Date of Temporary Assignment" readonly>
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</div>	
			</div>
		<?php endif; ?>
		<table class="table table-bordered table-hover">
	        <thead>
	            <tr class="success">
	                <th width="30%"></th>
	                <th width="35%">Current</th>
	                <th width="35%">To</th>
	            </tr>
	        </thead>
	        <tbody>
		<?php foreach ($transfer_fields as $transfer_field) {
		?>
			<tr>
				<td>					
					<?php echo $transfer_field['field_label']; ?>
					<input type="hidden" name="partners_movement_action_transfer[field_id][]"
					id="partners_movement_action_transfer-field_id" value="<?php echo $transfer_field['field_id']; ?>">
					<input type="hidden" name="partners_movement_action_transfer[field_name][]"
					id="partners_movement_action_transfer-field_name" value="<?php echo $transfer_field['field_name']; ?>">
				</td>
				<td>
					<?php if(isset($transfer_field['from_name'])):
						 echo $transfer_field['from_name']; ?>

						<input type="hidden" class="form-control" name="partners_movement_action_transfer[from_id][]" 
						id="<?php echo $transfer_field['field_name']?>-from_id" value="<?php echo $transfer_field['from_id']; ?>"/> 
						<input type="hidden" readonly class="form-control" name="partners_movement_action_transfer[from_name][]" 
						id="<?php echo $transfer_field['field_name']?>-from_name" value="<?php echo $transfer_field['from_name']; ?>" /> 
					<?php endif;?>
				</td>
				<td>	
				<?php if( $transfer_field['table_name'] == "") {
					echo $transfer_field['to_name']; ?>
					<input type="hidden" class="form-control trans_field" name="partners_movement_action_transfer[to_name][]" 
					id="partners_movement_action_transfer-to_name-<?php echo $transfer_field['field_id']?>" 
					value="<?php echo $transfer_field['to_name']; ?>" placeholder="Enter New <?php echo $transfer_field['field_label']; ?>" /> 
					<input type="hidden" class="form-control" name="partners_movement_action_transfer[to_id][]" 
					id="partners_movement_action_transfer-to_id-<?php echo $transfer_field['field_id']?>" value="<?php echo $transfer_field['to_id']; ?>" /> 	
				<?php	}else{

					if($transfer_field['table_name'] == 'ww_users'){
						$qry = "SELECT * FROM {$transfer_field['table_name']} ORDER BY display_name"; 
					}else{
						$qry = "SELECT * FROM {$transfer_field['table_name']} ORDER BY {$transfer_field['field_name']}"; 
					}
					$options = $this->db->query($qry);
					
					?>							
					<div class="input-group">
						<span class="input-group-addon hidden">
							<i class="fa fa-list-ul"></i>
						</span>
						<input type="hidden" class="form-control" name="partners_movement_action_transfer[to_name][]" 
						id="partners_movement_action_transfer-to_name-<?php echo $transfer_field['field_id']?>" value="<?php echo $transfer_field['to_name']; ?>" /> 
						<select name="partners_movement_action_transfer[to_id][]" data-field="<?php echo $transfer_field['field_id']; ?>"
						id="partners_movement_action_transfer-to_id-<?php echo $transfer_field['field_id']?>"
						class="form-control form-select trans_field hidden" data-placeholder="Select...">
						<option value="">Select...</option>
						<!-- php loop -->
							<option <?php echo $selected; ?>  value="<?php echo $transfer_field['table_name'] == 'ww_users' ? $option->user_id : $option->$option_field_id; ?>">
								<?php echo $transfer_field['table_name'] == 'ww_users' ? $option->display_name : $option->$transfer_field['field_name'];?></option>
							<?php
						}
						?>
						</select>
						<?php
						foreach($options->result() as $option)
						{
							$option_field_id = strtolower($transfer_field['field_name'].'_id');		
							if($transfer_field['table_name'] == 'ww_users'){
								if($option->user_id == $transfer_field['to_id']){
									echo  $option->display_name;
								}
							}else{
								if(isset($option->$option_field_id) && $option->$option_field_id == $transfer_field['to_id']){
									echo $option->$transfer_field['field_name'];
								}
							}
						}	

						?>	
					</div> 	
							
				</td>	
			<tr>
		<?php 
		}
		?>
				<tr>
					<td>					
						Attachment
					</td>
					<td>
						<?php
					        if( !empty($photo) ){
								$file = FCPATH . urldecode( $photo);
								if( file_exists( $file ) )
								{
									$f_info = get_file_info( $file );
									$f_type = filetype( $file );

									switch( $f_type )
									{
										case 'image/jpeg':
											$icon = 'fa-picture-o';
											echo '<a class="fancybox-button" href="'.base_url($photo).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
							            	<span>'. basename($f_info['name']) .'</span></a>';
											break;
										case 'video/mp4':
											$icon = 'fa-film';
											echo '<a href="'.base_url($photo).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
							            <span>'. basename($f_info['name']) .'</span></a>';
											break;
										case 'audio/mpeg':
											$icon = 'fa-volume-up';
											echo '<a href="'.base_url($photo).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
							            <span>'. basename($f_info['name']) .'</span></a>';
											break;
										default:
											$icon = 'fa-file-text-o';
											echo '<a href="'.base_url($photo).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
							            <span>'. basename($f_info['name']) .'</span></a>';
									}
								}
							}
						?>
					</td>
				</tr>		
	    	</tbody>
    	</table>
	</div>
</div>
<script language="javascript">
$(document).ready(function(){
	$('select.form-select').select2();

	$('.trans_field').change(function(){
		to_name = $('#'+this.id +' option:selected').text();

		if($(this).val() > 0){
			$('#partners_movement_action_transfer-to_name-'+$(this).data('field')).val($.trim(to_name));		
		}else{
			$('#partners_movement_action_transfer-to_name-'+$(this).data('field')).val('');
		}
	});

    if (jQuery().datepicker) {
        $('#partners_movement_action_transfer-end_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); 
    }

});
</script>