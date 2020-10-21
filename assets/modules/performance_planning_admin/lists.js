$(document).ready(function(e) { 
	$('.filter-type').click(function(){
		$('.filter-type').removeClass('label-success');
		$('.filter-type').addClass('label-default');
		$(this).removeClass('label-default');
		$(this).addClass('label-success')
		create_list();
	});

	$('.list-filter').click(function(){
		$('.list-filter').removeClass('active');
		$('.list-filter').children('i').addClass('fa-square-o');
		$(this).addClass('active');
		$(this).children('i').removeClass('fa-square-o');
		$(this).children('i').addClass('fa-check-square-o');

		create_list();
	});	

});

function view_transaction_logs( planning_id, user_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				planning_id: planning_id,
				user_id:user_id
			};
			$.ajax({
				url: base_url + module.get('route') + '/view_transaction_logs',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if( typeof(response.trans_logs) != 'undefined' )
					{
						$('.modal-container').attr('data-width', '800');
						$('.modal-container').html(response.trans_logs);
						$('.modal-container').modal();
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function create_list()
{
	var planning_id = $('#planning_id').val();
	var search = $('input[name="list-search"]').val();
	var filter_by = {
		status_id: $('.filter-type.label-success').attr('filter_value')
	}
	var filter_value = $('.list-filter.active').attr('filter_value');

	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_list/'+planning_id,
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

function delete_planning( record_id, user_id, callback )
{
	bootbox.confirm(lang.confirm.delete_single, function(confirm) {
		if( confirm )
		{
			_delete_planning( record_id, user_id, callback );
		} 
	});
}

function _delete_planning( record_id, user_id, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/delete_planning',
		type:"POST",
		data: {record_id:record_id, user_id:user_id},
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

function initialize_planning( record_id, user_id, callback )
{
	bootbox.confirm("Are you sure you want to initialize the planning template?", function(confirm) {
		if( confirm )
		{
			_initialize_planning( record_id, user_id, callback );
		} 
	});
}

function _initialize_planning( record_id, user_id, callback )
{
	$.ajax({
		url: base_url + module.get('route') + '/initialize_planning',
		type:"POST",
		data: {record_id:record_id, user_id:user_id},
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