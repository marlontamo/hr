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
				                    Resources: <small> Setup and Configurations</small>
				                    </h3>
				                    <p class="small">List and definitions of related master tables needed in the application.</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.holiday')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.holiday_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('holiday') }}" href="{{ get_mod_route('holiday') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.shift_sched')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.shift_sched_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('shift') }}" href="{{ get_mod_route('shift') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.late_exemption')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.late_exemption')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('late_exemption') }}" href="{{ get_mod_route('late_exemption') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>									

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.weekly_shift_sched')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.weekly_shift_sched_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('weeklyshift') }}" href="{{ get_mod_route('weeklyshift') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.time_form_policy')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.time_form_policy_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('form_policy') }}" href="{{ get_mod_route('form_policy') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.leave_policy')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.leave_policy_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('leave_setup_policy') }}" href="{{ get_mod_route('leave_setup_policy') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.coordinator')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.coordinator_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('coordinator') }}" href="{{ get_mod_route('coordinator') }}">{{ lang('time_reference.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('time_reference.habitual_tardiness')}}</h4>
											<div class="text-muted small">{{ lang('time_reference.habitual_tardiness_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('habitual_tardiness_configuration') }}" href="{{ get_mod_route('habitual_tardiness_configuration') }}">{{ lang('time_reference.setup') }}</a>
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
