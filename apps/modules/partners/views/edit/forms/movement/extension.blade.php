<div class="form-group">
	<label class="control-label col-md-3">
		Months
	</label>
	<div class="col-md-7">
	    <input type="hidden" name="partners_movement_action_extension[id]" id="partners_movement_action_extension-id" 
	    value="<?php echo $record['partners_movement_action_extension.id']; ?>" />				
		<input type="text" disabled class="form-control" name="partners_movement_action_extension[no_of_months]" id="partners_movement_action_extension-no_of_months" value="<?php echo $record['partners_movement_action_extension.no_of_months'] ?>" placeholder="Enter Months" /> 				
	</div>	
</div>			
<div class="form-group">
	<label class="control-label col-md-3">
		End Date
	</label>
	<div class="col-md-7">							
		<div class="input-group input-medium end_date" data-date-format="MM dd, yyyy">
			<input type="text" disabled class="form-control" name="partners_movement_action_extension[end_date]" 
			value="<?php echo $record['partners_movement_action_extension.end_date']; ?>"
			id="partners_movement_action_extension-end_date"  value="<?php echo $record['partners_movement_action_extension.end_date'] ?>" placeholder="Enter End Date" readonly>
			<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div> 				
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
<script language="javascript">
    $(document).ready(function(){

        if (jQuery().datepicker) {
            $('#partners_movement_action_extension-end_date').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); 
        }
        
		$('#partners_movement_action_extension-no_of_months').on('keyup', function() {
			var type = $('#partners_movement_action-type_id').val();
			if(type==13 && $.trim($(this).val()) > 0){
				no_months = $(this).val();
				var endDate = new Date($('#partners_movement_action-effectivity_date').val());
				var start_day = endDate.getDate();
				endDate.setMonth(endDate.getMonth() + parseInt(no_months));			

				d = new Date(endDate);
				var m_names = new Array("January", "February", "March", 
				"April", "May", "June", "July", "August", "September", 
				"October", "November", "December");

				var day = d.getDay();
				var month = d.getMonth();
				var year = d.getFullYear();
				end_date = m_names[month] + " " + start_day + ", " + year;	

				$('.end_date').datepicker('update',endDate);
			}
		});

    });
</script>