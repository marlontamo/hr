$(document).ready(function(){
	if( $('#record_id').val() > 0 ){
		$('#sectionsDiv').show('fast');
	}
});

function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var hasCKItem = form.find("textarea.ckeditor");

			if(hasCKItem && (typeof editor != 'undefined')){
				
				for ( instance in CKEDITOR.instances )
        			CKEDITOR.instances[instance].updateElement();
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' ){
							$('#record_id').val( response.record_id );
							$('#sectionsDiv').show('fast');
						}

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

var headeditor = null;
var footeditor = null;
function section_form( section_id )
{
	// var question = "Are you sure you want to add a new section?";
	// if(section_id != "")
	// {
	// 	question = "Are you sure you want to edit this section?"
	// }

	// bootbox.confirm(question, function(confirm) {
	// 	if( confirm )
	// 	{
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
		// }
	// });	
}