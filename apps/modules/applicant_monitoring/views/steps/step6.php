<li class="media">
	<div class="media-body">
		<h4 class="media-heading"><?php echo $step->status?></h4>
		<p class="small"><?php echo $step->description?></p>
	</div>
	<div class="well margin-top-10"><?php
		if( isset($recruit ) ):
			$button_color = 'btn-primary';		
			foreach( $recruit as $rec ): 
				$jo = $db->get_where('recruitment_process_offer', array('process_id' => $rec->process_id));
				
				if($jo->num_rows() > 0){
					$jobOffer = $jo->row_array();
					$button_color = ($jobOffer['accept_offer'] == 1) ? 'btn-primary' : 'btn-danger';
				}else{
					$button_color = 'btn-primary';
				}
				if($rec->blacklisted ==1){					
					$button_color = 'btn-danger';
				}			
		?>
				<span class="margin-right-5">
					<span class="btn default btn-xs movable-label">:</span>
					<a type="button" class="btn <?php echo $button_color ?> btn-xs onclick-name" href="javascript:get_jo_form(<?php echo $rec->process_id?>)"> <?php
						switch( $rec->gender )
						{
							case 'Female':
								echo '<i class="fa fa-female"></i>';
								break;
							default:
								echo '<i class="fa fa-male"></i>';
								break;
						} ?>
						<?php echo $rec->fullname?>
					</a>
				</span> <?php
			endforeach;
		endif;?>
	</div>
</li>