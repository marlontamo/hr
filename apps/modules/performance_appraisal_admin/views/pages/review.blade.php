@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
	@include('review/page_styles')
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-12">
			<form class="form-horizontal" id="planning-form">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('review/fgs')
			</form>
       	</div>  		
	</div>
@stop

@section('page_plugins')
	@parent
	@include('edit/page_plugins')
	@include('review/page_plugins')
@stop

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	@include('review/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/review.js"></script> 
	<script>
	<?php if(isset($back_url_admin)){ ?>
		$("#back_button").attr("href", "<?php echo $back_url_admin ?>");
		$("a.back_button_gray").attr("href", "<?php echo $back_url_admin ?>");
	<?php } ?>
	</script>
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop