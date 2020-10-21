<div class="portlet margin-bottom-0" id="profile_header_overview">
	<div class="portlet-title">
		<div class="caption">
			<?php echo $profile_name; ?>
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>

	<div class="portlet-body form">
		<input type="hidden" value="<?php echo $record['record_id']; ?>" name="record_id" id="record_id">
		<div class="row">
			<!-- IMAGE AREA -->
			<div class="col-md-2 col-sm-4">
				<ul class="list-unstyled profile-nav">
					<li>
						<img src="<?php echo base_url($record['users_profile.photo']) ?>" class="img-responsive" alt="" style="width:180px;" /> 
						<!-- <a href="#" class="profile-edit">edit</a> -->
					</li>
				</ul>
			</div>
			<!-- COMPANY INFORMATION -->
			<div class="col-md-6 col-sm-8">
				<h4 id="position-name"><?php echo $record['users_position.position']; ?></h4>
				<h5 id="company-name" class="margin-bottom-15"><?php echo $record['users_profile.company']; ?></h5>
				<ul class="list-inline text-muted margin-bottom-10">
					<li><i class="fa fa-envelope"></i> <span id="email"> <?php echo $record['users.email']; ?></span></li>
				</ul>
				<!--  LOOP ALL PHONE NUMBERS HERE -->
				<ul class="list-inline text-muted margin-bottom-10">
					<?php foreach($profile_telephones as $telephone){ ?>
					<li><i class="fa fa-phone"></i> <?=$telephone?></li>
					<?php } ?>
				</ul>
				<!--  LOOP ALL FAX NUMBERS HERE -->
				<ul class="list-inline text-muted margin-bottom-10">
					<?php foreach($profile_fax as $fax_no){ ?>
					<li><i class="fa fa-print"></i> <?=$fax_no?></li>
					<?php } ?>
				</ul>
				<!-- LOOP ALL MOBILE NUMBERS HERE -->
				<ul class="list-inline text-muted margin-bottom-10">
					<?php foreach($profile_mobiles as $mobile){ ?>
					<li><i class="fa fa-mobile"></i> <?=$mobile?></li>
					<?php } ?>
				</ul>
			</div>
			<!-- PERSONAL INFORMATION -->
			<div class="col-md-4 col-sm-12">
				<div class="portlet sale-summary margin-bottom-0">
					<div class="portlet-body">
						<ul class="list-unstyled">
							<li>
								<h5 class="margin-bottom-0">Quick Information</h5>
							</li>
							<li>
								<span class="text-muted"><i class="fa fa-calendar"></i>&nbsp; Birthday</span> 
								<span class="pull-right" id="birthday"> <?php echo $record['users_profile.birth_date']; ?></span>
								<br />
								<span class="pull-right small text-muted"> <?php echo $profile_age; ?> yrs old</span>
							</li>
							<li>
								<span class="text-muted"><i class="fa fa-map-marker"></i>&nbsp; Lives in</span> 
								<span class="pull-right" id="city"> <?php echo $profile_live_in; ?></span>
								<br />
								<span class="pull-right small text-muted"> <?php echo $profile_country; ?></span>
							</li>
							<li>
								<span class="text-muted"><i class="fa fa-user"></i>&nbsp; <?php echo lang('partners.civil_status')?></span> 
								<span class="pull-right" id="civilstatus"> <?php echo $profile_civil_status; ?></span>
								<br />
								<span class="pull-right small text-muted"> <?php echo strtolower($profile_civil_status) == "married" ? "Spouse ".$profile_spouse : "" ?></span>
							</li>
							<!-- <li>
                                <a class="btn icn-only green" onclick="javascipt:edit_profile();">Change Request <i class="m-icon-swapright m-icon-white"></i></a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                    <div class="clearfix margin-bottom-10 hidden-lg hidden-md"></div>
            </div>
        </div>
    </div>
</div>