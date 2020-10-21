	<div class="row" id="profile_overview">
		<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-gear"></i>{{ lang('partners_immediate.employment') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-phone"></i>{{ lang('partners_immediate.contacts') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab3"><i class="fa fa-user"></i>{{ lang('partners_immediate.personal') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab14"><i class="fa fa-group"></i>{{ lang('partners_immediate.family') }}</a></li>
			</ul>
		</div>
		<div class="tab-content col-lg-9 col-md-8" >
			<div class="tab-pane active" id="overview_tab1">
				<!-- Company Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.company_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.company') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="companyname">{{$profile_company}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.location') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="location">{{$location}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.position') }} {{ lang('partners_immediate.title') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="position-title">{{$position}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row hidden">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.role') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="role-permission">{{$permission}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.id_no') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="id-number">{{$id_number}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.biometric') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="biometric">{{$biometric}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.work_sched') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="shift">{{$shift}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Employment Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.employment_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                        @if( in_array( 'taxcode', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.taxcode') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['taxcode']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif  
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.status') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-status">{{$status}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.type') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-type">{{$type}}</span>
									</div>
								</div>
							</div>
						</div>
                        @if( in_array( 'job_class', $partners_keys ))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.jobClass') }} :</label>
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
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.job_rank_level') }} :</label>
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
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.job_level') }} :</label>
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
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.pay_level') }} :</label>
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
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.pay_set_rates') }} :</label>
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
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.competency_level') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="employment-status">{{$record['competency_level']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.hire_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="date-hired">{{$date_hired}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.probi_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$probationary_date}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.ohire_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$original_date_hired}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.last_probi') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$last_probationary}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.last_sa') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$last_salary_adjustment}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Work Assignment Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.work_assignment') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.reports_to') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reports-to">{{$reports_to}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.org') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="organization">{{$organization}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.div') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="position-title">{{$division}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.dept') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="role-permission">{{$department}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.group') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="id-number">{{$group}}</span>
									</div>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.agency_assignment') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="agency_assignment">{{$agency_assignment}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.section') }} :</label>
                                    <div class="col-md-7 col-sm-7">
                                        <span id="section">{{$section}}</span>
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
						<div class="caption">{{ lang('partners_immediate.personal_contact') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
                	<?php foreach($profile_telephones as $telephone){ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="phone"><?=$telephone?></span>
									</div>
								</div>
							</div>
						</div>
                	<?php } ?>
                    <?php foreach($profile_mobiles as $mobile){ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname"><?=$mobile?></span>
									</div>
								</div>
							</div>
						</div>
                	<?php } ?>						
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.email') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$profile_email}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.address') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$complete_address}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.city') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$profile_live_in}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.zip') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="lastname">{{$zip_code}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Company Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.emergency_contact') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.name') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-name">{{$emergency_name}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.relationship') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-relationship">{{$emergency_relationship}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-phone">{{$emergency_phone}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-mobile">{{$emergency_mobile}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.address') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-address">{{$emergency_address}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.city') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-city">{{$emergency_city}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.country') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-country">{{$emergency_country}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.zip') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="emergency-zipcode">{{$emergency_zip_code}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="overview_tab3">
				<!-- Personal Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.personal') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.gender') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="gender">{{$gender}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.bday') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="birthday">{{$profile_birthdate}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.birthplace') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="place-of-birth">{{$birth_place}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.religion') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="religion">{{$religion}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.nationality') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="nationality">{{$nationality}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.civil_status') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status">{{$profile_civil_status}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.solo_parent') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="civil-status">{{$personal_solo_parent}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Other Personal Information -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ lang('partners_immediate.other_info') }}</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.height') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="height">{{$height}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.weight') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="weight">{{$weight}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.hobby') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="interest-hobbies">{{$interests_hobbies}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.languages') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="language-known">{{$language}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.dialects') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="dialect-known">{{$dialect}}</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.no_dependents') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="no-of-dependents">{{$dependents_count}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane " id="overview_tab14">
				@if(sizeof($family_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="family-relationship[1]" class="caption">{{ lang('partners_immediate.family') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('Common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners_immediate.no_info_fam') }}</p></span>
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
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.name') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-name[1]"><?php echo array_key_exists('family-name', $family) ? $family['family-name'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.bday') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-birthdate[1]"><?php echo array_key_exists('family-birthdate', $family) ? $family['family-birthdate'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners_immediate.age') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="family-year-to[1]"><?php echo $family_age; ?></span>
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
