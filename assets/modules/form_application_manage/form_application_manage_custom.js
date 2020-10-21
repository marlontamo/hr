$(document).ready(function(){

    if (jQuery().infiniteScroll){
        $('#form-list').infiniteScroll({
            dataPath: base_url + module.get('route') + '/get_list',
            itemSelector: 'tr.record',
            onDataLoading: function(){ 
                $("#loader").show();
            },
            onDataLoaded: function(x, y, z){ 
                $("#loader").hide();

                if( x <= 0 ){
                    $('.well').show();
                }
                else{
                    $('.well').hide();
                }

                initPopup();

            },
            onDataError: function(){ 
                return;
            },
            search: $('input[name="list-search"]').val()
        });

        $('form#list-search').submit(function( event ) {
            event.preventDefault();
            $('#form-list').infiniteScroll('search');
        }); 

        $('form#list-search-mobile').submit(function( event ) {
                event.preventDefault();
                $('input[name="list-search"]').val( $('input[name="list-search-mobile"]').val() );
                $('#form-list').infiniteScroll('search');
            }); 

        $('input[name="list-search"]').live('keypress',function(){
                $('#form-list').infiniteScroll('search');
            });

            $('input[name="list-search-mobile"]').live('keypress',function(){
                $('input[name="list-search"]').val( $('input[name="list-search-mobile"]').val() );
                $('#form-list').infiniteScroll('search');
            });

    }

	if( $('#goto_vl_co').length > 0 ){
		$('#change_options').hide();
        get_selected_dates($('#record_id').val(), $('#form_status_id').val(), '', '');
   }

   // $('.form-filter').click(function(){

   //      $('.form-filter').each(function(){
   //          if( $(this).hasClass('label-info') ){
   //              $(this).removeClass('label-info').addClass('label-default');
   //          }
   //      });

   //      /** start - for status filter **/
   //      var form_id = "form_id=" + $(this).data('form-id');
   //      var approver_status_id = "approver_status_id=" + $(this). data('approver-status-id');
   //      var form_filter = form_id + "/" + approver_status_id;
   //      /** end - for status filter **/

   //      if( $(this).hasClass('option') == true ){

   //          $('.form-filter').each(function(){

   //              if( !$(this).hasClass('option') && $(this).data('form-id') == $(this).data('form-id') ){

   //                  $(this).removeClass('label-default').addClass('label-info');

   //              }


   //          });

   //      }
   //      else{

   //          $(this).removeClass('label-default').addClass('label-info');

   //      }

   //     $('#form-list').empty();
   //     $('#form-list').infiniteScroll({
   //          dataPath: base_url + module.get('route') + '/get_list',
   //          itemSelector: 'tr.record',
   //          onDataLoading: function(){ 
   //              $("#loader").show();
   //          },
   //          onDataLoaded: function(x, y, z){ 
   //              $("#loader").hide();

   //              if( x <= 0 ){
   //                  $('.well').show();
   //              }
   //              else{
   //                  $('.well').hide();
   //              }

   //              initPopup();

   //          },
   //          onDataError: function(){ 
   //              return;
   //          },
   //          search: $('input[name="list-search"]').val(),
   //          filter: form_filter
   //      });

   //  });

   $('#goto_vl_co').click(function () {
    	$('#main_form').hide();
        $('.form-actions').hide();
    	$('#change_options').show();
    });

   $('#back_form_details').click(function(){
   		$('#main_form').show();
        $('.form-actions').show();
    	$('#change_options').hide();
   });
   $('.approve_view').click(function(){

        var form_id     = $(this).data('forms-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var form_owner  = $(this).data('form-owner');
        var form_name   = $(this).data('form-name');
        var decission   = $(this).data('decission');

        // if (!$("#comment-" + form_id).val()) {
        //     $("#comment-" + form_id).focus();
        //     return false;
        // } else {
            comment = $("#comment-" + form_id).val();
        // }

        var data = {
            formid: form_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            formownerid: form_owner,
            formname: form_name,
            comment: comment
        };

        submitDecission(data,'detail');

   });

   $('.disapprove_view').click(function(){

        var form_id = $(this).data('forms-id');
        var user_id = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var form_owner  = $(this).data('form-owner');
        var form_name   = $(this).data('form-name');
        var decission = $(this).data('decission');
        var comment = '';

        if (!$("#comment-" + form_id).val()) {
            $("#comment-" + form_id).focus();
            return false;
        } else {
            comment = $("#comment-" + form_id).val();
        }

        var data = {
            formid: form_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            formownerid: form_owner,
            formname: form_name,
            comment: comment
        };

        submitDecission(data,'detail');

   });

   $('.cancel_view').click(function(){

        var form_id = $(this).data('forms-id');
        var user_id = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var form_owner  = $(this).data('form-owner');
        var form_name   = $(this).data('form-name');
        var decission = $(this).data('decission');
        var comment = '';

        if (!$("#comment-" + form_id).val()) {
            $("#comment-" + form_id).focus();
            return false;
        } else {
            comment = $("#comment-" + form_id).val();
        }

        var data = {
            formid: form_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            formownerid: form_owner,
            formname: form_name,
            comment: comment
        };

        submitDecission(data,'detail');

   });
   
    $('.filter-paydate').click(function(){
        $('.filter-paydate').removeClass('label-success');
        $('.filter-paydate').addClass('label-default');
        $(this).removeClass('label-default');
        $(this).addClass('label-success')
        create_list();
    });
    $('.form-filter').click(function(){
        $('.form-filter').removeClass('label-success');
        $('.form-filter').addClass('label-default');
        $(this).removeClass('label-default');
        $(this).addClass('label-success')
        create_list();
    });
    $('.status-filter').click(function(){
        $('.status-filter').removeClass('label-success');
        $('.status-filter').addClass('label-default');
        $(this).removeClass('label-default');
        $(this).addClass('label-success')
        create_list();
    }); 
});

function create_list()
{
    var search = $('input[name="list-search"]').val();
    var filter_by = {
        pay_date: $('.filter-paydate.label-success').attr('filter_value'),
        form_id: $('.form-filter.label-success').attr('filter_value'),
        form_status_id: $('.status-filter.label-success').attr('filter_value'),
    }
    var filter_value = $('.status-filter.label-success').attr('filter_value');

    $('#form-list').empty().die().infiniteScroll({
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

function submitDecission(data,view) {
    $.blockUI({ message: saving_message(),
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/forms_decission',
                type: "POST",
                async: false,
                data: data,
                dataType: "json",
                beforeSend: function () {

                    $('.popover-content').block();
                },
                success: function (response) {
                    $('.popover-content').unblock();
                    for (var i in response.message) {
                        notify(response.message[i].type, response.message[i].message);
                    }

                    if (response.action == 'insert') {
                        after_save(response);
                    }
                    if( view == 'index' ){

                        $('.custom_popover').popover('hide');

                        $('#form-list').empty();

                        $('#form-list').infiniteScroll({
                            dataPath: base_url + module.get('route') + '/get_list',
                            itemSelector: 'tr.record',
                            onDataLoading: function(){ 
                                $("#loader").show();
                            },
                            onDataLoaded: function(x, y, z){ 
                                $("#loader").hide();
                                initPopup();
                            },
                            onDataError: function(){ 
                                return;
                            },
                            search: $('input[name="list-search"]').val()
                        });
                        $('.modal-container').modal('hide');
                    }
                    else{
                        setTimeout(function(){window.location.replace(base_url + module.get('route'))},2000);
                    }
                }
            });
        },
        baseZ: 300000000
    });
    setTimeout(function(){$.unblockUI()},2000);
}

function initPopup(){

    var showTodoQuickView = function (e) {
        e.preventDefault();
        $('.custom_popover').not(this).popover('hide')
        $(this).popover('show');
        //$(this).popover('toggle');
    }
    , hideTodoQuickView = function (e) {
        e.preventDefault();
        $(this).popover('hide');
    };

    $('.custom_popover').on('click', function(e){
        e.preventDefault();
    });

    $('.custom_popover')
        .popover({ 
            trigger: 'manual', 
            title: '', 
            content: '', 
            html:true })
        .on('click', showTodoQuickView)
        .parent()
        .delegate('button.close-pop', 'click', function(e) {
            e.preventDefault();
            $('.custom_popover').popover('hide');
        })
        .delegate('button.approve-pop', 'click', function(e) {
            e.preventDefault();
            //$('.custom_popover').popover('hide');
            //console.log('now update forms set selected item to approved!');

            
            var form_id     = $(this).data('forms-id');
            var user_id     = $(this).data('user-id');
            var user_name   = $(this).data('user-name');
            var form_owner  = $(this).data('form-owner');
            var form_name   = $(this).data('form-name');
            var decission   = $(this).data('decission');

            // if (!$("#comment-" + form_id).val()) {
            //     $("#comment-" + form_id).focus();
            //     return false;
            // } else {
                comment = $("#comment-" + form_id).val();
            // }

            var data = {
                formid: form_id,
                userid: user_id,
                username: user_name,
                decission: decission,
                formownerid: form_owner,
                formname: form_name,
                comment: comment
            };

            submitDecission(data,'index');


        })
        .delegate('button.decline-pop', 'click', function(e) {
            e.preventDefault();
            //console.log('now update forms set selected item to declined!');

            var form_id     = $(this).data('forms-id');
            var user_id     = $(this).data('user-id');
            var user_name   = $(this).data('user-name');
            var form_owner  = $(this).data('form-owner');
            var form_name   = $(this).data('form-name');
            var decission   = $(this).data('decission');
            var comment = '';

            if (!$("#comment-" + form_id).val()) {
                $("#comment-" + form_id).focus();
                notify("warning", "The Remarks field is required");
                return false;
            } else {
                comment = $("#comment-" + form_id).val();
            }

            var data = {
                formid: form_id,
                userid: user_id,
                username: user_name,
                decission: decission,
                formownerid: form_owner,
                formname: form_name,
                comment: comment
            };

            submitDecission(data,'index');


        });


}

function back_to_mainform(cancel){
        if(cancel==1){
            get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());    
        }
        $('#change_options').hide();
        $('#main_form').show();
        $('.form-actions').show();
    }

