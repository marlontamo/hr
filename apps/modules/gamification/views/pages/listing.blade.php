@extends('layouts.master')

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">

		<div class="col-md-11">
			<div class="portlet">
				<div class="portlet-body form">
                    <form action="#" class="form-horizontal">
                        <div class="form-body" style="padding-bottom:0px;">

                        	<div class="note note-default">

			                    <h2>
			                    <span class="module-title">Setup: </span><span class="module-caption"> Settings and Modifications</span>
			                    </h2>
			                    <p class="small">Define the necessary configurations.</p>

			                    <hr class="margin-bottom-25" />

			                    <div class="clearfix margin-bottom-25">
									<label class="col-md-9"><h4><span class="sub-title">Leagues</span></h4>
										<p class="small">Grouping of all defined levels.</p>

									</label>
									<div class="col-md-3 padding-top-10">
										<a class="btn btn-default" type="button" rel="{{ get_mod_route('league') }}" href="{{ get_mod_route('league') }}">View</a>
										<a class="btn btn-success" type="button" rel="{{ get_mod_route('league', 'add') }}" href="{{ get_mod_route('league', 'add') }}">Create</a>
										<!-- <a class="btn btn-default" type="button" href="#">View</a>
										<a class="btn btn-success" type="button" href="#">Create</a> -->
									</div>
								</div>

			                    <div class="clearfix margin-bottom-25">
									<label class="col-md-9"><h4><span class="sub-title">Levels</span></h4>
										<p class="small">Defining of points in a given level.</p>

									</label>
									<div class="col-md-3 padding-top-10">
										<a class="btn btn-default" type="button" rel="{{ get_mod_route('level') }}" href="{{ get_mod_route('level') }}">View</a>
										<a class="btn btn-success" type="button" rel="{{ get_mod_route('level', 'add') }}" href="{{ get_mod_route('level', 'add') }}">Create</a>
										<!-- <a class="btn btn-default" type="button" href="#">View</a>
										<a class="btn btn-success" type="button" href="#">Create</a> -->
									</div>
								</div>

			                    <div class="clearfix margin-bottom-25">
									<label class="col-md-9"><h4><span class="sub-title">Badges</span></h4>
										<p class="small">Upload badges to represent each recognition.</p>

									</label>
									<div class="col-md-3 padding-top-10">
										<a class="btn btn-default" type="button" rel="{{ get_mod_route('badges') }}" href="{{ get_mod_route('badges') }}">View</a>
										<a class="btn btn-success" type="button" rel="{{ get_mod_route('badges', 'add') }}" href="{{ get_mod_route('badges', 'add') }}">Create</a>
										<!-- <a class="btn btn-default" type="button" href="#">View</a>
										<a class="btn btn-success" type="button" href="#">Create</a> -->
									</div>
								</div>
								<div class="clearfix margin-bottom-25">
									<label class="col-md-9"><h4><span class="sub-title">Redemption</span></h4>
										<p class="small">Upload and define items for partners redeeming.</p>

									</label>
									<div class="col-md-3 padding-top-10">
										<a class="btn btn-default" type="button" rel="{{ get_mod_route('redemption') }}" href="{{ get_mod_route('redemption') }}">View</a>
										<a class="btn btn-success" type="button" rel="{{ get_mod_route('redemption', 'add') }}" href="{{ get_mod_route('redemption', 'add') }}">Create</a>
									</div>
								</div>
							</div>

						</div>
                    </form>
				</div>
			</div>
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
