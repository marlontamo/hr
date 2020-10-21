@extends('layouts.master')

@section('page_styles')
	@parent
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/profile.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/game.css"/>
	@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-11 margin-bottom-25">
			<!-- SECTION 1 -->
			<div class="portlet margin-bottom-0">
				<div class="portlet-title">
					<div class="caption">
						<?php echo $profile['firstname'].' '.$profile['middlename'][0].'. '.$profile['lastname'] ?>
					</div>
					<div class="tools">
						<a class="collapse" href="javascript:;"></a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<!-- IMAGE AREA -->
						
						<!-- COMPANY INFORMATION -->
						<div class="col-md-7 col-sm-8 margin-bottom-25">
	                        <h4 class="game-title"><?php echo $play_details['league'] ?> </h4>
							<?php 
								$play_details['end_point'] = ( $play_details['end_point'] > 0 ) ? $play_details['end_point'] : 1;
								$width_percent = ($play_details['points']/$play_details['end_point']) * 100;
							?>
	                        <ul class="list-unstyled text-muted margin-bottom-10 col-md-10">
	                            <li class="padding-top-10 margin-bottom-15">
	                            	<img src="<?php echo theme_path().'/img/honey-points-45x45.png' ?>" class="pull-left">
	                            	<div class="progress progress-striped" style="margin-left: 60px; margin-top: 13px; padding-top: 0px;">
										<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $play_details['points'] ?>" aria-valuemin="0" aria-valuemax="500" style="width: <?php echo $width_percent ?>%">
											<span><?php echo $play_details['points'] ?> hp</span>
										</div>
									</div>
									<span class="pull-right small" style="margin-top: -17px;"><?php echo $play_details['points'] ?> of <?php echo $play_details['end_point'] ?> honey points</span>
									<span class="pull-left bold" style="margin-top: -19px; margin-left:60px;"><?php echo $play_details['total_points'] ?></span>
	                            </li>

	                            <li class="padding-top-10 margin-bottom-10 ">
	                            	<img src="<?php echo theme_path().'/img/honeyjars-45x45.png' ?>" class="pull-left">
	                            	<div class="progress progress-striped animate" style="margin-left: 60px; margin-top: 13px; padding-top: 0px;">
										<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $play_details['jars'] ?>" aria-valuemin="0" aria-valuemax="5" style="width: 60%">
											<span><?php echo $play_details['jars'] ?> honey jars</span>
										</div>
									</div>
									<!-- <span class="pull-right small" style="margin-top: -17px;"><?php echo $play_details['jars'] ?> out of 5 honey jars</span> -->
									<span class="pull-left bold" style="margin-top: -19px; margin-left:60px;">LEVEL <?php echo $play_details['level_no'] ?></span>
	                            </li>
	                        </ul>
	                        
						</div>

						<!-- PERSONAL INFORMATION -->
						<div class="col-md-5 col-sm-8 margin-top-25">
							<div class="clearfix margin-bottom-25 hidden-lg hidden-md"></div>
							<div class="portlet sale-summary margin-bottom-0 well padding-10">
								<div class="portlet-body">
									<ul class="list-unstyled">
										<li class="text-success bold"><h4 class="margin-bottom-0">Quick Summary</h4>
										</li>
										<li>
											<span class="text-muted">TOTAL HONEY POINTS</span> 
											<span class="pull-right" id="birthday"><?php echo $play_details['total_points'] ?> hp</span>
										</li>
										<li>
											<span class="text-muted">USED HONEY POINTS</span> 
											<span class="pull-right" id="city"><?php echo $play_details['used_points'] ?></span>
										</li>
										<li>
											<span class="text-muted">REDEEMED ITEMS</span> 
											<span class="pull-right" id="civilstatus"><?php echo $play_details['redeemed'] ?></span>
										</li>
									</ul>
								</div>
							</div>
							<div class="clearfix margin-bottom-10 hidden-lg hidden-md"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
    
		<div class="col-md-11 margin-top-25">

			<div class=" ">
				<ul class="nav nav-tabs ">
					<li class="active" id="badges_tab" ><a href="#tab_1" data-toggle="tab" >Badges</a></li>
					<li id="redemption_tab" class=""><a href="#tab_2" data-toggle="tab">Redemption</a></li>

				</ul>
				<div class="tab-content" style="min-height: 500px; margin-top:-10px;">
					<div class="tab-pane active " id="tab_1">
						<div class="portlet box blue">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-star-o"></i>List of Badges</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">

								<div class="row col-md-12">
									<?php foreach($badge_details as $badges): ?>
									<div class="well well-sm margin-bottom-4">
										<div class="clearfix">
											<div style="float:left; height:45px;">
												<img src="<?php echo base_url($badges['image_path']) ?>" alt="Badge">
											</div>

											<div style="margin-left:60px;">
												<span style="font-size:18px; color: #426D1D;">
													<?php echo $badges['badge'] ?>
												</span><br>
												
												<span style="font-size:11px; color: #999999;">													
													<?php echo $badges['description'] ?>
												</span>

												<div class="progress progress-striped" style=" margin-top: 15px; padding: 0px;">
													<?php 
														$width_percent = ($badges['badge_points']/$badges['points']) * 100;
													?>
													<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $badges['badge_points'] ?>" aria-valuemin="0" aria-valuemax="<?php echo $badges['badge_points'] ?>" style="width: <?php echo $width_percent ?>%">
														<span><?php echo $badges['badge_points'] ?></span>
													</div>
												</div>
												<span class="pull-right text-success" style="margin-top: -17px;"><?php echo $badges['badge_points'] ?>/<?php echo $badges['points'] ?> points</span>
													<!-- <span class="btn btn-success btn-sm">Redeem</span>
													<small class="text-info">You have (1) redeemable paid leave.</small>  -->
											</div>
										</div>
									</div>
									<?php endforeach; ?>

								</div>
							</div>
						</div>
						
					</div>
					<div class="tab-pane" id="tab_2">
						<div class="portlet box yellow">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-shopping-cart"></i>Redemption Store</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="note note-warning">
									<p>
										Store redemption informations.
									</p>
								</div>
								<div class="row">

									<?php foreach($redemptions as $redemption): ?>
									<div class=" col-sm-4 col-md-4">
										<div class="thumbnail">
											<img src="<?php echo base_url($redemption['image_path']) ?>" alt="image here" style="height: 200px;">
											<div class="caption">
												<h4 class="text-primary bold text-center"><?php echo $redemption['item'] ?> Cash</h4>

												<p class="small"><?php echo $redemption['description'] ?> </p>

												<div class="block">
													<img src="<?php echo theme_path().'/img/honey-points-26x26.png' ?>" class="pull-left" height="18px">
													<span style="margin-left: 8px;"><?php echo $redemption['points'] ?> honey points</span>
												</div>
												<br>
												<?php if ( $redemption['points'] < ($play_details['total_points'] - $play_details['used_points']) ) { ?>
													<a href="javascript:redeem_product( <?php echo $redemption['item_id'] ?>)" class="btn btn-success btn-block">Redeem</a> 
												<?php }else{ ?>
													<a href="#" class="btn btn-success btn-block disabled">Redeem</a> 
												<?php } ?>
											</div>
										</div>
									</div>
									<?php endforeach; ?>									

								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>

		</div>
		
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop
