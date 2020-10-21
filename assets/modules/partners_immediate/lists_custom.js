
// $(document).ready(function(e) { 
// 	if (jQuery().infiniteScroll){
// 		$('#record-list').infiniteScroll({
// 			dataPath: base_url + module.get('route') + '/get_list',
// 			itemSelector: 'tr.record',
// 			onDataLoading: function(){ 
// 				$("#loader").show();
// 			},
// 			onDataLoaded: function(x, y, z){ 
// 				$("#loader").hide();
				
//                 if( x <= 0 ){
//                     $('.well').show();
//                 }
//                 else{
//                     $('.well').hide();
//                 }
// 			},
// 			onDataError: function(){ 
// 				return;
// 			},
// 			search: $('input[name="list-search"]').val()
// 		});

// 		$('form#list-search').submit(function( event ) {
// 			event.preventDefault();
// 			$('#record-list').infiniteScroll('search');
// 		});	
// 	}	

// 	//added to search on keypress
//     $('input[name="list-search"]').live('keypress',function(){
//             $('#record-list').infiniteScroll('search');
//         });	
// });

$(document).ready(function(e) { 
	if (jQuery().infiniteScroll){
		create_list();

		$('form#list-search').submit(function( event ) {
			event.preventDefault();
			create_list();
		});	
	}
	$('.filter-status').click(function(){
		$('.filter-status').removeClass('label-success');
		$('.filter-status').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});
});

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = {
		active: $('.filter-status.label-success').attr('filter_value'),
	};
	var filter_value = $('.list-filter.active').attr('filter_value');

	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list',
		itemSelector: 'tr.record',
		onDataLoading: function(){ 
			$("#loader").show();
			$("#no_record").hide();
		},
		onDataLoaded: function(page, records){ 
			$("#loader").hide();
			if( page == 0 && records == 0)
			{
				$("#no_record").show();
			}
		},
		onDataError: function(){ 
			return;
		},
		search: search,
		filter_by: filter_by,
		filter_value: filter_value
	});
}
function delete_records()
{
	var records = new Array();
	var record_ctr = 0;
	$('.record-checker').each(function(){
		if( $(this).is(':checked') )
		{
			records[record_ctr] = $(this).val();
			record_ctr++;
		}
	});

	if( record_ctr == 0 )
	{
		notify('warning', 'Nothing selected');
		return;
	}

	records = records.join(',');

	bootbox.confirm("Are you sure you want to delete selected record(s)?", function(confirm) {
		if( confirm )
		{
			_delete_record( records )
		}
	});
}

function delete_record( record_id, callback )
{
	bootbox.confirm("Are you sure you want to this record?", function(confirm) {
		if( confirm )
		{
			_delete_record( record_id, callback );
		} 
	});
}

function _delete_record( records, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete',
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

			if (typeof(callback) == typeof(Function))
				callback();
			else
				$('#record-list').infiniteScroll('search');
		}
	});
}

function view_trash()
{
	$('#record-list').infiniteScroll('trash');
}

function refresh_list()
{
	$('#record-list').infiniteScroll('search');
	$('.partner-modal').modal('hide');
}

function add_partners( fg_id )
{
	$.ajax({
		url: base_url + module.get('route') + '/add_partner',
		type:"POST",
		async: false,
		// data: 'mod_id='+mod_id+'&fg_id='+fg_id,
		dataType: "json",
		beforeSend: function(){
			$('body').modalmanager('loading');
		},
		success: function ( response ) {
			if( typeof(response.add_partner_form) != 'undefined' )
			{
				$('.partner-modal').html(response.add_partner_form);
				$('.partner-modal').modal();
				$('.make-switch').not(".has-switch")['bootstrapSwitch']();
			}

			handle_ajax_message( response.message );

		}
	});	
}


function save_new_partner( fg )
{
	fg.submit( function(e){ e.preventDefault(); } );
	var data = fg.find(":not('.dontserializeme')").serialize();
	data = data + '&record_id=' + $('#record_id').val()+ '&fgs_number=0';
	$.ajax({
		url: base_url + module.get('route') + '/save',
		type:"POST",
		data: data,
		dataType: "json",
		async: false,
		beforeSend: function(){
			$('form#add-partner-form').block({ message: '<div>Saving partner, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
		},
		success: function ( response ) {
			$('form#add-partner-form').unblock();
			// console.log(response);

			if(response.saved )
			{
				$('.modal-container').modal('hide');
				window.location.href = base_url + module.get('route') + '/edit/'+response.record_id;
			}
				handle_ajax_message( response.message );
		}
	});
}
