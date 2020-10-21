<div class="tabbable tabbable-custom">
	<div >
		<ul class="nav nav-tabs ">
			<li class="active"><a data-toggle="tab" href="#tab1">Population</a></li>
			<li class=""><a data-toggle="tab" href="#tab2">Age Bracket</a></li>
		</ul>
	</div>
	<div  class="tab-content" style="border: none !important;">
		<div class="tab-pane active" id="tab1">
				<div id="population_stats" data-always-visible="1" data-rail-visible="1">
					<table class="table table-condensed table-hover">
						<thead>
							<tr>
								<th></th>
								<th>City</th>
								<th class="text-right" style="padding-right:15px">Count</th>
								<th>% Distribution</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count = 1;
							foreach($population['population'] as $city){ ?>
							<tr>
								<td><?php echo $count; ?></td>
								<td><?php echo $city->city; ?></td>
								<td class="text-right" style="padding-right:15px"><?php echo $city->population; ?></td>
								<td>
									<div class="progress" style="margin-bottom: 0px !important;">
										<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $city->percent; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $city->percent; ?>%">
											<span style="color:black"><?php echo $city->percent.'%'; ?></span>
										</div>
									</div>
								</td>
							</tr>
							<?php 
							$count++;
							} ?>
						</tbody>
					</table>
				</div>
			<!-- <div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 139.008px; background: rgb(161, 178, 189);"></div> -->
			<!-- <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div> -->
	</div>
		<div class="tab-pane" id="tab2">
			<div class="row">
				<div class="col-md-3 col-sm-3">
					<div style="position:absolute;float: left;" ><img src="<?php echo base_url('assets/img/female.jpg')?>" class="img-responsive"></div>
				</div>
				
				<div class="col-md-6 col-sm-6">
					
				</div>
				<div class="col-md-3 col-sm-3">
					<div style="position:absolute;float: left;" class="pull-left">&nbsp;<img src="<?php echo base_url('assets/img/male.jpg')?>" class="img-responsive"></div>
				</div>
			</div>
			<?php
				$first = true;
				foreach( $stats as $age_bracket => $gender ): ?>
					<div class="row margin-bottom-10 <?php if( $first ) echo 'margin-top-25'?>">
						<?php if(isset($gender['Female'])){?>
							<div class="col-md-5 col-sm-5">
								<div class="rounded-block l-pink pull-right">
									 <span class="lb-small pull-right"><?php echo $gender['Female']['count']?> <?php echo lang('common.female') ?></span><span class="pull-right percent-bold"><?php echo $gender['Female']['percentage']?>%<span>
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-md-5 col-sm-2">
								<div class="rounded-block l-pink pull-right">
									 <span class="lb-small pull-left">0 <?php echo lang('common.female') ?>  &nbsp;&nbsp;&nbsp;</span><span class="pull-left percent-bold">0%<span>
								</div>
							</div>
						<?php }?>
						<div class="margin-bottom-0 visible-sm"></div>
						<div class="col-md-2 col-sm-2" style="border-bottom:1px dashed #e0e0e0">
							<div class="lb-small text-center text-muted padding-top-5" style="font-size:10px;">Age <p><?php echo $age_bracket?></p></div>
						</div>
						<?php if(isset($gender['Male'])){?>
							<div class="col-md-5 col-sm-2">
								<div class="rounded-block b-blue pull-left">
									 <span class="lb-small pull-left"><?php echo $gender['Male']['count']?> <?php echo lang('common.male') ?> &nbsp;&nbsp;&nbsp;</span><span class="pull-left percent-bold"><?php echo $gender['Male']['percentage']?>%<span>
								</div>
							</div>
						<?php }else{ ?>
							<div class="col-md-5 col-sm-2">
								<div class="rounded-block b-blue pull-left">
									 <span class="lb-small pull-left">0 <?php echo lang('common.male') ?> &nbsp;&nbsp;&nbsp;</span><span class="pull-left percent-bold">0%<span>
								</div>
							</div>
						<?php }?>
					</div><?php
					$first = false;
				endforeach;
			?>
		</div>
	</div>
</div>