<li class="media">
	<div class="media-body">
		<h4 class="media-heading"><?php echo $step->status?></h4>
		<p class="small"><?php echo $step->description?></p>
	</div>
	<div class="well margin-top-10"><?php
		if( isset($recruit ) ):
			foreach( $recruit as $rec ): 
				$this->db->limit(1);
				$recruit_user = $this->db->get_where('users_profile', array('recruit_id' => $rec->recruit_id));
				$btn = "btn-primary";
				$user_id = '';
				if( $recruit_user->num_rows() == 1 )
				{
					$rec201 = $recruit_user->row();
					$user_id = $rec201->user_id;
					$btn = "btn-success";
				}
				if($user_id == ''){?>

				<span class="margin-right-5">
					<span class="btn default btn-xs movable-label">:</span>
					<a type="button" class="btn <?php echo $btn?> btn-xs onclick-name" href="javascript:create_201(<?php echo $rec->process_id?>, '<?php echo $user_id?>')">
						<?php
					switch( $rec->gender )
					{
						case 'Female':
							echo '<i class="fa fa-female"></i>';
							break;
						default:
							echo '<i class="fa fa-male"></i>';
							break;
					}
					echo $rec->fullname?>
					</a>
				</span> 
			<?php }
			endforeach;
		endif;?>
	</div>
</li>