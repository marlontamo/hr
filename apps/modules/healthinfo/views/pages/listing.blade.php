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

				                    <h2>
				                    <span class="module-title">{{ lang('healthinfo.records') }}: </span><span class="module-caption">  {{ lang('healthinfo.listing') }}</span>
				                    </h2>
				                    <p class="small">{{ lang('healthinfo.health_info') }}</p>

				                    <hr class="margin-bottom-25" />

									<div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">{{ lang('healthinfo.health_records') }}</span></h4>
											<p class="small">{{ lang('healthinfo.health_desc') }}</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="{{ get_mod_route('healthrecords') }}" rel="{{ get_mod_route('healthrecords') }}">{{ lang('common.view') }}</a>
											<a class="btn btn-success" type="button" href="{{ get_mod_route('healthrecords', 'add') }}" rel="{{ get_mod_route('healthrecords', 'add') }}">{{ lang('common.create') }}</a>
										</div>
									</div>

									<div class="clearfix margin-bottom-25">
										<label class="col-md-9"><h4><span class="sub-title">{{ lang('healthinfo.clinic_records') }}</span></h4>
											<p class="small">{{ lang('healthinfo.clinic_desc') }}</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="{{ get_mod_route('clinicrecords') }}" rel="{{ get_mod_route('clinicrecords') }}">{{ lang('common.view') }}</a>
											<a class="btn btn-success" type="button" href="{{ get_mod_route('clinicrecords', 'add') }}" rel="{{ get_mod_route('clinicrecords', 'add') }}">{{ lang('common.create') }}</a>
										</div>
									</div>

									<div class="clearfix margin-bottom-25 hidden">
										<label class="col-md-9"><h4><span class="sub-title">{{ lang('healthinfo.safe_manhour') }}</span></h4>
											<p class="small">Lorem ipsum tincidunt ut laoreet dolore consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut magna aliquam erat volutpat.</p>

										</label>
										<div class="col-md-3 padding-top-10">
											<a class="btn btn-default" type="button" href="{{ get_mod_route('safemanhour') }}" rel="{{ get_mod_route('safemanhour') }}">{{ lang('common.view') }}</a>
											<a class="btn btn-success" type="button" href="{{ get_mod_route('safemanhour', 'add') }}" rel="{{ get_mod_route('safemanhour', 'add') }}">{{ lang('common.create') }}</a>
										</div>
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
