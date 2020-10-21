@section('page_styles')
	@include('edit/page_styles')
@show

@section('page_content')
	<form class="form-horizontal">
		<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
		<div class="modal-body padding-bottom-0">
			@include('detail/fgs')
		</div>
		<div class="modal-footer margin-top-0">
			<button class="btn btn-default btn-sm" type="button" data-dismiss="modal"> {{ lang('common.close') }}</button>
		</div>
	</form>
@show

@section('page_plugins')
	@include('edit/page_plugins')
@show

@section('page_scripts')
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@show

@section('view_js')
	{{ get_edit_js( $mod ) }}
@show