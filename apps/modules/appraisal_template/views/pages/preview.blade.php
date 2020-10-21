@extends('layouts/master')

@section('page_styles')
	@parent
		@include('preview/style') 
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-12">
			<form class="form-horizontal" id="planning-form">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('preview/fgs')
			</form>
       	</div>  		
	</div>
@stop

@section('page_plugins')
	@parent
@stop

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script>
		$(document).ready(function(){
			get_section_items_previews();
		});
		function get_section_items_previews()
		{
			$('tbody.get-section').each(function(){
				var section_id = $(this).attr('section');
				get_section_items_preview(section_id);
			});
		}

		function get_section_items_preview( section_id )
		{
			$('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+base_url+'assets/img/ajax-loading.gif" />',
				onBlock: function(){
					var data = {
						section_id: section_id
					};

					$.ajax({
						url: base_url + module.get('route') + '/get_section_items_preview',
						type:"POST",
						data: data,
						dataType: "json",
						async: false,
						success: function ( response ) {
							handle_ajax_message( response.message );
							$('tbody.section-'+section_id + ' tr:not(.first-row)').each(function(){
								$(this).remove();
							});
							$('tbody.section-'+section_id).prepend( response.items );
						}
					});
				},
				baseZ: 300000000
			});
			$('tbody.section-'+section_id).unblock();	
		}
	</script>
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop