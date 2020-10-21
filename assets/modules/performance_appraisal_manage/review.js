$(document).ready(function(){
	get_section_items();
	$('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });

	// $( 'form' ).garlic('destroy');

	$( 'form' ).garlic();
});


function view_transaction_logs( appraisal_id, user_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				appraisal_id: appraisal_id,
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

function handle_ajax_message_stick( message )
{
	for( var i in message ){
		if(message[i].message != "") notify_stick(message[i].type, message[i].message);
	}
}

function notify_stick(type, msg, title, callback){
	toastr.options = {
		closeButton: true,
		debug: false,
		showDuration: 1000,
		hideDuration: 1000,
		timeOut:  5000,
		extendedTimeOut: 500,
		showEasing: 'swing',
		hideEasing: 'swing',
		showMethod: 'fadeIn',
		hideMethod: 'fadeOut',
		positionClass: 'toast-bottom-right',
	};

	if( typeof( callback ) == 'function' ){
		toastr.options.onclick = callback;
	}

	var $toast = toastr[type](msg, title);
}

function get_section_item( section_id )
{
	$('tbody.section-'+section_id).block({ message: '<div>Loading section items, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = {
				planning_id: $('input[name="planning_id"]').val(),
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				template_id: $('input[name="template_id"]').val(),
				section_id: section_id
			};

			$.ajax({
				url: base_url + module.get('route') + '/get_section_items',
				type:"POST",
				data: data,
				dataType: "json",
				async: true,
				success: function ( response ) {
					handle_ajax_message( response.message );
  					$( 'form' ).garlic();
  					
					$('tbody.section-'+section_id + ' tr:not(.first-row)').each(function(){
						$(this).remove();
					});
					$('tbody.section-'+section_id).prepend( response.items );
					
					crowd_rowspan_fix(section_id);
					
					switch( response.section_type )
					{
						case "4":
							init_cs_rating( section_id );
							break;
						case "3":
							init_library_rating( section_id );
							break;
						default:
							init_rating( section_id );
							avg_rating( section_id );
							total_weight( section_id );
							avg_rating( section_id );
					}

					$('tbody[section="'+section_id+'"] select.rating-field').trigger('change');
					$('tbody.section-'+section_id).unblock();
					$('textarea:visible').textareaAutoSize();
				}
			});
		},
		baseZ: 300000000
	});
		
}

function init_cs_rating( section_id )
{
	$('tbody[section="'+section_id+'"] select.rating-field').stop().change(function(){
		var $this = $(this);
		var cs_combo = $this.attr('cs_combo');
		var total_score = 0;
		var total_items = 0;
		$('select.rating-field-'+cs_combo).each(function(){
			total_items++;
			total_score = total_score + parseFloat( $(this).find(":selected").attr('score') );
		});

		var average = total_score / total_items;
		$('input.weighted_rating-field-'+cs_combo).val( round(average, 2));
		calc_average_cs_rating( $this.attr('item_id') );

		var combo = cs_combo.split('-');
		calc_section_cs_avg_rating( combo[1] );
	});
	$('tbody[section="'+section_id+'"] select.rating-field').trigger('change');
}

function calc_average_cs_rating( item_id )
{
	var total_score = 0;
	var total_items = 0;
	$('select.rating-field[item_id="'+item_id+'"]').each(function(){
		total_items++;
		total_score = total_score + parseFloat( $(this).find(":selected").attr('score') );
	});

	var average = total_score / total_items;
	$('input.average-cs-rating[item_id="'+item_id+'"]').val( round(average, 2));
}

function calc_section_cs_avg_rating( section_id )
{
	var total_score = 0;
	var total_items = 0;
	$('input.contributor-total[section_id="'+section_id+'"]').each(function(){
		total_items++;
		total_score = total_score + parseFloat( $(this).val() );	
	});

	var average = total_score / total_items;
	$('input.section_cs_avg_rating[section_id="'+section_id+'"]').val( round(average, 2));
	var war = average * parseFloat( $('input.section_cs_weight[section_id="'+section_id+'"]').val() ) / 100;
	$('input.section_cs_war[section_id="'+section_id+'"]').val( round(war, 2));
	update_summary();
}

function get_section_items()
{
	$('tbody.get-section').each(function(){
		var section_id = $(this).attr('section');
		get_section_item(section_id);
	});
}

