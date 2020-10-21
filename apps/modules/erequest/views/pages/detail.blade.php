@extends('layouts/master')

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-9">
			<!-- <form class="form-horizontal"> -->
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('detail/fgs')
				@include('buttons/detail')
			<!-- </form> -->
       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
					@include('common/discussion')
					<!-- <div class="actions margin-top-20 clearfix">
						<span class="pull-left"><a class="text-muted" href="{{ $mod->url }}">Back to List &nbsp;<i class="m-icon-swapright"></i></a></span>
						<span class="pull-right"><a class="text-muted" id="trash">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div> -->
				</div>
			</div>
		</div>		
	</div>
@stop