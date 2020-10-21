$(document).ready(function(){
//$('.mix-grid').mixitup();
	init_fancybox();

	$('.list-filter').unbind('click').click(function(){
		$('.list-filter').removeClass('label-success');
		$('.list-filter').addClass('label-info');
		$(this).removeClass('label-info');
		$(this).addClass('label-success');

		create_list();
	});	


});

function init_fancybox()
{
    $(document).on("click", "a.fancybox-buttond", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.fancybox({
        	autoSize: false,
        	maxWidth: "80%", // keeps fancybox width in viewport - adjust to your preference
	        fitToView: false, // allows extend fancybox outside viewport 
	        autoCenter: false, // allows scroll fancybox along the body
	        helpers: {
	            overlay: {
	                locked: false // allows scrolling outside fancybox
	            }
	        },
        	margin: [70, 0, 0, 0], // top, right, bottom, left
            scrolling: 'no',
            width: '80%',
            height: 'auto',
            content: '<embed src="'+this.href+'#nameddest=self&page=1&view=FitH,0&zoom=80,0,0" width="100%"/>',
            beforeClose: function() {
                $(".fancybox-inner").unwrap();
            }
        }); //fancybox
        return false;
    });
}

function create_list()
{
	var search = $('input[name="list-search"]').val();
	var filter_by = $('.list-filter.label-success').attr('filter_by');
	var filter_value = $('.list-filter.label-success').attr('filter_value');
	
	$('#record-list').empty().die().infiniteScroll({
		dataPath: base_url + module.get('route') + '/get_photos_list/'+$('input[name="group_id"].filter').val(),
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

