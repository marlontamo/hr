$(document).ready(function(e) { 
    $('.filter-type').click(function(){
        $('.filter-type').removeClass('label-success');
        $('.filter-type').addClass('label-default');
        $(this).removeClass('label-default');
        $(this).addClass('label-success')
        create_list();
    });

    $('.filter-type-status').click(function(){
        $('.filter-type-status').removeClass('label-success');
        $('.filter-type-status').addClass('label-default');
        $(this).removeClass('label-default');
        $(this).addClass('label-success')

        create_list_status();
    }); 

});

function create_list()
{
    var search = $('input[name="list-search"]').val();
    var filter_by = {
        year: $('.filter-type.label-success').attr('filter_value')
    }
    var filter_value = $('.filter-type.active').attr('filter_value');

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

function create_list_status()
{
    var search = $('input[name="list-search"]').val();
    var filter_by = {
        status_id: $('.filter-type-status.label-success').attr('filter_value')
    }
    var filter_value = $('.filter-type-status.active').attr('filter_value');

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