function get_selected_dates(forms_id, form_status_id, date_from, date_to){
    $.ajax({
        url: base_url + module.get('route') + '/get_selected_dates',
        type:"POST",
        async: false,
        data: 'forms_id='+forms_id+'&form_status_id='+form_status_id+'&date_from='+date_from+'&date_to='+date_to+'&view='+$('#view').val(),
        dataType: "json",
        success: function ( response ) {
            $('#change_options').html(response.selected_dates);
            $('#days').html(response.days);
        }
    });
}

function get_form_details(form_id, forms_id){
    $.ajax({
        url: base_url + module.get('route') + '/get_form_details',
        type:"POST",
        async: false,
        data: 'form_id='+form_id+'&forms_id='+forms_id,
        dataType: "json",
        success: function ( response ) {
            $('#manage_dialog-'+forms_id).attr('data-content', response.form_details);
        }
    });
}

function after_save( response ){    

    //console.log('PERFORMING NODE+SOCKET NOTIFICATION AND LOADING...');
   // console.log('THE RESPONSE DATA: ');
    //console.log(response);
    //console.log('CURRENT USER ID: ');
    //console.log(user_id);
    
    if(response.action == 'insert'){

        if(response.type == 'feed'){ console.log('you have just been FED up!!!... ');


            /*!*
            * The following are socket actions performing
            * dashboard feed notification and post feed
            * broadcast.
            **/

            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
            
            // autoload feeds to their respective recipient/s
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_feed', 
                    args: { 
                        broadcaster: user_id,
                        target: response.target, 
                        notify: false 
                    }
                }
            );
        }
        else if(response.type == 'greetings'){ console.log('loading greetings!!!... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Birthday Greetings notifications
            * broadcast.
            **/
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );
        }
        else if(response.type == 'todo'){ console.log('commencing to do... ');

            /*!*
            * The following is/are socket actions performing
            * dashboard Todo notification and Todo update 
            * broadcast on/with their respective recipient.
            **/

            // notify recipients with the results of their
            // submitted forms
            socket.emit(
                'get_push_data', 
                {
                    channel: 'get_notification', 
                    args: { 
                        broadcaster: user_id, 
                        notify: true 
                    }
                }
            );          
        }

    }
}

