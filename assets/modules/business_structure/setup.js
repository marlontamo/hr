$(document).ready(function(){
	get_regions();	
});

function get_regions()
{
	$('table#region-list tbody').block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_regions',
				type:"POST",
				async: false,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					$('table#region-list tbody').html('');
					if( typeof(response.regions) != 'undefined' )
					{
						$('table#region-list tbody').html(response.regions);
						init_region_radio();
					}
				}
			});
		}
	});
	$('table#region-list tbody').unblock();
}

function init_region_radio()
{
	$('input[name="region_id"]').change(function(){
		get_groups();
	});
}

function init_group_radio()
{
	$('input[name="group_id"]').change(function(){
		get_companies();
	});
}

function edit_region( region_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/edit_region',
				type:"POST",
				async: false,
				data: {region_id:region_id},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof(response.region_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '550');
						$('.modal-container').html(response.region_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function save_region()
{
	$.blockUI({ message: '<div>Saving form, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_region',
				type:"POST",
				async: false,
				data: $('form#region-form').serialize(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( !response.error )
					{
						$('.modal-container').modal('hide');
						get_regions();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function get_groups()
{
	$('table#group-list tbody').block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_groups',
				type:"POST",
				async: false,
				dataType: "json",
				data: { region_id: $('input[name="region_id"]:checked').val() },
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					$('table#group-list tbody').html('');
					if( typeof(response.groups) != 'undefined' )
					{
						$('table#group-list tbody').html(response.groups);
						init_group_radio();
					}
				}
			});
		}
	});
	$('table#group-list tbody').unblock();
}

function edit_group( group_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/edit_group',
				type:"POST",
				async: false,
				data: {group_id:group_id, region_id: $('input[name="region_id"]:checked').val()},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof(response.group_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '550');
						$('.modal-container').html(response.group_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function save_group()
{
	$.blockUI({ message: '<div>Saving form, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_group',
				type:"POST",
				async: false,
				data: $('form#group-form').serialize(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( !response.error )
					{
						$('.modal-container').modal('hide');
						get_groups();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function delete_region( region_id )
{
	bootbox.confirm("Are you sure you want to delete this region?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: loading_message(), 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/delete_region',
						type:"POST",
						dataType: "json",
						data: {region_id: region_id},
						async: false,
						success: function ( response ) {
							get_regions();
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}

function delete_group( group_id )
{
	bootbox.confirm("Are you sure you want to delete this group?", function(confirm) {
		if( confirm )
		{
			$.blockUI({ message: loading_message(), 
				onBlock: function(){
					$.ajax({
						url: base_url + module.get('route') + '/delete_group',
						type:"POST",
						dataType: "json",
						data: {group_id: group_id},
						async: false,
						success: function ( response ) {
							get_groups();
						}
					});
				}
			});
			$.unblockUI();
		}
	});
}

function get_companies()
{
	$('table#company-list tbody').block({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/get_companies',
				type:"POST",
				async: false,
				data: { group_id: $('input[name="group_id"]:checked').val() },
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					$('table#company-list tbody').html('');
					if( typeof(response.companies) != 'undefined' )
					{
						$('table#company-list tbody').html(response.companies);
					}
				}
			});
		}
	});
	$('table#company-list tbody').unblock();
}

function edit_company( company_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/edit_company',
				type:"POST",
				async: false,
				data: {company_id:company_id, group_id: $('input[name="group_id"]:checked').val()},
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof(response.company_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '550');
						$('.modal-container').html(response.company_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();
}

function save_company()
{
	$.blockUI({ message: '<div>Saving form, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_company',
				type:"POST",
				async: false,
				data: $('form#company-form').serialize(),
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( !response.error )
					{
						$('.modal-container').modal('hide');
						get_companies();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}