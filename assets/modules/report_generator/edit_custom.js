$(document).ready(function(){

	$('#filter_required_chkbox').change(function(){
	    if( $(this).is(':checked') )
	        $(this).val('1');
	    else
	        $(this).val('0');
	});

	$('select[name="primary_table"]').change(function(){
		add_table( $('select[name="primary_table"]').val(), 1 );
	});

	$('.searchable').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});

	$('select[name="filter_uitype"]').change(function(){
		switch( $(this).val() )
		{
			case "1":
			case "9":
				$('#additional-info-filter').css('display', '');
				break;
			default:
				$('#additional-info-filter').css('display', 'none');
		}
	});

	reset_dropdowns();
	init_sortble();

    $('.multiple_dropdown').multiselect();
    $('.ui-multiselect').css('width', '280px');
    $('.ui-multiselect-menu').css('width', '280px');
});

function init_sortble()
{
	$('.table').sortable({
		containerSelector: 'table',
		itemPath: '> tbody#listed-select',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"/>'
	});

	$('.table').sortable({
		containerSelector: 'table',
		itemPath: '> tbody#listed-sort',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"/>'
	});
}

function add_table( table, primary_table )
{
	if( table == "" )
	{
		table = $('select[name="add_more_table"]').val();
	}

	if( table == "0" )
	{
		notify('warning', 'Please select a table to add');
		return;
	}

	var data = {table: table, primary_table: primary_table, t_count: t_count };
	$.ajax({
		url: base_url + module.get('route') + '/add_table',
		type:"POST",
		dataType: "json",
		data: data,
		async: false,
		success: function ( response ) {
			if( primary_table == 1 )
			{
				$('#T0').remove();
				$('#listed-tables').prepend( response.table );
				tables['T0'] = response.t_columns;
			}
			else{
				$('#listed-tables').append( response.table );
				
				for( var t_name in tables)
				{
					var t_columns = tables[t_name];
					for( var i in  t_columns )
					{
						$('#listed-tables tr#'+'T'+t_count + ' select[name="report_generator_table[join_to_column][]"]').append('<option value="'+ t_name +'.'+t_columns[i]+'">'+ t_name +'.'+t_columns[i]+'</option>');
					}
				}
			
				tables['T'+t_count] = response.t_columns;
				t_count++;
			}

			//reset dropdowns
			reset_dropdowns();
			
			handle_ajax_message( response.message );
		}
	});
}

function add_select()
{
	if( $('select[name="add_column"]').val() == null )
	{
		notify('warning', 'Please select a column to add');
		return;
	}

	var data = {column: $('select[name="add_column"]').val()};
	$.ajax({
		url: base_url + module.get('route') + '/add_column',
		type:"POST",
		dataType: "json",
		data: data,
		async: false,
		success: function ( response ) {
			$('#listed-select').append( response.column );
			handle_ajax_message( response.message );
		}
	});
}

function add_groupx()
{
	if( $('select[name="add_group"]').val() == null )
	{
		notify('warning', 'Please select a column to add');
		return;
	}

	var new_group = "<tr>";
	new_group = new_group + '<td>';
	new_group = new_group + '<input type="hidden" name="report_generator_grouping[column][]" value="'+$('select[name="add_group"]').val()+'">';
	new_group = new_group + $('select[name="add_group"]').val(); 
	new_group = new_group + '</td>';
	new_group = new_group + '<td>';
	new_group = new_group + '<a href="javascript: void(0)" onclick="delete_row($(this))">';
	new_group = new_group + '<i class="fa fa-trash-o"></i>';
	new_group = new_group + 'Delete';
	new_group = new_group + '</a>';
	new_group = new_group + '</td>';
	new_group = new_group + "</tr>";

	$('#listed-group').append( new_group );
}

function add_sortx()
{
	if( $('select[name="add_sort"]').val() == null )
	{
		notify('warning', 'Please select a column to sort');
		return;
	}

	var data = {column: $('select[name="add_sort"]').val()};
	$.ajax({
		url: base_url + module.get('route') + '/add_sort',
		type:"POST",
		dataType: "json",
		data: data,
		async: false,
		success: function ( response ) {
			$('#listed-sort').append( response.sort );
			handle_ajax_message( response.message );
		}
	});
}

