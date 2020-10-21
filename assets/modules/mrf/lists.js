

function duplicate_record( record_id, callback )
{
	bootbox.confirm(lang.confirm.duplicate_single, function(confirm) {
		if( confirm )
		{
			_duplicate_record( record_id, callback );
		} 
	});
}

function _duplicate_record( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/duplicate',
		type:"POST",
		data: 'records='+records,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			$('body').modalmanager('removeLoading');
			handle_ajax_message( response.message );

			document.location = base_url + module.get('route') + '/edit/'+response.record_id
			$('#record_id').val( response.record_id );
			// if (typeof(callback) == typeof(Function))
			// 	callback();
			// else
			// 	$('#record-list').infiniteScroll('search');
		}
	});
}