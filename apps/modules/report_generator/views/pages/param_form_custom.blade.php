@include('edit/page_styles')
	<div class="portlet">
		<div class="portlet-body form">
			<form class="form-horizontal">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('generate/param_form')
				@include('buttons/param_form_custom')
			</form>
       	</div>  		
	</div>
@include('edit/page_plugins')
@include('edit/page_scripts') 
<script type="text/javascript" src="{{ theme_path() }}modules/report_generator/generate.js"></script> 
