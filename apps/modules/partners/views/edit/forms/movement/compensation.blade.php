<div class="form-group">
	<label class="control-label col-md-3">
		Current Salary
	</label>
	<div class="col-md-7">
	    <input type="hidden" name="partners_movement_action_compensation[id]" id="partners_movement_action_compensation-id" 
	    value="<?php echo $record['partners_movement_action_compensation.id']; ?>" />						
		<input type="text" disabled readonly class="form-control" name="partners_movement_action_compensation[current_salary]" id="partners_movement_action_compensation-current_salary" value="<?php echo $record['partners_movement_action_compensation.current_salary'] ?>" placeholder="Enter Current Salary" /> 				
	</div>	
</div>			
<div class="form-group">
	<label class="control-label col-md-3">
		New Salary
	</label>
	<div class="col-md-7">							
		<input type="text" disabled class="form-control" name="partners_movement_action_compensation[to_salary]" id="partners_movement_action_compensation-to_salary" value="<?php echo $record['partners_movement_action_compensation.to_salary'] ?>" placeholder="Enter New Salary" /> 				
	</div>	
</div>	
<div class="form-group">
	<label class="control-label col-md-3">
		Attachment
	</label>
	<div class="col-md-7">
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
	</div>
</div>	