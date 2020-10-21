<!-- BEGIN OF FORM-->
<div class="portlet"><?php
	//get the template
	foreach( $sections as $section ):
		$has_balancescorecard = false;
		foreach( $section->children as $child ):
			if( $child->section_type_id == 2 ||  $child->section_type_id == 4)
				$has_balancescorecard = true;
		endforeach;

		if( $has_balancescorecard ): ?>
			<div class="portlet-title">
				<div class="caption"><?php echo $section->template_section ?> <?php echo ($section->weight > 0 ? '(' + $section->weight + ')' : '') ?></div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
					</div>
			</div> 
			<div class="portlet-body">
				<div class="clearfix"> <?php
					foreach( $section->children as $child ):
						switch( $child->section_type_id )
						{
							case 2: //balance Scorecard ?>
								<div class="panel panel-success">
									<div class="panel-heading">
										<h3 class="panel-title">
											<?php echo $child->template_section ?> (<?php echo $child->weight ?>%)
										</h3>
									</div>
									<?php $this->load->view('edit/sections/balance_scorecard', array('section_id' => $child->template_section_id,'header' => $child->header, 'footer' => $child->footer, 'planning_id' => $planning_id)); ?>
								</div> <?php 
								break;
							case 4: ?>
								<div class="panel panel-success">
									<div class="panel-heading">
										<h3 class="panel-title">
											<?php echo $child->template_section ?> (<?php echo $child->weight ?>%)
										</h3>
									</div>
									<?php $this->load->view('edit/sections/library_crowd', array('section_id' => $child->template_section_id,'header' => $child->header, 'footer' => $child->footer)); ?>
								</div> <?php
								break;
							case 5: ?>
								<div class="panel panel-success">
									<div class="panel-heading">
										<h3 class="panel-title">
											<?php echo $child->template_section ?> <?php echo ($child->weight > 0 ? $child->weight .' %' : '') ?>
										</h3>
									</div>
									<?php $this->load->view('edit/sections/personal_development_plan', array('section_id' => $child->template_section_id,'header' => $child->header, 'footer' => $child->footer, 'planning_id' => $planning_id)); ?>
								</div> <?php
								break;								
							default:
						}
					endforeach;	?>
				</div>
			</div><?php
		endif;
	endforeach; ?>
</div>