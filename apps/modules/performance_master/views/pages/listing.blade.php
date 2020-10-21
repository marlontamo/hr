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
				                    {{ lang('performance.layout') }}: <small> {{ lang('performance.layout_sub') }}</small>
				                    </h3>
				                    <p class="small">{{ lang('performance.layout_desc') }}</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.template')}}</h4>
											<div class="text-muted small">{{ lang('performance.template_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('appraisal_template') }}" href="{{ get_mod_route('appraisal_template') }}">{{ lang('performance.view_list_button') }}</a>
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
				                    {{ lang('performance.resources') }}: <small> {{ lang('performance.resources_sub') }}</small>
				                    </h3>
				                    <p class="small">{{ lang('performance.resources_desc') }}</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.template')}}</h4>
											<div class="text-muted small">{{ lang('performance.template_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('appraisal_template') }}" href="{{ get_mod_route('appraisal_template') }}">{{ lang('performance.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.balance_scorecard')}}</h4>
											<div class="text-muted small">{{ lang('performance.balance_scorecard_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('scorecard') }}" href="{{ get_mod_route('scorecard') }}">{{ lang('performance.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.library_comp')}}</h4>
											<div class="text-muted small">{{ lang('performance.library_comp_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('library') }}" href="{{ get_mod_route('library') }}">{{ lang('performance.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.rating_scale_group')}}</h4>
											<div class="text-muted small">{{ lang('performance.rating_scale_group_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('rating_group') }}" href="{{ get_mod_route('rating_group') }}">{{ lang('performance.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.performance_type')}}</h4>
											<div class="text-muted small">{{ lang('performance.performance_type_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('performance') }}" href="{{ get_mod_route('performance') }}">{{ lang('performance.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('performance.portlet_notif')}}</h4>
											<div class="text-muted small">{{ lang('performance.portlet_notif_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('performance_notification') }}" href="{{ get_mod_route('performance_notification') }}">{{ lang('performance.view_list_button') }}</a>
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
