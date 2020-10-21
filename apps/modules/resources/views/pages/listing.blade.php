@extends('layouts.master')

@section('page_content')
@parent
<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>

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
				                    {{ lang('resources.ref') }}:<small>  Manage and Listing</small>
				                    </h3>
				                    <p class="small">This section manages and listings of employees' HR requests and company related documents.</p>

				                    <hr/>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('resources.online_req')}}</h4>
											<div class="text-muted small">{{ lang('resources.online_req_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('erequest') }}" href="{{ get_mod_route('erequest') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('resources.pol_proc')}}</h4>
											<div class="text-muted small">{{ lang('resources.pol_proc_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" href="{{ get_mod_route('policies_procedures') }}" rel="{{ get_mod_route('policies_procedures') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('resources.down_forms')}}</h4>
											<div class="text-muted small">{{ lang('resources.down_forms_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" href="{{ get_mod_route('formsdownload') }}" rel="{{ get_mod_route('formsdownload') }}">{{ lang('common.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div> 								
									@if( (isset( $all_permission['coe']['list']) && $all_permission['coe']['list']) &&  (isset( $all_permission['coe']['process']) && $all_permission['coe']['process']))
									<div>
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('resources.certificate')}}</h4>
											<div class="text-muted small">{{ lang('resources.certificate_desc')}}</div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<!-- <a class="btn btn-default" type="button" href="{{ get_mod_route('coe') }}" rel="{{ get_mod_route('coe') }}">{{ lang('common.view_list_button') }}</a> -->
											<a class="btn btn-success" type="button" href="javascript:get_param_form()">Generate</a>
										</div>
										<div class="clearfix"></div>
									</div>					
									@endif				
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
<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
