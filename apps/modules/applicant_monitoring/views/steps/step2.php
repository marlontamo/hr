<li class="media">
	<div class="media-body">
		<h4 class="media-heading"><?php echo $step->status?></h4>
		<p class="small"><?php echo $step->description?></p>
	</div>
	<div class="well margin-top-10"><?php
		if( isset($recruit ) ):
			$button_color = 'btn-primary';
			foreach( $recruit as $rec ): 
				$rec_process_result = $db->get_where('recruitment_process', array('process_id' => $rec->process_id));
				
				if($rec_process_result->num_rows() > 0){
					$rec_process = $rec_process_result->row_array();
					$button_color = ($rec_process['status_id'] == 2 && $rec_process['from_seting_final_interview'] == 2) ? 'btn-success' : 'btn-primary';
				}			
				?>
				<span class="margin-right-5">
					<span class="btn default btn-xs movable-label">:</span>
					<a type="button" class="btn <?php echo $button_color ?> btn-xs onclick-name" href="javascript:get_interview_list(<?php echo $rec->process_id?>)"> <?php
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