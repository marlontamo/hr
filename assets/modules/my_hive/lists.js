

function redeem_product( record_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/redeem_product',
				type:"POST",
				async: false,
				data: 'record_id='+record_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.redeem_form) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '350');
						$('.modal-container').html(response.redeem_form);
						$('.modal-container').modal();
					}
				}
			});
		}
	});
	$.unblockUI();	
}

function save_item( record_id )
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/save_item',
				type:"POST",
				async: false,
				data: 'record_id='+record_id,
				dataType: "json",
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					alert ("Item successfully redeemed! \nA voucher was sent in your email to claim the product.");
					$('.modal-container').modal('hide');
					location.reload(false);

					setTimeout(activate_redemptionTab, 3000);
				}
			});
		}
	});
	$.unblockUI();	
}

function activate_redemptionTab(){
	$("#badges_tab").removeClass('active');
	$("#redemption_tab").addClass('active');	
}