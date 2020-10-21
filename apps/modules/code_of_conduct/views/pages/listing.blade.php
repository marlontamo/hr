@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<!-- FORM -->
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-body form">
                <form action="#" class="form-horizontal">
                    <div class="form-body" style="padding-bottom:0px;">

                    	<div class="note note-default">

		                    <h3 class="page-title">
		                    {{ lang('code_of_conduct.process') }} : <small>  {{ lang('code_of_conduct.action_protocols') }}</small>
		                    </h3>
		                    <p class="small">Code of Conduct Process</p>

		                    <hr />

							<div class="clearfix margin-bottom-25">
								<label class="col-md-9"><h4>{{ lang('code_of_conduct.ir') }}</h4>
									<p class="small"></p>

								</label>
								<div class="col-md-3 padding-top-10">
									<a class="btn btn-default" type="button" rel="{{ get_mod_route('incident_report') }}" href="{{ get_mod_route('incident_report') }}">{{ lang('common.view_list_button') }}</a>
								</div>
							</div>

							<div class="clearfix margin-bottom-25">
								<label class="col-md-9"><h4>{{ lang('code_of_conduct.nte') }}</h4>
									<p class="small"></p>

								</label>
								<div class="col-md-3 padding-top-10">
									<a class="btn btn-default" type="button" rel="{{ get_mod_route('nte') }}" href="{{ get_mod_route('nte') }}">{{ lang('common.view_list_button') }}</a>
									<!-- <a class="btn btn-success" type="button" href="clinic_records_add.php">Create</a> -->
								</div>
							</div>

							<div class="clearfix margin-bottom-25">
								<label class="col-md-9"><h4>{{ lang('code_of_conduct.hs') }}</h4>
									<p class="small"></p>

								</label>
								<div class="col-md-3 padding-top-10">
									<a class="btn btn-default" type="button" rel="{{ get_mod_route('hearing') }}" href="{{ get_mod_route('hearing') }}">{{ lang('common.view_list_button') }}</a>
									<!-- <a class="btn btn-success" type="button" href="clinic_records_add.php">Create</a> -->
								</div>
							</div>

							<div class="clearfix margin-bottom-25">
								<label class="col-md-9"><h4>{{ lang('code_of_conduct.da') }}</h4>
									<p class="small"></p>

								</label>
								<div class="col-md-3 padding-top-10">
									<a class="btn btn-default" type="button" rel="{{ get_mod_route('disciplinary') }}" href="{{ get_mod_route('disciplinary') }}">{{ lang('common.view_list_button') }}</a>
								</div>
							</div>
						</div>
					</div>
                </form>
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
