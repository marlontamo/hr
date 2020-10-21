@section('page_styles')
	@include('edit/page_styles')
@show

@section('page_content')
	<form id="form-period-options" class="form-horizontal">
		<!-- <input type="hidden" name="year_month" id="year_month" value="{{ $record_id }}"> -->
		<div class="modal-body padding-bottom-0">
			@include('edit/fgs')
		</div>
		<!-- <div class="modal-footer margin-top-0">
			@include('buttons/quick_edit')
		</div> -->
	</form>
@show

@section('page_plugins')
	@include('edit/page_plugins')
@show

@section('page_scripts')
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/sbr/edit.js"></script> 
@show

@section('view_js')
	{{ get_edit_js( $mod ) }}
@show