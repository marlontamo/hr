$(document).ready(function(){
	$('#performance_template-applicable_to_id').change(update_applicable);

	$('#add-section').select2({
	    allowClear: false
	});

	if( $('#record_id').val() != '' )
	{
		$('.hideme').show('fast');
		get_sections();
	}
});

function init_switch()
{
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();
}

function init_section_type_change()
{
	$('select[name="section_type_id"]').die().stop().change(function(){
		if( $(this).val() != "" && $(this).val() == 4 )
		{
			$('.min-crowdsource').removeClass('hidden');
		}
		else{
			$('.min-crowdsource').addClass('hidden');
		}
	});

	$('select[name="section_type_id"]').trigger('change');
}

function update_applicable()
{
	$('#performance_template-applicable_to').html('');
	if( $('#performance_template-applicable_to_id').val() != "" )
	{
		$.blockUI({ message: '<div>Updating choices for applicable to field, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/update_applicable',
					type:"POST",
					async: false,
					data: 'applicable_to_id='+$('#performance_template-applicable_to_id').val(),
					dataType: "json",
					beforeSend: function(){
					},
					success: function ( response ) {
						handle_ajax_message( response.message );

						if( typeof(response.options) != 'undefined' )
						{
							$('#performance_template-applicable_to').html( response.options );
							$('#performance_template-applicable_to').select2();
						}
					}
				});
			}
		});
		$.unblockUI();
	}
}
var headeditor = null;
var footeditor = null;
function section_form( section_id )
{
	var question = "Are you sure you want to add a new section?";
	if(section_id != "")
	{
		question = "Are you sure you want to edit this section?"
	}

	bootbox.confirm(question, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: loading_message(), 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/get_section_form',
						type:"POST",
						async: false,
						dataType: "json",
						data: 'template_id='+$('#record_id').val()+'&section_id='+section_id,
						success: function ( response ) {
							if( typeof(response.section_form) != 'undefined' )
							{
								$('.modal-container').attr('data-width', '800');
								$('.modal-container').html(response.section_form);
								$('.modal-container').modal();
								init_section_type_change();
								$(":input").inputmask();
								headeditor = CKEDITOR.replace( 'header' );
								footeditor = CKEDITOR.replace( 'footer' );
							}	
						}
					});
				}
			});
			$.unblockUI();
		}
	});	
}

function after_save()
{
	$('.hideme').show('fast');
	$('.addnew').hide('fast');
	$('.previewbutton').show('fast');
}

function save_section()
{
	$.blockUI({ message: '<div>Saving section, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			headeditor.updateElement();
			footeditor.updateElement();
			$.ajax({
				url: base_url + module.get('route') + '/save_section',
				type:"POST",
				async: false,
				data: $('#section-form').serialize(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.close_modal)
						$('.modal-container').modal('hide');	
					get_sections();

					headeditor = null;
					footeditor = null;
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();
}

function get_sections()
{
	$('#saved-sections').block({ message: '<div>Loading sections, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_sections',
				type:"POST",
				async: false,
				data: 'template_id='+$('#record_id').val(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					
					if( typeof(response.sections) != 'undefined' )
					{
						$('#saved-sections').html(response.sections);
						get_section_items();
					}
					
				}
			});
		}
	});
	$('#saved-sections').unblock();	
}

function delete_section( section_id )
{
	bootbox.confirm("Are you sure you want to delete section?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>Deleting, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/delete_section',
						type:"POST",
						async: false,
						dataType: "json",
						data: 'section_id='+section_id,
						success: function ( response ) {
							handle_ajax_message( response.message );
							get_sections();
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}

function add_column( section_id, column_id )
{
	var question = "Are you sure you want to add a new column?";
	if(column_id != "")
	{
		question = "Are you sure you want to edit this column?"
	}

	bootbox.confirm(question, function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: loading_message(), 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/get_column_form',
						type:"POST",
						async: false,
						dataType: "json",
						data: 'section_id='+section_id+'&column_id='+column_id,
						success: function ( response ) {
							if( typeof(response.column_form) != 'undefined' )
							{
								$('.modal-container').attr('data-width', '600');
								$('.modal-container').html(response.column_form);
								$('.modal-container').modal();
							}	
						}
					});
				}
			});
			$.unblockUI();
		}
	});	
}


