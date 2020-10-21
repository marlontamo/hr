$(document).ready(function(){
    $('.select2me').select2({
		placeholder: "Select",
		allowClear: true
	});	

	$('#category_id').select2({
	    placeholder: "Select Category",
	    allowClear: true
	});		
});

function add_category(){
	var category_id = $('#category_id').val();
	data = 'category_id='+ category_id;
	$.ajax({
		url: base_url + module.get('route') + '/get_category',
		type:"POST",
		data: data,
		dataType: "json",
		async: false,
		success: function ( response ) {
			handle_ajax_message( response.message );
			$('.category_container').append(response.html);

		    $('#'+response.id+'').select2({
				placeholder: "Select",
				allowClear: true
			});	

		    $('#category_container').append('<input type="text" class="form-control" name="roles[category_selected][]" id="cat'+category_id+'" value="'+category_id+'"/>');

			$('#category_id').find('option:selected').remove();		
			$('#category_id').select2();
		}
	});	
}

function remove_category(elem,value,label){
	$('#'+elem+'').closest('.form-group').remove();
	$('#cat'+value+'').remove();
	$('#category_id').append('<option value="'+value+'">'+label+'</option>')
	$('#category_id').select2();	
}