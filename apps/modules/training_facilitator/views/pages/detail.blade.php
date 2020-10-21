@extends('layouts/master')

@section('page_styles')
	@parent
	@include('detail/page_styles')
@stop

@section('page_content')
	@parent
    
    <div class="row">
        <div class="col-md-11">
            <form class="form-horizontal">
                <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
                @include('detail/fgs')
                @include('buttons/detail')
            </form>
        </div>  
            
    </div>


@stop


@section('page_plugins')
	@parent
	@include('detail/page_plugins')
@stop


@section('page_scripts')
	@parent

	@include('detail/page_scripts')

@stop


@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
	

@stop