function save_column()
{
	$.blockUI({ message: '<div>Saving column, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_column',
				type:"POST",
				async: false,
				data: $('#column-form').serialize(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.close_modal)
						$('.modal-container').modal('hide');
					get_sections();
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();	
}

function delete_column( column_id )
{
	bootbox.confirm("Are you sure you want to delete column?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>Deleting, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/delete_column',
						type:"POST",
						async: false,
						dataType: "json",
						data: 'column_id='+column_id,
						success: function ( response ) {
							handle_ajax_message( response.message );
							get_sections();
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}

function init_rg()
{
	$('form#column-form select[name="uitype_id"]').change(function(){
		switch( $(this).val() )
		{
			case "4":
				$('form#column-form div.li_option').css('display', '');
				$('form#column-form div.rg_option').css('display', 'none');
				$('form#column-form div.rg_option select').val('');
				$('form#column-form div.weight_option').css('display', 'none');
				$('form#column-form div.weight_option input').val('');

				break;
			case "5":
				$('form#column-form div.li_option').css('display', 'none');
				$('form#column-form div.li_option input').val('');
				$('form#column-form div.rg_option').css('display', '');
				$('form#column-form div.weight_option').css('display', 'none');
				$('form#column-form div.weight_option input').val('');
				break;

			case "7":
				$('form#column-form div.weight_option').css('display', '');
				$('form#column-form div.li_option').css('display', 'none');
				$('form#column-form div.li_option').val('');
				$('form#column-form div.rg_option').css('display', 'none');
				$('form#column-form div.rg_option select').val('');
				break;
			default:
				$('form#column-form div.li_option').css('display', 'none');
				$('form#column-form div.li_option input').val('');
				$('form#column-form div.rg_option').css('display', 'none');
				$('form#column-form div.rg_option select').val('');
				$('form#column-form div.weight_option').css('display', 'none');
				$('form#column-form div.weight_option input').val('');
		}
	});

	$('form#column-form select[name="uitype_id"]').trigger('change');
}

function add_item( column_id, item_id, parent_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				section_column_id: column_id,
				item_id: item_id,
				parent_id:parent_id
			};
			$.ajax({
				url: base_url + module.get('route') + '/get_item_form',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.item_form) != 'undefined' )
					{
						$('.modal-container').html(response.item_form);
						$('.modal-container').modal();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function save_item()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_item',
				type:"POST",
				data: $('form#item-form').serialize(),
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.close_modal)
						$('.modal-container').modal('hide');
					get_items( $('form#item-form input[name="section_column_id"]').val() );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function get_items( column_id )
{
	$.blockUI({ message: '<div>Reloading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = {
				planning_id: $('input[name="planning_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				template_id: $('input[name="template_id"]').val(),
				column_id: column_id
			};
			$.ajax({
				url: base_url + module.get('route') + '/get_items',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('tbody.section-'+response.section_id + ' tr:not(.first-row)').each(function(){
						$(this).remove();
					});
					$('tbody.section-'+response.section_id).prepend( response.items );
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function get_section_items()
{
	$('tbody.get-section').each(function(){
		var section_id = $(this).attr('section');
		get_section_item(section_id);
	});
}

function get_section_item( section_id )
{
	$('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = {
				section_id: section_id
			};

			$.ajax({
				url: base_url + module.get('route') + '/get_section_items',
				type:"POST",
				data: data,
				dataType: "json",
				async: true,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('tbody.section-'+section_id + ' tr:not(.first-row)').each(function(){
						$(this).remove();
					});
					$('tbody.section-'+section_id).prepend( response.items );
					$('tbody.section-'+section_id).unblock();
				}
			});
		},
		baseZ: 300000000
	});	
}

function delete_item( item_id )
{
	bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: '<div>Deleting, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/delete_item',
						type:"POST",
						async: false,
						data: {item_id:item_id},
						dataType: "json",
						success: function ( response ) {
							get_section_items()		
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}
