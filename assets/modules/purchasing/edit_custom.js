$(document).ready(function(){
	if( $('input[name="requisition_items[actual_price][]"][type!="hidden"]').val() != undefined )
	{
		$('input[name="requisition_items[actual_price][]"]').change(calc_new_total);
		$('input[name="requisition_items[actual_price][]"]').each(function(){
			$(this).trigger('change');
		});
	}
	
	if( $('input[name="requisition_items[po_price][]"][type!="hidden"]').val() != undefined )
	{
		$('input[name="requisition_items[po_quantity][]"]').change(function(){
			calc_po_total($(this));
		});

		$('input[name="requisition_items[po_price][]"]').change(function(){
			calc_po_total($(this));
		});

		$('input[name="requisition_items[po_price][]"]').each(function(){
			$(this).trigger('change');
		});
	}

	$(":input").inputmask();
});

function calc_new_total()
{
	var total_field = $(this).parent().parent().find('input[name="requisition_items[actual_amount][]"]');
	var qty_field = $(this).parent().parent().prev('tr').find('input[name="requisition_items[quantity][]"]');
	if( $(this).val()  != "" )
	{
		var total = parseFloat( remove_commas( qty_field.val() ) ) * parseFloat( remove_commas( $(this).val() ) );
		total_field.val( add_commas(total.toFixed(2)) );
	}
	else{
		total_field.val('');
	}

	calc_grand_total();
}

function calc_po_total(input)
{
	var parent_tr = input.closest('tr');
	var quantity = parent_tr.find('input[name="requisition_items[po_quantity][]"]');
	var unit_price = parent_tr.find('input[name="requisition_items[po_price][]"]');
	var amount = parent_tr.find('input[name="requisition_items[po_amount][]"]');
	if( quantity.val() != "" && unit_price.val() != "" )
	{
		var total_price = parseFloat( remove_commas( quantity.val() ) ) * parseFloat( remove_commas(unit_price.val() ) );
		amount.val(add_commas(total_price.toFixed(2)));
	}
}

function calc_grand_total()
{
	var total_price = 0
	var no_of_items = 0;
	$('input[name="requisition_items[actual_amount][]"]:visible').each(function(){
		total_price = total_price + parseFloat( remove_commas( $(this).val() ) );
	});

	$('input[name="requisition[total_price]"]').val( add_commas(total_price.toFixed(2)) );
	
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

						if( status != 0 )
							document.location = base_url + module.get('route');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}