function add_filter()
{
	if( $('select[name="filter_column"]').val() == null )
	{
		notify('warning', 'Please select a column to add');
		return;
	}

	if( $('select[name="filter_uitype"]').val() == "" )
	{
		notify('warning', 'Please select a uitype for filter');
		return;
	}

	if( $('select[name="filter_uitype"]').val() == "1" )
	{
		if( $('input[name="ai-table"]').val() == "" )
		{
			notify('warning', 'Please enter a table for uitype dropdown');
			return;
		}

		if( $('input[name="ai-value"]').val() == "" )
		{
			notify('warning', 'Please enter a value column for uitype dropdown');
			return;
		}

		if( $('input[name="ai-table"]').val() == "" )
		{
			notify('warning', 'Please enter a label column for uitype dropdown');
			return;
		}
	}

	var column = $('select[name="filter_column"]').val();
	var type = $('select[name="filter_type"]').val();
	var uitype = $('select[name="filter_uitype"]').val();
	var ai_table = $('input[name="ai-table"]').val();
	var ai_value = $('input[name="ai-value"]').val();
	var ai_label = $('input[name="ai-label"]').val();
	var required = $('input[name="filter_required_chkbox"]').val();

	var data = {
		column: column,
		type: type,
		uitype_id: uitype,
		table: ai_table,
		value_column: ai_value,
		label_column: ai_label,
		required : required
	};

	$.ajax({
		url: base_url + module.get('route') + '/add_filter',
		type:"POST",
		dataType: "json",
		data: data,
		async: false,
		success: function ( response ) {
			if(type == 1)
				$('#listed-fixed_filter').append( response.filter );
			else
				$('#listed-editable_filter').append( response.filter );
			
			//reset form
			$('select[name="ff-uitype"]').val('');
			$('#additional-info-filter').css('display', 'none');
			
			init_filter_ui();

			handle_ajax_message( response.message );
		}
	});
}

function init_filter_ui()
{
	//init date pickers
	$('input[name="report_generator_filters[filter][]"]').each(function(){
	  $(this).parent('.date-picker').datepicker({
	        rtl: App.isRTL(),
	        autoclose: true
	    });
	});

	$('input[name="report_generator_filters[filter][]"].dtp').datetimepicker({
	    isRTL: App.isRTL(),
	    format: "dd MM yyyy - hh:ii",
	    autoclose: true,
	    todayBtn: true,
	    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
	    minuteStep: 1
	});

	$('input[name="report_generator_filters[filter][]"].timepicker-default').timepicker({
        autoclose: true,
        showSeconds: true,
        minuteStep: 1,
        secondStep: 1
    });

    $('.multiple_dropdown').multiselect();
    $('.ui-multiselect').css('width', '280px');
    $('.ui-multiselect-menu').css('width', '280px');
}

function delete_table(alias)
{
	$('#listed-tables tr#'+alias).remove();

	delete tables[alias];
	reset_dropdowns();
}

function delete_row(column)
{
	column.closest("tr").remove();
}

function reset_dropdowns()
{
	$('select[name="add_column"]').html('');
	$('select[name="filter_column"]').html('');
	$('select[name="add_group"]').html('');
	$('select[name="add_sort"]').html('');

	for( var t_name in tables)
	{
		var t_columns = tables[t_name];
		for( var i in  t_columns )
		{
			$('select[name="add_column"]').append('<option value="'+ t_name +'.'+t_columns[i]+'">'+ t_name +'.'+t_columns[i]+'</option>');
			$('select[name="filter_column"]').append('<option value="'+ t_name +'.'+t_columns[i]+'">'+ t_name +'.'+t_columns[i]+'</option>');
			$('select[name="add_group"]').append('<option value="'+ t_name +'.'+t_columns[i]+'">'+ t_name +'.'+t_columns[i]+'</option>');
			$('select[name="add_sort"]').append('<option value="'+ t_name +'.'+t_columns[i]+'">'+ t_name +'.'+t_columns[i]+'</option>');
		}
	}
}

function add_hfline(place_in){
	var hfline = "<tr>";
	hfline = hfline + '<td class="hfline-'+place_in+'">';
	
	switch( place_in ){
		case 1:
			hfline = hfline + 'Header';
			break;
		case 2:
			hfline = hfline + 'Footer';
			break;
	}

	hfline = hfline + '</td>';
	hfline = hfline + '<td>';
	hfline = hfline + '<textarea name="report_generator_letterhead['+place_in+'][]"></textarea>';
	hfline = hfline + '</td>';
	hfline = hfline + '<td>';
	hfline = hfline + '<a href="javascript: void(0)" onclick="delete_row($(this))">';
	hfline = hfline + '<i class="fa fa-trash-o"></i>';
	hfline = hfline + 'Delete';
	hfline = hfline + '</a>';
	hfline = hfline + '</td>';
	hfline = hfline + "</tr>";

	$('#listed-hfline-'+place_in).append( hfline );
}