function contributor_form(template_section_id)
{
	$.blockUI({ message: loading_message(), 
		onBlock: function(){
			data = {
				appraisal_id: $('#record_id').val(),
				user_id: $('input[name="user_id"]').val(),
				template_section_id: template_section_id,
			};
			$.ajax({
				url: base_url + module.get('route') + '/contributor_form',
				type:"POST",
				async: false,
				dataType: "json",
				data: data,
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if( typeof(response.contributor_form) != undefined )
					{
						$('.modal-container').html(response.contributor_form);
						$('.modal-container').modal();
						init_tags();
					}
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();
}

function init_tags()
{
	$('#contributors').tagsinput({
    	itemValue: 'value',
      	itemText: 'label',
      	typeahead: {
        	source: function(query) {
          		return $.getJSON(base_url + module.get('route') + '/tag_user');
        	}
      	}
    });
}

function add_contributors()
{
	if($('#contributors').val() == "")
	{
		notify('warning', 'No one selected, please type contributor(s) in the box.');
		return;
	}

	$.blockUI({ message: '<div>Adding contributors, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
		onBlock: function(){
			$.ajax({
				url: base_url + module.get('route') + '/add_contributors',
				type:"POST",
				async: false,
				dataType: "json",
				data: $('#contributor-form').serialize(), 
				beforeSend: function(){
				},
				success: function ( response ) {
					handle_ajax_message( response.message );
					if(response.close_modal){
						$('.modal-container').modal('hide');
						get_section_item( response.section_id )
					}

					if(response.hasOwnProperty('notify'))
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}
				}
			});
		},
		baseZ: 20000
	});
	$.unblockUI();
}

function init_rating( section_id )
{
	$('tbody.section-'+section_id+' select.rating-field').stop().change(function(){
		//find weight
		var td = $(this).parent().parent();
		var weight = td.find('input.weight-field');
		if( weight != undefined && weight.val() )
		{
			//find weighted rating field
			var weighted_rating = td.find('input.weighted_rating-field');
			if( weighted_rating != undefined)
			{
				var score = $("option:selected", this).attr("score");
				var x = parseFloat(weight.val()) / 100 * parseFloat(score);
				weighted_rating.val( round(x,2) );
			}
		}

		total_weight( section_id );
	});
	$('tbody.section-'+section_id+' select.rating-field').trigger('change');
}

function init_library_rating( section_id )
{
	$('tbody.section-'+section_id+' select.rating-field').stop().change(function(){
		//look for other ratings in this section
		var section_total = 0;
		var section_items = 0;
		$('tbody.section-'+section_id+' select.rating-field').each(function(){
			section_items++;
			section_total = section_total + parseFloat( $("option:selected", this).attr("score") );
		});

		var avg_rating = section_total / section_items;
		$('input.section_avg_rating[section_id="'+section_id+'"]').val( round(avg_rating, 2));
		var weighted_rating = avg_rating * parseFloat( $('input.section_weight[section_id="'+section_id+'"]').val() ) / 100;
		$('input.section_war[section_id="'+section_id+'"]').val( round(weighted_rating, 2));
		update_summary();

	});
	$('tbody.section-'+section_id+' select.rating-field').trigger('change');
}

function change_status(form, status_id)
{
	$.blockUI({ message: '<div>Saving, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />',
		onBlock: function(){
			var data = form.find(":not('.dontserializeme')").serialize() + '&status_id='+status_id;
			$.ajax({
				url: base_url + module.get('route') + '/change_status',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					if(response.validate_error){
						handle_ajax_message_stick( response.message );					
					    $(".required_field").each(function () {
					        if ($(this).val() == "") {
					        	$(this).css('border', '1px solid #ff4d4d');
					        }
					    });
					    $(".required_select").each(function () {
					        if ($(this).val() == "") {
					        	$(this).css('border', '1px solid #ff4d4d');
					        }
					    });
					}else{				
						handle_ajax_message( response.message );
					}

					if(response.hasOwnProperty('notify'))
					{
						for(var i in response.notify)
							socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
					}

					if(response.redirect){
  						$( 'form' ).garlic('destroy');
						window.location = base_url + module.get('route');
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function total_weight( section_id )
{
	var total = 0;
	$('tbody.section-'+section_id).find('input.weight-field').each(function(){
		total = total + parseFloat( $(this).val() );
	});

	if( !isNaN(total) )
		$('tbody.section-'+section_id).find('input.weight-total').val( round(total,2) );	

	total_rating( section_id );
}

function total_rating( section_id )
{
	var total = 0;
	$('tbody.section-'+section_id).find('input.weighted_rating-field').each(function(){
		total = total + parseFloat( $(this).val() );
	});

	if( !isNaN(total) ){
		$('tbody.section-'+section_id).find('input.weight_rating-total').val( round(total,2) );
	}

	update_summary();
}

function update_summary()
{
	$('input.summary-section').each(function(){
		var section_id = $(this).attr('section_id');
		var target = $('tbody.section-'+section_id+' input.weight_rating-total').val();
		if( target == undefined )
			target = $('tbody.section-'+section_id+' input.grand-total').val();
		$(this).val( target );
	});

	var final_total = 0;
	$('input[name="summary-section-total"]').each(function(){
		var $this = $(this); 
		var section_id = $this.attr('section_id');
		var total = 0;
		
		$('tr[section_id="'+section_id+'"] input.summary-section').each(function(){
			total = total + parseFloat( $(this).val() );	
		});

		if( !isNaN(total) ){
			$this.val( round(total,2) );
		}
	});

	$('input.grand-section-total').each(function(){
		var $this = $(this); 
		var section_id = $this.attr('section_id');
		var weight = $this.attr('weight');
		var total = parseFloat( $('input[name="summary-section-total"][section_id="'+section_id+'"]').val() );
		total = total * weight / 100;
		total = round(total,2);
		$this.val( total );
		
		final_total = parseFloat(final_total) + parseFloat(total);
	});

	final_total = round(final_total, 2);
	var equiv = rc.rc1;
	var rc_code = "";
	for(var i in equiv)
	{
		if( equiv[i].min <= final_total && final_total <= equiv[i].max)
		{
			rc_code = equiv[i].code;
		}
	}

	$('input.final_total').val( final_total +' ('+rc_code+')' );

	$('input[name="summary-section-total"]').each(function(){
		var $this = $(this); 
		var section_id = $this.attr('section_id');
		var rc_id = $this.attr('rc_id');
		var total = 0;
		
		$('tr[section_id="'+section_id+'"] input.summary-section').each(function(){
			total = total + parseFloat( $(this).val() );	
		});

		if( !isNaN(total) ){
			total = round(total,2);
			var equiv = eval( 'rc.rc'+rc_id);
			var rc_code = '';
			for(var i in equiv)
			{	
				if( equiv[i].min <= total && total <= equiv[i].max)
				{
					rc_code = equiv[i].code;
				}
			}
			$this.val( total + ' ('+ rc_code +')' );
		}
	});
}

function crowd_rowspan_fix(section_id)
{
	var contributors = new Array();
	var ctr = 0;
	$('tbody.section-'+section_id+' td.contributor').each(function(){
		var contributor_id = $(this).attr('contributor_id');
		var add_to_array = true;
		for(var i in contributors)
		{
			if( contributors[i] == contributor_id)
			{
				add_to_array = false;
				break;
			}
		}

		if( add_to_array )
		{
			contributors[ctr] = contributor_id;
			ctr++;
		}
	});

	if(contributors.length > 0 )
	{
		var tdctr = 0;
		var avg_total = 0;
		for(var i in contributors)
		{
			tdctr = 0;
			
			$('tbody.section-'+section_id+' td.contributor-'+contributors[i]).each(function(){
				tdctr++;
			});
			
			if( tdctr > 1 )
			{
				var first = true;
				$('tbody.section-'+section_id+' td.contributor-'+contributors[i]).each(function(){
					if( first )
					{
						$(this).attr('rowspan', tdctr);
					}
					else{
						$(this).remove();
					}

					first = false;
				});
				
				first = true;
				$('tbody.section-'+section_id+' td.contributor-total-'+contributors[i]).each(function(){
					if( first )
					{
						$(this).attr('rowspan', tdctr);
					}
					else{
						$(this).remove();
					}

					first = false;
				});

				var total = 0;
				$('tbody.section-'+section_id+' input[contributor_id="'+contributors[i]+'"]').each(function(){
					if(!isNaN($(this).val()) && $(this).val() != ""){
						$(this).val( round($(this).val(), 2) );
					}
						
					total = total + parseFloat( $(this).val() );
				});
				avg_total = avg_total + total;
				
				if(!isNaN(total))
					$('tbody.section-'+section_id+' input[name="total-'+contributors[i]+'"]').val( round(total,2) );
			}
		}

		var avg_rating = avg_total / contributors.length;
		if(!isNaN(avg_rating))
			$('tbody.section-'+section_id+' input.grand-total').val(round(avg_rating,2));
	}
}

function avg_rating( section_id )
{
	$('tbody section-'+section_id+' input.average-rating').each(function(){
		var $this = $(this);
		var item_id = $(this).attr('item_id');
		var total = 0;
		var ctr = 0;
		$('select.contributor-rating[item_id="'+item_id+'"]').each(function(){
			total = total + parseFloat( $(this).val() );
			ctr++;
		});

		var avg = total / ctr;
		avg = avg.toFixed(2);
		if(!isNaN(avg))
			$this.val(round(avg,2));

		var weight = $this.parent().parent().find('input.average-weight[item_id="'+item_id+'"]');
		var x = parseFloat(weight.val()) / 100 * parseFloat(avg);
		if(!isNaN(x))
			$this.parent().parent().find('input.average-weighted-rating[item_id="'+item_id+'"]').val(round(x,2));
	});
}

function add_tripart(column_id, item_id)
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				column_id: column_id,
				item_id: item_id
			};

			$.ajax({
				url: base_url + module.get('route') + '/add_tripart',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );
					$('tbody.tripart-'+item_id).append( response.tripart );
					init_datepicker();
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();	
}

function init_datepicker()
{
	$('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
}

function remove_pdp( button )
{
	bootbox.confirm("Are you sure you want to delete this row?", function(confirm) {
		if( confirm )
		{
			button.parent().parent().parent().remove();
		}
	});
}

function cs_discussion_form( appraisal_id, section_id, user_id, contributor_id, show_form, status_id )
{
	if( show_form && contributor_id != '' )
	{
		bootbox.confirm("Are you sure you want to send this feedback back to crowdsource?", function(confirm) {
			if( confirm )
			{
				get_discussion_form( appraisal_id, section_id, user_id, contributor_id, show_form, status_id );
			}
		});
	}
	else{
		get_discussion_form( appraisal_id, section_id, user_id, contributor_id, show_form, status_id );
	}
}

function get_discussion_form( appraisal_id, section_id, user_id, contributor_id, show_form, status_id )
{
	$.blockUI({ message: loading_message(),
		onBlock: function(){
			var data = {
				appraisal_id: $('input[name="appraisal_id"]').val(),
				user_id: $('input[name="user_id"]').val(),
				contributor_id: contributor_id,
				section_id: section_id,
				show_form: show_form,
				status_id: status_id
			};

			$.ajax({
				url: base_url + module.get('route') + '/cs_discussion',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				success: function ( response ) {
					handle_ajax_message( response.message );

					if (typeof (response.notes) != 'undefined') {
		                $('.modal-container').html(response.notes);
		                $('.modal-container').modal();  
		                init_cs_discussion_button();        
		            }
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}

function init_cs_discussion_button()
{
	$('#cs_discussion_button').stop().click(function(){
		$.blockUI({ message: loading_message(),
			onBlock: function(){
				var data = $('form#note-form').serialize();
				$.ajax({
					url: base_url + module.get('route') + '/sendback_cs',
					type:"POST",
					data: data,
					dataType: "json",
					async: false,
					success: function ( response ) {
						handle_ajax_message( response.message );

						if(response.hasOwnProperty('notify'))
						{
							for(var i in response.notify)
								socket.emit('get_push_data', {channel: 'get_user_'+response.notify[i]+'_notification', args: { broadcaster: user_id, notify: true }});
						}

						if(response.redirect)
							window.location = base_url + module.get('route');
					}
				});
			},
			baseZ: 300000000
		});
		$.unblockUI();
	});
}

var rc = {
	rc1:[
		{min: 1, max: 1.74, code: 'DME'},
		{min: 1.75, max: 2.49, code: 'BME'},
		{min: 2.5, max: 3.24, code: 'ME'},
		{min: 3.25, max: 4, code: 'EE'}
	],
	rc2:[
		{min: 1, max: 1.74, code: 'NE'},
		{min: 1.75, max: 2.49, code: 'NSE'},
		{min: 2.5, max: 3.24, code: 'E'},
		{min: 3.25, max: 4, code: 'VE'}
	]
};