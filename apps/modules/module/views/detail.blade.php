@extends('layouts/master');

@section('page_content')
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet">
		<div class="portlet-title">
			<div class="caption"><i class="fa {{ $mod->icon }}"></i>{{ $mod->short_name }} Detail</div>
		</div>
		
		<div class="tabbable-custom ">
	    	@include('tabs')
	    	@include('detail_fgs')
	    </div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop