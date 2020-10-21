	<div class="row">
		<div class="col-md-3" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#historical_tab1"><i class="fa fa-list"></i>{{ lang('partners.education') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#historical_tab2"><i class="fa fa-list"></i>{{ lang('partners.employment_history') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab3"><i class="fa fa-list"></i>{{ lang('partners.character_ref') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab4"><i class="fa fa-list"></i>{{ lang('partners.licensure') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab5"><i class="fa fa-list"></i>{{ lang('partners.training') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab6"><i class="fa fa-list"></i>{{ lang('partners.skills') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab7"><i class="fa fa-list"></i>{{ lang('partners.affiliation') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab8"><i class="fa fa-list"></i>{{ lang('partners.accountabilities') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab9"><i class="fa fa-files-o"></i>{{ lang('partners.attachment') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab17"><i class="fa fa-list"></i>{{ lang('partners.movement') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab18"><i class="fa fa-list"></i>{{ lang('partners.da') }}</a></li>
			</ul>
		</div>

		<div class="tab-content col-md-9">
			<div class="tab-pane active" id="historical_tab1">
				@if(sizeof($education_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.education') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners.no_info_educ') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Education : start doing the loop-->
				<?php foreach($education_tab as $index => $education){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="education-type[1]"><?php 
						$education_type = array_key_exists('education-type', $education) ? $education['education-type'] : "";
						echo $education_type; ?>
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
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.school') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="education-school[1]"><?php echo array_key_exists('education-school', $education) ? $education['education-school'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.from') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="education-year-from[1]"><?php echo array_key_exists('education-year-from', $education) ? $education['education-year-from'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.to') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="education-year-to[1]"><?php echo array_key_exists('education-year-to', $education) ? $education['education-year-to'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
			            <?php 
    $type_with_degree = array('tertiary', 'graduate studies', 'vocational');
			            if(in_array(strtolower($education_type), $type_with_degree)) { 
			                ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.degree') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="education-degree[1]"><?php echo array_key_exists('education-degree', $education) ? $education['education-degree'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('common.status') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="education-status[1]"><?php echo array_key_exists('education-status', $education) ? $education['education-status'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab2">
				@if(sizeof($employment_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.employment_history') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners.no_info_emp_his') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Employment : start doing the loop-->
				<?php foreach($employment_tab as $index => $employment){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="employment-company[1]"><?php echo array_key_exists('employment-company', $employment) ? $employment['employment-company'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.pos_title') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-position-title[1]"><?php echo array_key_exists('employment-position-title', $employment) ? $employment['employment-position-title'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.location') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-location[1]"><?php echo array_key_exists('employment-location', $employment) ? $employment['employment-location'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.hire_date') }}:</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-date-hired[1]">
											<?php echo array_key_exists('employment-month-hired', $employment) ? $employment['employment-month-hired'] : ""; ?>
											<?php echo array_key_exists('employment-year-hired', $employment) ? $employment['employment-year-hired'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.end_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-end-date[1]">
											<?php echo array_key_exists('employment-month-end', $employment) ? $employment['employment-month-end'] : ""; ?>
											<?php echo array_key_exists('employment-year-end', $employment) ? $employment['employment-year-end'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.duties') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="employment-duties[1]"><?php echo array_key_exists('employment-duties', $employment) ? nl2br($employment['employment-duties']) : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab3">
				@if(sizeof($reference_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.character_ref') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners.no_info_ref') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Character reference : start doing the loop-->
				<?php foreach($reference_tab as $index => $reference){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="reference-name[1]"><?php echo array_key_exists('reference-name', $reference) ? $reference['reference-name'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.occupation') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-occupation[1]"><?php echo array_key_exists('reference-occupation', $reference) ? $reference['reference-occupation'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.years_known') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-years-known[1]"><?php echo array_key_exists('reference-years-known', $reference) ? $reference['reference-years-known'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.phone') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-phone[1]"><?php echo array_key_exists('reference-phone', $reference) ? $reference['reference-phone'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.mobile') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-mobile[1]"><?php echo array_key_exists('reference-mobile', $reference) ? $reference['reference-mobile'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.address') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-address[1]"><?php echo array_key_exists('reference-address', $reference) ? $reference['reference-address'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.city') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-city[1]"><?php echo array_key_exists('reference-city', $reference) ? $reference['reference-city'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.country') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-country[1]"><?php echo array_key_exists('reference-country', $reference) ? $reference['reference-country'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.zip') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="reference-zipcode[1]"><?php echo array_key_exists('reference-zipcode', $reference) ? $reference['reference-zipcode'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab4">
				@if(sizeof($licensure_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.licensure') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners.no_info_license') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Licensure : start doing the loop-->
				<?php foreach($licensure_tab as $index => $licensure){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="licensure-title[1]"><?php echo array_key_exists('licensure-title', $licensure) ? $licensure['licensure-title'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.license_no') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="licensure-number[1]"><?php echo array_key_exists('licensure-number', $licensure) ? $licensure['licensure-number'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.date_taken') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="licensure-date-taken[1]">
											<?php echo array_key_exists('licensure-month-taken', $licensure) ? $licensure['licensure-month-taken'] : ""; ?>
											<?php echo array_key_exists('licensure-year-taken', $licensure) ? $licensure['licensure-year-taken'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('common.remarks') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="licensure-remarks[1]"><?php echo array_key_exists('licensure-remarks', $licensure) ? nl2br($licensure['licensure-remarks']) : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab5">
				@if(sizeof($training_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.training') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0"> {{ lang('partners.no_info_training') }} </p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Trainings : start doing the loop-->
				<?php foreach($training_tab as $index => $training){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="training-title[1]"><?php echo array_key_exists('training-title', $training) ? $training['training-title'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.category') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="training-category[1]"><?php echo array_key_exists('training-category', $training) ? $training['training-category'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.venue') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="training-venue[1]"><?php echo array_key_exists('training-venue', $training) ? $training['training-venue'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.start_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="training-start-month[1]">
											<?php echo array_key_exists('training-start-month', $training) ? $training['training-start-month'] : ""; ?>
											<?php echo array_key_exists('training-start-year', $training) ? $training['training-start-year'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.end_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="training-end-month[1]">
											<?php echo array_key_exists('training-end-month', $training) ? $training['training-end-month'] : ""; ?>
											<?php echo array_key_exists('training-end-year', $training) ? $training['training-end-year'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.remarks') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="training-end-month[1]">
											<?php echo array_key_exists('training-remarks', $training) ? $training['training-remarks'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab6">
				@if(sizeof($skill_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.skills') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0">{{ lang('partners.no_info_skill') }}</p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Trainings : start doing the loop-->
				<?php foreach($skill_tab as $index => $skill){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="skill-name[1]"><?php echo array_key_exists('skill-name', $skill) ? $skill['skill-name'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.skills_type') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="skill-type[1]"><?php echo array_key_exists('skill-type', $skill) ? $skill['skill-type'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.proficiency_level') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="skill-level[1]"><?php echo array_key_exists('skill-level', $skill) ? $skill['skill-level'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('common.remarks') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="skill-remarks[1]"><?php echo array_key_exists('skill-remarks', $skill) ? nl2br($skill['skill-remarks']) : ""; ?></span>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab7">
				@if(sizeof($affiliation_tab) == 0)
					<div class="portlet">
						<div class="portlet-title">
							<div id="employment-company[1]" class="caption">{{ lang('partners.affiliation') }}</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- START FORM -->
							<div id="no_record" class="well" style="">
								<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }} </p>
								<span><p class="small margin-bottom-0"> {{ lang('partners.no_info_affi') }} </p></span>
							</div>
						</div>
					</div>
				@endif
				<!-- Previous Trainings : start doing the loop-->
				<?php foreach($affiliation_tab as $index => $affiliation){ 
					?>
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption" id="affiliation-name[1]"><?php echo array_key_exists('affiliation-name', $affiliation) ? $affiliation['affiliation-name'] : ""; ?></div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.position') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="affiliation-position[1]"><?php echo array_key_exists('affiliation-position', $affiliation) ? $affiliation['affiliation-position'] : ""; ?></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.start_date') }} :</label>
									<div class="col-md-7 col-sm-7">
										<span id="affiliation-date-start[1]">
											<?php echo array_key_exists('affiliation-month-start', $affiliation) ? $affiliation['affiliation-month-start'] : ""; ?>											
											<?php echo array_key_exists('affiliation-year-start', $affiliation) ? $affiliation['affiliation-year-start'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 text-right text-muted">{{ lang('partners.end_date') }} :</label>
									<div class="col-md-7 col-sm-7">
											<?php echo array_key_exists('affiliation-month-end', $affiliation) ? $affiliation['affiliation-month-end'] : ""; ?>											
											<?php echo array_key_exists('affiliation-year-end', $affiliation) ? $affiliation['affiliation-year-end'] : ""; ?>
										</span>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?php } ?>
			</div>
			<div class="tab-pane" id="historical_tab8">
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('partners.accountabilities') }}</div>
                    </div>
                    <div class="portlet-body">
						<!-- Table -->
						<table class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									
									<th width="30%">{{ lang('partners.item_name') }}</th>
									<th width="45%" class="hidden-xs">{{ lang('partners.qty') }}</th>
									<th width="20%">{{ lang('common.actions') }}</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($accountabilities_tab as $index => $accountable){ 
								?>
								<tr rel="0">
									<!-- this first column shows the year of this holiday item -->
									
									<td>
										<a id="date_name" href="#" class="text-success">
											<?php echo array_key_exists('accountabilities-name', $accountable) ? $accountable['accountabilities-name'] : ""; ?>	
										</a>
										<br />
										<span id="date_set" class="small ">
											<?php echo array_key_exists('accountabilities-code', $accountable) ? $accountable['accountabilities-code'] : ""; ?>	
										</span>
									</td>
									<td class="hidden-xs">
											<?php echo array_key_exists('accountabilities-quantity', $accountable) ? $accountable['accountabilities-quantity']." pcs" : ""; ?>
									</td>
									<td>
										<div class="btn-group">
											<input type="hidden" id="accountabilities_sequence" name="accountabilities_sequence" value="<?=$index?>" />
											<a  href="javascript:view_personal_details('accnt_form_modal', 'accountabilities', <?=$index?>);" ><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
											
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                </div>
                <!--end portlet-->
			</div>

			<div class="tab-pane" id="historical_tab9">
				<!--Attachments--> 
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('partners.attachment') }}</div>
                    </div>
                    <div class="portlet-body">
						<!-- Table -->
						<table class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									
									<th width="30%">{{ lang('partners.name') }}</th>
									<th width="45%" class="hidden-xs">{{ lang('partners.filename') }}</th>
									<th width="20%">{{ lang('common.actions') }}</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($attachment_tab as $index => $attachment){ 
								?>
								<tr rel="0">
									
									<td>
										<a id="date_name" href="#" class="text-success">
											<?php echo array_key_exists('attachment-name', $attachment) ? $attachment['attachment-name'] : ""; ?>	
										</a>
										<br />
										<span id="date_set" class="small text-muted">
											<?php echo array_key_exists('attachment-category', $attachment) ? $attachment['attachment-category'] : ""; ?>	
										</span>
									</td>
									<td class="hidden-xs">
											<?php echo array_key_exists('attachment-file', $attachment) ? substr( $attachment['attachment-file'], strrpos( $attachment['attachment-file'], '/' )+1 ) : ""; ?>	
									</td>
									<td>
										<div class="btn-group">
											<input type="hidden" id="attachment_sequence" name="attachment_sequence" value="<?=$index?>" />
											<a  href="javascript:view_personal_details('attach_form_modal', 'attachment', <?=$index?>);" ><i class="fa fa-search"></i> View</a>									
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                </div>
                <!--end portlet-->
			</div>

			<div class="tab-pane" id="historical_tab17">
				<!--Attachments--> 
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('partners.movement') }}</div>
                    </div>
                    <div class="portlet-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<!-- <th width="1%"><input type="checkbox" class="group-checkable" data-set=".record-checker" /></th> -->
							<th width="30%">Movement Type</th>
							<th width="25%" class="hidden-xs">Due To</th>
							<th width="25%" class="hidden-xs">{{ lang('common.remarks') }}</th>
							<th width="25%" class="hidden-xs">Effective Date</th>
							<th width="20%">{{ lang('common.actions') }}</th>
						</tr>
					</thead>
					<tbody id="movement-list">
						<?php 
							foreach($movement_tab as $index => $movement){ 
						?>
						<tr class="record">
							<!-- this first column shows the year of this holiday item -->
							<td>
								<span class="text-success">
								<?php echo $movement['type']; ?>		
								</span>
								<br>
								<span class="text-muted small">
									<?php echo date('F d, Y - H:ia', strtotime($movement['created_on'])); ?>		
								</span>
							</td>
							<td>
								<?php echo $movement['cause']; ?>
							</td>
							<td>{{ $movement['remarks'] }}</td>
							<td class="hidden-xs">
								<?php echo date('F d, Y', strtotime($movement['effectivity_date'])); ?>	
							</td>
							<td>
								<div class="btn-group">
									<a  href="javascript:view_movement_details(<?php echo $movement['action_id'] ?>, <?php echo $movement['type_id'] ?>, '<?php echo $movement['cause'] ?>');" class="btn btn-xs text-muted" ><i class="fa fa-search"></i> {{ lang('common.view') }}</a>		
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
					</div>
                </div>
                <!--end portlet-->
			</div>
			<div class="tab-pane" id="historical_tab18">
				<!--Attachments--> 
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('partners.da') }}</div>
                    </div>
                    <div class="portlet-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<!-- <th width="1%"><input type="checkbox" class="group-checkable" data-set=".record-checker" /></th> -->
							<th width="30%">Type of Offense</th>
							<th width="25%">No of Offense</th>
							<th width="25%">Level</th>
							<th width="25%">Penalty</th>
							<th width="20%">Date</th>
						</tr>
					</thead>
					<tbody id="movement-list">
						<?php 
							$ctr = 1;
							foreach($da_tab as $index => $da){ 
						?>
						<tr class="record">
							<!-- this first column shows the year of this holiday item -->
							<td>
								<?php echo $da['offense']; ?>
							</td>
							<td>
								<?php echo $ctr ?>
							</td>
							<td><?php echo $da['offense_level']; ?></td>
							<td>
								<?php echo $da['sanction']; ?>	
							</td>
							<td>
								<?php echo date('F d, Y', strtotime($da['created_on'])); ?>
							</td>
						</tr>
						<?php $ctr++; } ?>
					</tbody>
				</table>
					</div>
                </div>
                <!--end portlet-->
			</div>
		</div>
	</div>
