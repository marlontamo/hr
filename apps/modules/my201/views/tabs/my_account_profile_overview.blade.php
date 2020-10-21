	<div class="row" id="profile_overview">
		<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-gear"></i>{{ lang('my201.employment') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-phone"></i>{{ lang('my201.contacts') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab15"><i class="fa fa-user"></i>{{ lang('my201.id_no') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab3"><i class="fa fa-user"></i>{{ lang('my201.personal') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab14"><i class="fa fa-group"></i>{{ lang('my201.family') }}</a></li
			</ul>
		</div>
		<div class="tab-content col-lg-9 col-md-8" >
			<div class="tab-pane active" id="overview_tab1">
				<!-- Company Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.company_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.company') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="companyname">{{$profile_company}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.location') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="location">{{$location}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.position') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="position-title">{{$position}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row hidden">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.role') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="role-permission">{{$permission}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.id_no') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="id-number">{{$id_number}}</span>
									</div>
								</div>
							</div>
						</div>
                		<!-- @if(in_array('old_id_number', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ $partners_labels['old_id_number'] }} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="id-number">{{$old_id_number}}</span>
										</div>
									</div>
								</div>
							</div>
						@endif -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.biometric') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="biometric">{{$biometric}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.work_sched') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="shift">{{$calendar}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Employment Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.employment_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.status') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-status">{{$status}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.type') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-status">{{$type}}</span>
									</div>
								</div>
							</div>
						</div>
						@if( in_array( 'job_class', $partners_keys ))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.jobClass') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-status">{{$record['job_class']}}</span>
									</div>
								</div>
							</div>
						</div>
						@endif
                        @if( in_array( 'job_rank_level', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.job_rank_level') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['job_rank_level']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if( in_array( 'job_level', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.job_level') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['job_level']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if( in_array( 'pay_level', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.pay_level') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['pay_level']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if( in_array( 'pay_set_rates', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.pay_set_rates') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['pay_set_rates']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if( in_array( 'competency_level', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.competency_level') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['competency_level']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
						@if( in_array( 'employee_grade', $partners_keys ))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.employee_grade') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-status">{{$record['employee_grade']}}</span>
									</div>
								</div>
							</div>
						</div>
						@endif
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.hire_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="date-hired">{{$date_hired}}</span>
									</div>
								</div>
							</div>
						</div>
                		@if(in_array('probationary_date', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ $partners_labels['probationary_date'] }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$probationary_date}}</span>
									<br>
	                        		<span class="text-muted small">End date of employment/contract service</span>
									</div>
								</div>
							</div>
						</div>
	                @endif
	                @if(in_array('original_date_hired', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.ohire_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$original_date_hired}}</span>
									</div>
								</div>
							</div>
						</div>
                	@endif
	                @if(in_array('regularization_date', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.reg_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$regularization_date}}</span>
									</div>
								</div>
							</div>
						</div>
                	@endif                	
                	@if(in_array('last_probationary', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.last_probi') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$last_probationary}}</span>
									</div>
								</div>
							</div>
						</div>
                	@endif
                	@if(in_array('last_salary_adjustment', $partners_keys))
						<div class="row ">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.last_sa') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$last_salary_adjustment}}</span>
									</div>
								</div>
							</div>
						</div>
                	@endif
					</div>
				</div>
				<!-- Work Assignment Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.work_assignment') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.reports_to') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reports-to">{{$reports_to}}</span>
									</div>
								</div>
							</div>
						</div>
	                	@if(in_array('organization', $partners_keys))
							<div class="row ">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.org') }} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="organization">{{$organization}}</span>
										</div>
									</div>
								</div>
							</div>
	               	 	@endif
	                	@if(in_array('division', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.div') }} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="position-title">{{$division}}</span>
										</div>
									</div>
								</div>
							</div>
						@endif
	                	@if(in_array('department', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.dept') }} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="position-title">{{$department}}</span>
										</div>
									</div>
								</div>
							</div>
						@endif		
                		@if(in_array('branch', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.branch') }} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="position-title">{{$branch}}</span>
										</div>
									</div>
								</div>
							</div>
						@endif										
                        @if(in_array('agency_assignment', $partners_keys))
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.agency_assignment') }} :</label>
                                        <div class="col-md-7 col-sm-7">
                                            <span id="agency_assignment">{{$agency_assignment}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
						@if(in_array('section', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ $partners_labels['section']}} :</label>
										<div class="col-md-7 col-sm-7">
											<span id="emergency-name">{{ $record['section'] or '' }}</span>
										</div>
									</div>
								</div>
							</div>
						@endif
						<div class="row hidden">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.group') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="id-number">{{$group}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="overview_tab2">
				<!-- Contact Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.personal_contact') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                @if(in_array('phone', $partners_keys))
                	<?php foreach($profile_telephones as $telephone){ 
                            if(!empty($telephone)){ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="phone"><?=$telephone?></span>
									</div>
								</div>
							</div>
						</div>
                	<?php }
                	}
                	if (empty($profile_telephones)){ 
                	?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="phone">n/a</span>
									</div>
								</div>
							</div>
						</div>
                	<?php } ?>
                @endif
                @if(in_array('mobile', $partners_keys))
                    <?php foreach($profile_mobiles as $mobile){ 
                            if(!empty($mobile)){ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname"><?=$mobile?></span>
									</div>
								</div>
							</div>
						</div>
                	<?php }
                	} 
                	if (empty($profile_mobiles)){ 
                	?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="phone">n/a</span>
									</div>
								</div>
							</div>
						</div>
                	<?php } ?>
                @endif							
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.email') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$profile_email}}</span>
									</div>
								</div>
							</div>
						</div>
                @if(in_array('address_1', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.address') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$complete_address}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('city_town', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.city') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$profile_live_in}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('zip_code', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.zip') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$zip_code}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
					</div>
				</div>
				<!-- Company Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.emergency_contact') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                @if(in_array('emergency_name', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.name') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-name">{{$emergency_name}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_relationship', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.relationship') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-relationship">{{$emergency_relationship}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_phone', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-phone">{{$emergency_phone}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_mobile', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-mobile">{{$emergency_mobile}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_address', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.address') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-address">{{$emergency_address}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_city', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.city') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-city">{{$emergency_city}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_country', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.country') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-country">{{$emergency_country}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('emergency_zip_code', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.zip') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-zipcode">{{$emergency_zip_code}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
					</div>
				</div>
			</div>

			<div class="tab-pane" id="overview_tab15">
				<!-- ID Numbers -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.id_no') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                @if(in_array('taxcode', $partners_keys))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['taxcode'] }} :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <span id="emergency-name">{{$record['taxcode']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
                @if(in_array('sss_number', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['sss_number'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['sss_number']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('pagibig_number', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['pagibig_number'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['pagibig_number']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('philhealth_number', $partners_keys))
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['philhealth_number'] }} :</label>
										<div class="col-md-6 col-sm-6">
											<span id="emergency-name">{{$record['philhealth_number']}}</span>
										</div>
									</div>
								</div>
							</div>
                @endif
                @if(in_array('tin_number', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['tin_number'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['tin_number']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif 
                @if(in_array('bank_account_number', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['bank_account_number'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['bank_number']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif

                @if(in_array('bank_account_number_savings', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['bank_account_number_savings'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['bank_account_number_savings']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('bank_account_number_current', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['bank_account_number_current'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['bank_account_number_current']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                                                
                @if(in_array('bank_account_name', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['bank_account_name'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['bank_account_name']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('health_care', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-5 col-sm-5 text-right text-muted">{{ $partners_labels['health_care'] }} :</label>
									<div class="col-md-6 col-sm-6">
										<span id="emergency-name">{{$record['health_care']}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
					</div>
				</div>
			</div>
			<div class="tab-pane" id="overview_tab3">
				<!-- Personal Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.personal') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                @if(in_array('gender', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.gender') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="gender">{{$gender}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.bday') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="birthday">{{$profile_birthdate}}</span>
									</div>
								</div>
							</div>
						</div>
                @if(in_array('birth_place', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.birthplace') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="place-of-birth">{{$birth_place}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('religion', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.religion') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="religion">{{$religion}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('nationality', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.nationality') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="nationality">{{$nationality}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('civil_status', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.civil_status') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status">{{$profile_civil_status}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('solo_parent', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.solo_parent') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status">{{$personal_solo_parent}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('with_parking', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ $partners_labels['with_parking'] }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status">{{$with_parking}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
					</div>
				</div>
				<!-- Other Personal Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('my201.other_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                @if(in_array('height', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.height') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="height">{{$height}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('weight', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.weight') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="weight">{{$weight}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('interests_hobbies', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.hobby') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="interest-hobbies">{{$interests_hobbies}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('language', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.languages') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="language-known">{{$language}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('dialect', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.dialects') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="dialect-known">{{$dialect}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
                @if(in_array('dependents_count', $partners_keys))
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.no_dependents') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="no-of-dependents">{{$dependents_count}}</span>
									</div>
								</div>
							</div>
						</div>
                @endif
					</div>
				</div>
			</div>
			<div class="tab-pane " id="overview_tab14">
				@if(sizeof($family_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="family-relationship[1]" class="caption">{{ lang('my201.family') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('my201.no_info_fam') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Family Information -->
				<?php foreach($family_tab as $index => $family){ 					
			        //date in mm/dd/yyyy format; or it can be in other formats as well
			        $birthDate = date('m/d/Y', strtotime($family['family-birthdate']));
			        //explode the date to get month, day and year
			        $birthDate = explode("/", $birthDate);
			        //get age from date or birthdate
			        $family_age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			                ? ((date("Y") - $birthDate[2]) - 1)
			                : (date("Y") - $birthDate[2]));
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="family-relationship[1]"><?php 
						$family_relationship = array_key_exists('family-relationship', $family) ? $family['family-relationship'] : "";
						echo $family_relationship; ?>
						</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.name') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-name[1]"><?php echo array_key_exists('family-name', $family) ? $family['family-name'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.bday') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-birthdate[1]"><?php echo array_key_exists('family-birthdate', $family) ? $family['family-birthdate'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('my201.age') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-year-to[1]"><?php echo $family_age; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">Dependent :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status"><?php echo array_key_exists('family-dependent', $family) ? $family['family-dependent'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>

		</div>
	</div>