function reassign_approver(approver_id, forms_id){

    var request_data = {approver_id: approver_id, forms_id: forms_id};  
    $.blockUI({ message: '<div>Loading...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
     onBlock: function(){
        $.ajax({
            url: base_url + module.get('route') + '/reassign_approver',
            type:"POST",
            async: false,
            data: request_data,
            dataType: "json",
            beforeSend: function(){
            },
            success: function ( response ) {
                if( typeof(response.edit_reassign_approver) != 'undefined' ){

                    $('#reassign_approver_modal').html(response.edit_reassign_approver);
                    $('#reassign_approver_modal').attr('data-width', '450');
                    $('#reassign_approver_modal').modal('show');

                    $('#new_approver').select2({
                        placeholder: "Select an option",
                        minimumInputLength: 1
                    });
                }
                handle_ajax_message( response.message );
            }            
        });
     }
    });
    $.unblockUI();   
}

function update_approver(  )
{
    $.blockUI({ message: '<div>Updating approver, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        onBlock: function(){
            var new_approver = $('#new_approver').val();
            var current_approver_id = $('#current_approver_id').val();
            var forms_id = $('#forms_id').val();
            $.ajax({
                url: base_url + module.get('route') + '/update_approver',
                type:"POST",
                data: { new_approver : new_approver,
                        current_approver_id : current_approver_id,
                        forms_id : forms_id
                },
                dataType: "json",
                async: false,
                success: function ( response ) {
                    $('.modal').modal('hide');
                    handle_ajax_message( response.message );

                    if(response.saved )
                    {
                        setTimeout(function(){window.location.replace(base_url + module.get('route'))},1000);
                        // window.location.replace(base_url + module.get('route'));
                    }
                }
            });
        }
    });
    $.unblockUI();
}

function selectedDates_showmore( nxt, button )
{
    for( var i = nxt; i <= (nxt + 5); i++ )
    {
        $('span.toggle-'+i).removeClass('hidden');
    }
    
    $('span.toggler-'+(i-1)).removeClass('hidden');
    $('span.toggler-'+(nxt)).remove();
}

//close popovers once orientation change
window.addEventListener("orientationchange", function() {
    $('.custom_popover').popover('hide');
    $( ".btn-group" ).trigger( "click" );
}, false);                                  




