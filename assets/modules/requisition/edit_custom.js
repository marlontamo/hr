$(document).ready(function(){
	if( $('input[name="requisition_items[unit_price][]"][type!="hidden"]').val() != undefined )
	{
		if (jQuery().datepicker) {
		    $('.date-picker').datepicker({
		        rtl: App.isRTL(),
		        autoclose: true
		    });
		}
		init_price_calc();
	}
	else{
		calc_grand_total();
	}

	$(":input").inputmask();

	
});

function init_price_calc()
{
	$('input[name="requisition_items[quantity][]"]').change(function(){
		calc_total_price($(this));
	});

	$('input[name="requisition_items[unit_price][]"]').change(function(){
		calc_total_price($(this));
	});
}

function calc_total_price(input)
{
	var parent_tr = input.closest('tr');
	var quantity = parent_tr.find('input[name="requisition_items[quantity][]"]');
	var unit_price = parent_tr.find('input[name="requisition_items[unit_price][]"]');
	var amount = parent_tr.find('input[name="requisition_items[amount][]"]');
	if( quantity.val() != "" && unit_price.val() != "" )
	{
		var total_price = parseFloat( remove_commas( quantity.val() ) ) * parseFloat( remove_commas(unit_price.val() ) );
		amount.val(add_commas(total_price.toFixed(2)));
		calc_grand_total();
	}
}

function calc_grand_total()
{
	var total_price = 0
	var no_of_items = 0;
	$('input[name="requisition_items[amount][]"]:visible').each(function(){
		total_price = total_price + parseFloat( remove_commas( $(this).val() ) );
	});

	$('input[name="requisition_items[quantity][]"]:visible').each(function(){
		no_of_items = no_of_items + parseFloat( remove_commas( $(this).val() ) );
	});

	$('input[name="requisition[total_price]"]').val(add_commas(total_price.toFixed(2)));
	$('input[name="requisition[no_of_items]"]').val(no_of_items);
}

function add_item()
{
	$('tbody.item-list tr.success').before( $('table.add-new-tem tbody').html() );
	$('tbody.item-list tr.add_reminder').remove();

	if (jQuery().datepicker) {
	    $('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	}

	$(":input").inputmask();
	init_price_calc();
}

function delete_item( item )
{
	item.closest('tr').remove();
}

function save_record( form, status )
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
				data: data+'&requisition[status]='+status,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );

						if(response.notify != "undefined")
						{
							for(var i in response.notify)
								socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}

						if( status == 2 )
							document.location = base_url + module.get('route');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function confirm(form)
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
				url: base_url + module.get('route') + '/confirm',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( response.saved )
					{
						if( response.action == 'insert' )
							$('#record_id').val( response.record_id );

						if(response.notify != "undefined")
						{
							for(var i in response.notify)
								socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}

						document.location = base_url + module.get('route');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}