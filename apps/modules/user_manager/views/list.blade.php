@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<div class="col-md-11">
		<!-- BEGIN FORM-->
		<div class="row">
			<!-- FORM -->
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                            	<div class="note note-default">

				                    <h3 class="page-title">
				                    {{ lang('user_manager.profiles') }}: <small> {{ lang('user_manager.list') }}</small>
				                    </h3>
				                    <p class="small">{{ lang('user_manager.p_profiles') }}</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.users')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_users')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('users') }}" href="{{ get_mod_route('users') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
                        </form>
					</div>
				</div>

				<div class="portlet">
					<div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                            	<div class="note note-default">

				                    <h3 class="page-title">
				                    {{ lang('user_manager.resources') }}: <small> {{ lang('user_manager.set_con') }}</small>
				                    </h3>
				                    <p class="small">{{ lang('user_manager.p_set_con') }}</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.company')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_company')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('company') }}" href="{{ get_mod_route('company') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<?php if (isset($permission['division']) && $permission['division']['list'] == 1) { ?>
									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.division')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_division')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('division') }}" href="{{ get_mod_route('division') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>
									<?php } ?>
									
									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.department')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_department')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('department') }}" href="{{ get_mod_route('department') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>
									
									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.branch')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.branch')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('branch') }}" href="{{ get_mod_route('branch') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.section')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_section')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('section') }}" href="{{ get_mod_route('section') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.project')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.project')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('project') }}" href="{{ get_mod_route('project') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.group')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_group')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('group') }}" href="{{ get_mod_route('group') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.job_title')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_job_title')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('job_title') }}" href="{{ get_mod_route('job_title') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.position')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_position')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('position') }}" href="{{ get_mod_route('position') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.emp_stat')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_emp_stat')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('employment_status') }}" href="{{ get_mod_route('employment_status') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.emp_type')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_emp_type')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('employment_type') }}" href="{{ get_mod_route('employment_type') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.location')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_location')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('location') }}" href="{{ get_mod_route('location') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('user_manager.assignment')}}</h4>
											<div class="text-muted small">{{ lang('user_manager.p_assignment')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('assignment') }}" href="{{ get_mod_route('assignment') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>


                                  
								</div>
							</div>
                        </form>
					</div>
				</div>
			</div>
		</div>
        <!-- END FORM-->
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
