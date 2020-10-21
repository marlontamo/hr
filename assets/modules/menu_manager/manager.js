$(document).ready(function(){
	$('select[name="role_id"]').change(function(){
		if( $(this).val() != "" ){
			$('.save-btn').removeClass('hidden')
			get_menu( $(this).val() );
		}
		else{
			$('.save-btn').addClass('hidden');
		}
	});

	refresh_menu();
});

var menu_cache = '';

function refresh_menu()
{
	$('select[name="role_id"]').trigger('change');	
}

function get_menu( role_id )
{
	$('#menu-tree').block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_menu',
				type:"POST",
				data: "role_id="+role_id,
				dataType: "json",
				async: false,
				success: function ( response ) {
					$('#menu-tree').unblock();
					$('#menu-tree').html(response.menu);
					$('#menu-tree').nestable({ collapseBtnHTML: '', expandBtnHTML: '' }).unbind('change').on('change', function() {
						update_menu_sequence()
					});;

					init_checkboxes();

					menu_cache = JSON.stringify($('#menu-tree').nestable('serialize'));

					handle_ajax_message( response.message );
				}
			});
		}
	});
}

function update_menu_sequence()
{
	if( JSON.stringify($('#menu-tree').nestable('serialize')) != menu_cache )
	{
		$('#menu-tree').block({ message: '<div>Saving menu lists, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
			onBlock: function(){
				$.ajax({
					url: base_url + module.get('route') + '/update_menu',
					type:"POST",
					data: 'sequence='+JSON.stringify($('#menu-tree').nestable('serialize')),
					async: false,
					dataType: "json",
					success: function ( response ) {
						handle_ajax_message( response.message );
					}
				});
			}
		});
		$('#menu-tree').unblock();
	}
}

function init_checkboxes()
{
	$('input[type="checkbox"]').uniform();
	$('input.menu-item').click( function(){
		var $this = $(this);
		var menu_id = $this.attr('menu_id');
		var parent_id = $this.attr('parent_id');
		
 		if( $this.is(':checked') )
		{
			//check parent
			if( parent_id != 0 )
				$('input[menu_id="'+parent_id+'"]').attr('checked', true);

			//checek all children
			$('input[parent_id="'+menu_id+'"]').attr('checked', true);
		}
		else{
			//unchecked all children
			$('input[parent_id="'+menu_id+'"]').attr('checked', false);

			//uncheck parent if no children is checked
			var ctr = 0;
			$('input[parent_id="'+parent_id+'"]').each(function(){
				if( $(this).is(':checked') )
					ctr++;
			});

			if(ctr == 0)
				$('input[menu_id="'+parent_id+'"]').attr('checked', false);
		}

		$('input[type="checkbox"]').uniform();
	});
}

function save_role_menu()
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_role_menu',
				type:"POST",
				data: $('div#menu-tree :input').serialize()+'&role_id='+$('select[name="role_id"]').val(),
				async: false,
				dataType: "json",
				success: function ( response ) {
					refresh_menu();
					handle_ajax_message( response.message );
				}
			});
		}
	});
	$.unblockUI();
}