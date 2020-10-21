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
				                    {{ lang('training.resources') }} <small>  {{ lang('training.resources_sub') }}</small>
				                    </h3>
				                    <p class="small">{{ lang('training.resources_desc') }}</p>

				                    <hr />

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_eval_master')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('evaluation_template') }}" href="{{ get_mod_route('evaluation_template') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_bond_sched')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_bond') }}" href="{{ get_mod_route('training_bond') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.level_2_3_tem')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_revalida_master') }}" href="{{ get_mod_route('training_revalida_master') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_type')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_type') }}" href="{{ get_mod_route('training_type') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_cat')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_category') }}" href="{{ get_mod_route('training_category') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_prov')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_provider') }}" href="{{ get_mod_route('training_provider') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_lib')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_library') }}" href="{{ get_mod_route('training_library') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_course')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_course') }}" href="{{ get_mod_route('training_course') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_fac')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_facilitator') }}" href="{{ get_mod_route('training_facilitator') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('training.training_cost')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('training_cost') }}" href="{{ get_mod_route('training_cost') }}">{{ lang('common.view_list_button') }}</a>
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
