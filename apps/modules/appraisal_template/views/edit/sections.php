<?php
	foreach($sections as $parent) : ?>
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><?php echo $parent->template_section?> <?php echo ($parent->weight > 0 ? '('+ $parent->weight +'%)' : '') ?></div>
				<div class="tools">
					<span class="pull-right small margin-right-5"><a href="javascript: delete_section( <?php echo $parent->template_section_id?> )">Delete</a></span>
					<span class="pull-right small margin-right-5"><a> | </a></span>
					<span class="pull-right small margin-right-5"><a href="javascript: section_form( <?php echo $parent->template_section_id?> )">Edit</a></span>
				</div>
			</div>	
			<div class="portlet-body">
				<div class="clearfix"> <?php
					foreach($parent->children as $child) : ?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									<?php echo $child->template_section?> (<?php echo $child->weight?>%)
									<span class="pull-right small"><a href="javascript: delete_section( <?php echo $child->template_section_id?> )" class="text-muted">Delete</a></span>
									<span class="pull-right small margin-right-5"> | </span>
									<span class="pull-right small margin-right-5"><a href="javascript: section_form( <?php echo $child->template_section_id?> )" class="text-muted">Edit</a></span>
								</h3>
							</div>
							<?php
								switch( $child->section_type_id )
								{
									case 2: //balance Scorecard
										$this->load->view('edit/sections/balance_scorecard', array('section_id' => $child->template_section_id));
										break;
									case 3: //library
									case 4: //library for crowdsource
										$this->load->view('edit/sections/library', array('section_id' => $child->template_section_id));
										break;
									default:
								} ?>	
						</div> <?php
					endforeach;?>
				</div>
			</div>
		</div> <?php
	endforeach;
?>