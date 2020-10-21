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
		<div class="form-horizontal" >
			<div class="form-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 text-right">{{ lang('my201.company') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
								<span class="input-group-addon">
	                            	<i class="fa fa-list-ul"></i>
		                        </span>
		                        <input type="text" disabled class="form-control" value="{{ $profile_company }}" >
		                    </div>
		                </div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.location') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" value="{{ $location }}" >
		                    </div>
		                </div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.position') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" value="{{ $position }}" >
		                    </div>
		                </div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.id_no') }} </label>
						<div class="col-md-5">
		                     <input type="text" disabled class="form-control" id="id-number" value="{{ $id_number }}" >
		                </div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.biometric') }} </label>
						<div class="col-md-5">
		                     <input type="text" disabled class="form-control" id="ibiometric" value="{{ $biometric }}" >
		                </div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.work_sched') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" id="shift" value="{{ $shift }}" >
		                    </div>
		                </div>
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
		<div class="form-horizontal" >
			<div class="form-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.status') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" id="employment-status" value="{{ $status }}" >
		                    </div>
		                </div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.type') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" id="employment-type" value="{{ $type }}" >
		                    </div>
		                </div>
					</div>
				</div>
				@if( in_array('job_class', $partners_keys ))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.jobClass') }} </label>
							<div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="shift" value="{{ $job_class }}" >
			                    </div>
			                </div>
			
						</div>
					</div>
				@endif

		        @if( in_array( 'job_rank_level', $partners_keys ))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.job_rank_level') }} </label>
		                    <div class="col-md-5">
			                    	<div class="input-group">
			                    		<span class="input-group-addon">
				                            <i class="fa fa-list-ul"></i>
				                        </span>
				                     <input type="text" disabled class="form-control" id="shift" value="{{ $record['job_rank_level'] }}" >
				                    </div>
				                </div>
		                </div>
		            </div>
		        @endif
        
		        @if( in_array( 'job_level', $partners_keys ))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.job_level') }} </label>
		                    <div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="shift" value="{{ $record['job_level'] }}" >
			                    </div>
			                </div>
		                </div>
		            </div>
		        @endif

		        @if( in_array( 'pay_level', $partners_keys ))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.pay_level') }} </label>
		                    <div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="pay_level" value="{{ $record['pay_level'] }}" >
			                    </div>
			                </div>
		                </div>
		            </div>
		        @endif
		        @if( in_array( 'pay_set_rates', $partners_keys ))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.pay_set_rates') }} </label>
		                    <div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="pay_set_rates" value="{{ $record['pay_set_rates'] }}" >
			                    </div>
			                </div>
		                </div>
		            </div>
		        @endif

		        @if( in_array( 'competency_level', $partners_keys ))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.competency_level') }} </label>
		                    <div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="competency_level" value="{{ $record['competency_level'] }}" >
			                    </div>
			                </div>
		                </div>
		            </div>
		        @endif

				@if( in_array( 'employee_grade', $partners_keys ))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.employee_grade') }} </label>
							<div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="employee_grade" value="{{ $record['employee_grade'] }}" >
			                    </div>
			                </div>
						</div>
					</div>
				@endif

				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.hire_date') }} </label>
						<div class="col-md-5">
	                   		<div class="input-group input-medium ">
									<input type="text" class="form-control" id="partners-effectivity_date" value="{{ $date_hired }}" disabled >
	                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
	                        </div>
	                    </div>
					</div>
				</div>

				@if(in_array('probationary_date', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ $partners_labels['probationary_date'] }} </label>
							<div class="col-md-5">
		                   		<div class="input-group input-medium ">
										<input type="text" class="form-control" id="partners-probationary_date" value="{{ $probationary_date }}" disabled >
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
		            		<span class="text-muted small">End date of employment/contract service</span>
							</div>
						</div>
					</div>
		    	@endif

		        @if(in_array('original_date_hired', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.ohire_date') }} </label>
							<div class="col-md-5">
		                   		<div class="input-group input-medium ">
										<input type="text" class="form-control" id="partners-original_date_hired" value="{{ $original_date_hired }}" disabled >
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
							</div>
						</div>
					</div>
		    	@endif

		        @if(in_array('last_probationary', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.last_probi') }} </label>
							<div class="col-md-5">
		                   		<div class="input-group input-medium ">
										<input type="text" class="form-control" id="partners-last_probationary" value="{{ $last_probationary }}" disabled >
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
							</div>
						</div>
					</div>
		        @endif

		        @if(in_array('last_salary_adjustment', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.last_sa') }} </label>
							<div class="col-md-5">
		                   		<div class="input-group input-medium ">
										<input type="text" class="form-control" id="partners-last_salary_adjustment" value="{{ $last_salary_adjustment }}" disabled >
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
							</div>
						</div>
					</div>
		        @endif
			</div>
		</div>
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
		<div class="form-horizontal" >
			<div class="form-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.reports_to') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" id="reports_to" value="{{ $reports_to }}" >
		                    </div>
		                </div>
					</div>
				</div>
		        @if(in_array('organization', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ lang('my201.org') }} </label>
							<div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" {{ $is_editable['organization'] == 1 ? '' : 'disabled' }} class="form-control" id="organization" value="{{ $organization }}" >
			                    </div>
			                </div>
						</div>
					</div>
		        @endif
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3">{{ lang('my201.div') }} </label>
						<div class="col-md-5">
	                    	<div class="input-group">
	                    		<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                        </span>
		                     <input type="text" disabled class="form-control" id="division" value="{{ $division }}" >
		                    </div>
		                </div>
					</div>
				</div>
		        @if(in_array('agency_assignment', $partners_keys))
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label class="control-label col-md-3 col-sm-3">{{ lang('my201.agency_assignment') }} </label>
		                    <div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" disabled class="form-control" id="agency_assignment" value="{{ $agency_assignment }}" >
			                    </div>
			                </div>
		                </div>
		            </div>
		        @endif
				@if(in_array('section', $partners_keys))
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3">{{ $partners_labels['section']}} </label>
							<div class="col-md-5">
		                    	<div class="input-group">
		                    		<span class="input-group-addon">
			                            <i class="fa fa-list-ul"></i>
			                        </span>
			                     <input type="text" {{ $is_editable['section'] == 1 ? '' : 'disabled' }} class="form-control" id="section" value="{{ $record['section'] or '' }}" >
			                    </div>
			                </div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>