$(document).ready(function(){
	$('#training_revalida_master-course_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});

	$('.add-more').live('click',function(event){

		if( $(this).attr('rel') == 'category' ){

			event.preventDefault();
        	var url = base_url + module.get('route') + '/get_form/' + $(this).attr('rel');
        	var type = $(this).attr('rel');
        	var data = 'category_count=' + ( parseInt($('.category_count').val()) + 1 );

        	$.ajax({
	            url: url,
	            dataType: 'json',
	            type:"POST",
	            data: data,
	            success: function (response) {
					var category_count = parseInt($('.category_count').val());
		            $('.category_count').val( category_count + 1 );

		            $('fieldset.category').append(response.html);
	            }
	        });

		}
		else if( $(this).attr('rel') == 'item' ){

			var this_item = $(this);

			event.preventDefault();
        	var url = base_url + module.get('route') + '/get_form/' + $(this).attr('rel');
        	var type = $(this).attr('rel');
        	var data = 'category_rand='+this_item.parents('div.header_container').find('.category_rand').val()+'&item_count=' + ( parseInt(this_item.parents('div.header_container').find('.item_count').val()) + 1 );

        	$.ajax({
	            url: url,
	            dataType: 'json',
	            type:"POST",
	            data: data,
	            success: function (response) {
	            	var item_count = parseInt(this_item.parents('div.header_container').find('.item_count').val());
		            this_item.parents('div.header_container').find('.item_count').val( item_count + 1 );
		            this_item.parents('div.header_container').find('fieldset.item').append(response.html);
	            }
	        });
		}
	});

	$('.delete-detail').live('click', function () {

		var type = $(this).attr('rel');

		if( type == 'category' ){

			var category_count = parseInt($('.category_count').val());
		    $('.category_count').val( category_count - 1 );

		    $(this).parents('div.header_container').remove();

		}
		else if( type == 'item' ){

			var item_count = parseInt($(this).parents('.header_item_container').find('.item_count').val());
			var item_no = 0;
			var item_group = $(this).parents('.header_item_container');

			$(this).parents('.header_item_container').find('.item_count').val(item_count - 1);
			$(this).parents('.header_item_container').remove();

			item_group.find('.item_no').each(function(){

				if( item_no < item_count ){
					item_no++;
				}

				$(this).val(item_no);

			});

		}

	});		
});

function save_record( form, action, callback )
{
	$.blockUI({ message: saving_message(),
		onBlock: function(){

			var category_name_error = 0;
			var category_weigth_error = 0;
			var category_weigth_total_error = 0;
			var category_item_score_type_error = 0;
			var category_item_description_error = 0;
			var category_item_weigth_error = 0;
			var category_item_weigth_total_error = 0;
			var total_item_weigth = 0;
			var total_category_weigth = 0;

			$('.category_name').each(function(){
				if( $(this).val() == "" ){
					category_name_error++;
				}
			});

			$('.item_description').each(function(){
				if( $(this).val() == "" ){
					category_item_description_error++;
				}
			});

			$('.item_weigth').each(function(){

				var parse = parseInt($(this).val());

				if( $(this).val() == "" ){
					category_item_weigth_error++;
				}

				if( !parse ){
					category_weigth_total_error++;
				}

			});


			$('.category_weigth').each(function(){

				var parse = parseInt($(this).val());

				if( $(this).val() == "" ){
					category_weigth_error++;
				}

				if( !parse ){
					category_weigth_total_error++;
				}
				else{
					total_category_weigth += parse;
				}
			});

			$('.item_score_type').each(function(){
				if( $(this).val() == "" ){
					category_item_score_type_error++;
				}
			});

			if( category_name_error > 0 ){
		        notify('error', 'Please complete all category names.');
		        return false;	
			}

			if( category_weigth_error > 0 ){
		        notify('error', 'Please complete all category weights.');
		        return false;	
			}
			else{
				if( total_category_weigth != 100 ){
			        notify('error', 'All Category Weights must be total of 100%.');
			        return false;			
				}
			}

			if( category_item_description_error > 0 ){
		        notify('error', 'Please complete all item descriptions.');
		        return false;		
			}

			if( category_item_weigth_error > 0 ){
		        notify('error', 'Please complete all item weights.');
		        return false;
			}
			else{

				$('fieldset.item').each(function(){

					total_item_weigth = 0;

					$(this).find('.item_weigth').each(function(){

						var parse = parseInt($(this).val());
						total_item_weigth += parse;

					});

					if(total_item_weigth != 100 ){
						category_item_weigth_total_error++;
					}

				});

			}

			if( category_item_weigth_total_error > 0 ){
		        notify('error', 'All Item Weights per category must be total of 100%.');
		        return false;
			}

			if( category_item_score_type_error > 0 ){
		        notify('error', 'Please complete all item rating types.');
		        return false;
			}

			var data = form.find(":not('.dontserializeme')").serialize();
			$.ajax({
				url: base_url + module.get('route') + '/save',
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

						if (typeof(after_save) == typeof(Function)) after_save( response );
						if (typeof(callback) == typeof(Function)) callback( response );

						
/*						get_incumbent();
						get_to_hire();
						after_save();*/

						switch( action )
						{
							case 'new':
								document.location = base_url + module.get('route') + '/add';
								break;
							case 'back':
								document.location = base_url + module.get('route');
								break;								
							default:
								/*if (manpower_plan_status_id && manpower_plan_status_id != 2 && $('.btn-send').length == 0){
									$('.btn-savenew').after('<button type="button" class="btn green btn-sm btn-send" onclick="save_record( $(this).closest(&apos;form&apos;), \'back\', \'\', 2)">Send for Approval</button>');
								}*/
								break;
						}
					}
				}
			});
		},
		baseZ: 300000000
	});
	$.unblockUI();
}