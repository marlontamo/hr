function after_save( response ){
	if(response.action == 'insert'){
		socket.emit(
			'get_push_data', 
			{
				channel: 'get_user_notification',
				args: { 
					broadcaster: user_id,
					item: response.target,
					lgid: response.lgid,
					notify: true,
					type: response.type, 
				}
			}
		);
	}
}

$(document).on('ready', function(e) {
    init_fancybox();
    init_fancyboxPDF();
});

// Start Dashboard birthday handler
$(document).on('click', '.greetings', function (e) {
    e.preventDefault();

    var request_data = {
        celebrant_id: $(this).data('celebrant-id'),
        celebrant_name: $(this).data('celebrant-name'),
        birth_date: $(this).data('birth-date'),
        birth_string: $(this).data('birth-string'),
    };

    var header = request_data.celebrant_name + "<br><span class='small'>" + request_data.birth_string + "<span class='small text-muted'> - "+lang.dashboard.today+"</span>";

    $("#dlg-title").html(header);
    $('#input-greetings-update').data('birthday', request_data.birth_date);
    $('#input-greetings-update').data('celebrant-id', request_data.celebrant_id);

    $('#dashboard_dialog')
    	.css({'min-height' : '400px'});

    $('#dashboard_dialog').modal('show');

   	$('#birthday-greetings').block({
    	message: 'Retrieving greetings...',
        css: {
        	background: 'none',
            border: 'none',
            'z-index': '99999',
            width: '100%',
            height: '100%',
        },
        baseZ: 20000,
    });


    $.ajax({
        url: base_url + module.get('route') + '/get_birthday_greetings',
        type: "POST",
        async: false,
        data: request_data,
        dataType: "json",
        success: function (response) {
            if (typeof (response.greetings) != 'undefined') {
                $('#birthday-greetings').html(response.greetings);
            }

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }

            /*$(".body").each(function() {
                $(this).html(emojione.unicodeToImage($(this).html())); 
            });*/

            // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
            /*$(".body").each(function() {
                $(this).html(emojione.shortnameToImage($(this).html()));
            });*/
            

        }
    });
});

$(document).on('keypress', '#input-greetings-update', function (e) {
    if (e.which == 13) {
        submitBirthdayGreetings();
    } else return;
});

$(document).on('click', '#btn-greetings-update', function (e) {
    e.preventDefault();
    submitBirthdayGreetings();

});

var submitBirthdayGreetings = function () {

    if (!$("#input-greetings-update").val()) {
        $("#input-greetings-update").focus();
        return false;
    }

    var data = {
        new_greetings: $("#input-greetings-update").val(),
        birthday: $("#input-greetings-update").data('birthday'),
        celebrant: $("#input-greetings-update").data('celebrant-id')
    };
    
    $.ajax({
        url: base_url + module.get('route') + '/update_greetings',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function () {

            $("#input-greetings-update").attr('disabled', true);
            $("#icn-greetings-update").removeClass().addClass('fa fa-spinner icon-spin');
        },
        success: function (response) {
            setTimeout(function () {

                $("#input-greetings-update").val('');
                $("#input-greetings-update").attr('disabled', false);
                $("#btn-greetings-update").attr('disabled', false);
                $("#icn-greetings-update").removeClass().addClass('fa fa-check icon-white');

                if (typeof (response.greetings) != 'undefined') {

                    $(".greetings_container").prepend(response.greetings).fadeIn();
                    $('.greetings_container li.no-greetings').remove();
                    
                    // NOW NOTIFY THEM!!!
                    if (typeof (after_save) == typeof (Function)) after_save(response);
                    /*$(".body").each(function() {
                        $(this).html(emojione.unicodeToImage($(this).html())); 
                    });*/

                    // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
                    /*$(".body").each(function() {
                        $(this).html(emojione.shortnameToImage($(this).html()));
                    });*/
                }

            }, 1000);

            $.unblockUI();

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }
        }
    });
} 
// End Dashboard birthday handler

// Dashboard posting handler
$(document).on('keypress', '#input-post-update', function (e) {
    if (e.which == 13) {
        submitPost();
    } else return;
});

$(document).on('click', '#btn-post-update', function (e) {
    e.preventDefault();
    submitPost();
});

var submitPost = function () {

    if (!$("#input-post-update").val()) {
        $("#input-post-update").focus();
        return false;
    }

    var data = {
        new_post: $("#input-post-update").val(),
        recipient: $("#feed-tags").val(),
        feed_to: $('input[name="feed-to"]:checked').val(),
        items: $('li.feed_content').length,
        message_type: $("#message_type").val()
    };

    $.ajax({
        url: base_url + module.get('route') + '/update_post',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function () {

        	$('.feeds_form').block({message: ''});

            $("#input-post-update").attr('disabled', true);
            $("#btn-post-update").attr('disabled', true);
            $("#icn-post-update").removeClass().addClass('fa fa-spinner icon-spin');
        },
        success: function (response) {
            setTimeout(function () {

            	$('.feeds_form').unblock();
                $("#input-post-update").val('');
                $("#input-post-update").attr('disabled', false);
                $("#btn-post-update").attr('disabled', false);
                $("#icn-post-update").removeClass().addClass('fa fa-check icon-white');
                $("#feed-tags").tagsinput('removeAll');

                if (typeof (response.new_feed) != 'undefined') {

                    $(".feeds_container").prepend(response.new_feed).fadeIn();
                    var recipients = response.recipients;

                    switch( true )
                    {
                        case recipients.length > 1:
                        case recipients.length == 1 && recipients[0] != user_id:
                            for( var i in recipients )
                            {
                                if( recipients[i] != user_id ){
                                    socket.emit(
                                        'get_push_data', 
                                        {
                                            channel: 'get_user_'+recipients[i]+'_notification',
                                            args: { 
                                                broadcaster: user_id,
                                                item: response.target,
                                                lgid: response.lgid,
                                                notify: true,
                                                type: response.type, 
                                            }
                                        }
                                    );
                                }
                            }
                        break;
                        default:
                            socket.emit(
                                'get_push_data', 
                                {
                                    channel: 'get_user_notification',
                                    args: { 
                                        broadcaster: user_id,
                                        item: response.target,
                                        lgid: response.lgid,
                                        notify: true,
                                        type: response.type, 
                                    }
                                }
                            );
                        break;
                    }
                }
                /*$(".body").each(function() {
                    $(this).html(emojione.unicodeToImage($(this).html())); 
                });*/

                // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
                /*$(".body").each(function() {
                    $(this).html(emojione.shortnameToImage($(this).html()));
                });*/
                $(".message").find('textarea').each(function() {

                    var feeds_id = $(this).data('feeds-id');
                    var comment_id = $(this).data('comment-id');
                    var comment_count = $(this).data('comment-count');
                    var feeds_userid = $(this).data('feeds-userid');

                });
            }, 1000);

            $.unblockUI();

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }
        }
    });
}


    function filter_feeds(message_type){

       $('.feeds_container').empty();
       $('.feeds_container').infiniteScroll({
            dataPath: base_url + module.get('route') + '/filter_feeds',
            itemSelector: 'li.feed_content',

            onDataLoading: function(){ 
                $("#ajax-loader").show();
            },
            onDataLoaded: function(x, y, z){ 
                $("#ajax-loader").hide();
                init_pop_uri();
                init_readmore();
                /*$(".body").each(function() {
                    $(this).html(emojione.unicodeToImage($(this).html())); 
                });*/

                // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
                /*$(".body").each(function() {
                    $(this).html(emojione.shortnameToImage($(this).html()));
                });*/

                /*$(".message.com").find('span').each(function() {
                    $(this).html(emojione.shortnameToImage($(this).html()));
                });*/
                $(".message").find('textarea').each(function() {

                    var feeds_id = $(this).data('feeds-id');
                    var comment_id = $(this).data('comment-id');
                    var comment_count = $(this).data('comment-count');
                    var feeds_userid = $(this).data('feeds-userid');

                });
            },
            onDataError: function(){ 
                $("#ajax-loader").hide();
                return;
            },
            search: $('input[name="list-search"]').val(),
            filter: message_type
        });       
    }

var updateFeedTime = function () {

    $.ajax({
        url: base_url + module.get('route') + '/get_post_time',
        type: "POST",
        async: false,
        dataType: "json",
        beforeSend: function () {},
        success: function (response) {

            if (response.post_time) {

                for (var t in response.post_time) {
                    $("#feed-time-" + response.post_time[t].id).html(response.post_time[t].createdon);
                }
            }

            for (var i in response.message) {
                if (response.message[i].message != "") {
                    notify(response.message[i].type, response.message[i].message);
                }
            }
        }
    });
}

$(document).keydown(function (e) {
    if (e.keyCode === 27)
        $('.custom_popover').popover('hide');
});

$(document).on({
    mouseenter: function (e) { 
        e.preventDefault();
        $(this).popover('show'); 
       
    },
    mouseleave: function (e) { 
        e.preventDefault();
        $(this).popover('hide');
    }
  }, ".user_preview");

$(document).ready(function (e) {
    $('.portlet > .portlet-title > .tools > a[portlet]').each(function(){
        var portlet = $(this).attr('portlet');
        var el = $(this).closest(".portlet").children(".portlet-body"); 
        if( $.cookie(portlet) == "collapse" )
        {
            $(this).removeClass("expand").addClass("collapse");
            $(this).closest(".portlet").children(".portlet-title > .tools a").removeClass("expand").addClass("collapse");
            el.slideDown(200);
        }
    });

    $('.portlet > .portlet-title > .tools > a[portlet]').click(function(){
        var portlet = $(this).attr('portlet');
        if (jQuery(this).hasClass("collapse")) { 
            $.cookie(portlet, "expand", { expires: 365, path: '/' });
        } else {
            $.cookie(portlet, "collapse", { expires: 365, path: '/' });
        }
    });


    $.ajax({
        url: base_url + module.get('route') + '/check_default_pass',
        type: "POST",
        async: false,
        dataType: "json",
        beforeSend: function () {},
        success: function (response) {
            if (response.check_default) {
                update_password();
            }
            else{
                update_mobile();
            }
        }
    });

    //update_password();

    //update_mobile();

    setInterval(
        function () {
            updateFeedTime();
        }, 300000);

    if ( $.fn.infiniteScroll )
    {
	    $('.feeds_container').infiniteScroll({

	        dataPath: base_url + module.get('route') + '/index',
	        itemSelector: 'li.feed_content',

	        onDataLoading: function () {
	            $("#ajax-loader").show();
	        },

	        onDataLoaded: function (x, y) {
	            $("#ajax-loader").hide();
                init_pop_uri();
                init_readmore();
                init_fancybox();
                init_fancyboxPDF();
                /*$(".body").each(function() {
                    $(this).html(emojione.unicodeToImage($(this).html())); 
                });*/

                // if you save to db with value EmojioneArea saveEmojisAs: 'shortname'
                /*$(".body").each(function() {
                    $(this).html(emojione.shortnameToImage($(this).html()));
                });*/

                /*$(".message.com").find('span').each(function() {
                    $(this).html(emojione.shortnameToImage($(this).html()));
                });*/
                $(".message").find('textarea').each(function() {

                    var feeds_id = $(this).data('feeds-id');
                    var comment_id = $(this).data('comment-id');
                    var comment_count = $(this).data('comment-count');
                    var feeds_userid = $(this).data('feeds-userid');

                });
	        },

	        onDataError: function () {
	            $("#ajax-loader").hide();
	            return;
	        }
	    });
	}

    $('#demographic-filter').change(function(){
        if( $(this).val() != "" )
        {
            update_demographic_filter( $(this).val() );
        }
    });

    $('#demographic-filter-value').change(function(){
        if( $(this).val() != "" )
        {
            get_gender_stats();
        }    
    });

    get_todos();
    get_timekeeping_stats();
    get_gender_stats();
});

function update_demographic_filter( filter_by )
{
    $.ajax({
        url: base_url + module.get('route') + '/get_demographic_filter',
        type:"POST",
        async: false,
        dataType: "json",
        data: { filter_by: filter_by },
        beforeSend: function(){
        },
        success: function ( response ) {
            handle_ajax_message( response.message );

            $('#demographic-filter-value').html(response.filter);
        }
    });    
}

function init_pop_uri()
{
    $('a.pop-uri').click(function(){
        var permalink = $(this).attr('permalink');
        $.blockUI({ message: loading_message(), 
        onBlock: function(){
                $.ajax({
                    url: base_url + permalink,
                    type:"POST",
                    async: false,
                    dataType: "json",
                    beforeSend: function(){
                    },
                    success: function ( response ) {
                        handle_ajax_message( response.message );

                        if( typeof(response.html) != 'undefined' )
                        {
                            $('.modal-container').html(response.html);
                            $('.modal-container').modal();
                        }
                    }
                });
            }
        });
        $.unblockUI();  
    });
}

function init_fancybox()
{
    $(document).on("click", "a.fancybox-buttond", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.fancybox({
            autoSize: false,
            maxWidth: "75%", // keeps fancybox width in viewport - adjust to your preference
            fitToView: false, // allows extend fancybox outside viewport 
            autoCenter: false, // allows scroll fancybox along the body
            helpers: {
                overlay: {
                    locked: false // allows scrolling outside fancybox
                }
            },
            margin: [60, 0, 0, 0], // top, right, bottom, left
            scrolling: 'yes',
            width: '75%',
            //height: 'auto',
            content: '<embed src="'+this.href+'#nameddest=self&page=1&view=FitH,0&zoom=100,0,0" width="100%"/>',
            beforeClose: function() {
                $(".fancybox-inner").unwrap();
            }
        }); //fancybox
        return false;
    });
}

function init_fancyboxPDF()
{
    $(document).on("click", "a.fancybox-buttonPDF", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $.fancybox({
            autoSize: false,
            maxWidth: "90%", // keeps fancybox width in viewport - adjust to your preference
            fitToView: false, // allows extend fancybox outside viewport 
            autoCenter: false, // allows scroll fancybox along the body
            helpers: {
                overlay: {
                    locked: false // allows scrolling outside fancybox
                }
            },
            margin: [60, 0, 0, 0], // top, right, bottom, left
            scrolling: 'yes',
            width: '90%',
            //height: 'auto',
            content: '<embed src="'+this.href+'#nameddest=self&page=1&view=FitH,0&zoom=100,0,0" height="100%"  width="100%"/>',
            beforeClose: function() {
                $(".fancybox-inner").unwrap();
            }
        }); //fancybox
        return false;
    });
}

function refresh_todos()
{
    var el = $('a[portlet="todo"]').closest(".portlet").children(".portlet-body");
    if ($('a[portlet="todo"]').hasClass("expand"))
    {
        $('a[portlet="todo"]').removeClass("expand").addClass("collapse");
        $('a[portlet="todo"]').closest(".portlet").children(".portlet-title > .tools a").removeClass("expand").addClass("collapse");
        el.slideDown(200);
        $.cookie('todo', "collapse", { expires: 365, path: '/' });
    } 
    get_todos();
}

function get_todos()
{
    $('#todos-list li:not(#todos-loader)').remove();
    $('#todos-loader').show();
    $.ajax({
        url: base_url + module.get('route') + '/get_todos',
        type: "POST",
        async: false,
        dataType: "json",
        success: function (response) {
            $('#todos-loader').hide();
            if(response.count != 0)
            {
                $("#todo_badge").html(response.count);
            }   
            else
            {
                $(".show_more").hide();
            } 
            $('#todos-list').append(response.todos);
            init_popover();
        }
    });
}

function refresh_timekeeping_stats()
{
    var el = $('a[portlet="time_stats"]').closest(".portlet").children(".portlet-body");
    if ($('a[portlet="time_stats"]').hasClass("expand"))
    {
        $('a[portlet="time_stats"]').removeClass("expand").addClass("collapse");
        $('a[portlet="time_stats"]').closest(".portlet").children(".portlet-title > .tools a").removeClass("expand").addClass("collapse");
        el.slideDown(200);
        $.cookie('time_stats', "collapse", { expires: 365, path: '/' });
    } 
    get_timekeeping_stats();
}

function get_timekeeping_stats()
{
    $('#timekeeping-stats-loader').show();
    $.ajax({
        url: base_url + module.get('route') + '/get_timekeeping_stats',
        type: "POST",
        async: false,
        dataType: "json",
        success: function (response) {
            $('#timekeeping-stats-loader').hide();
            $('#timekeeping-stats-container').html(response.stat_graph);
            var stats = response.stats;
            switch( true )
            {
                case stats.attendance < 26:
                    var a_color = App.getLayoutColorCode('red')
                    break;
                case stats.attendance < 51:
                    var a_color = App.getLayoutColorCode('orange');
                    break;
                case stats.attendance < 76:
                    var a_color = App.getLayoutColorCode('yellow');
                    break;
                default:
                    var a_color = App.getLayoutColorCode('green');
            }

            switch( true )
            {
                case stats.dispute < 26:
                    var d_color = App.getLayoutColorCode('green')
                    break;
                case stats.dispute < 51:
                    var d_color = App.getLayoutColorCode('yellow');
                    break;
                case stats.dispute < 76:
                    var d_color = App.getLayoutColorCode('orange');
                    break;
                default:
                    var d_color = App.getLayoutColorCode('red');
            }

            $('.easy-pie-chart .attendance').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: a_color
            });

            $('.easy-pie-chart .dispute').easyPieChart({
                animate: 1000,
                size: 75,
                lineWidth: 3,
                barColor: d_color
            });
        }
    });
}

function refresh_gender_stats()
{
    var el = $('a[portlet="demographics"]').closest(".portlet").children(".portlet-body");
    if ($('a[portlet="demographics"]').hasClass("expand"))
    {
        $('a[portlet="demographics"]').removeClass("expand").addClass("collapse");
        $('a[portlet="demographics"]').closest(".portlet").children(".portlet-title > .tools a").removeClass("expand").addClass("collapse");
        el.slideDown(200);
        $.cookie('demographics', "collapse", { expires: 365, path: '/' });
    } 
    get_gender_stats();
}

function get_gender_stats()
{
    $('#gender-stats-loader').show();
    $('#gender-stats-container').hide();
    $.ajax({
        url: base_url + module.get('route') + '/get_gender_stats',
        type: "POST",
        async: false,
        dataType: "json",
        data: {filter: $('#demographic-filter').val(), filter_value: $('#demographic-filter-value').val() },
        success: function (response) {
            $('#gender-stats-loader').hide();
            $('#gender-stats-container').html( response.stat );
            $('#gender-stats-container').show();
			
			$('#population_stats').slimScroll({
                wheelStep: 5,
				height: '200px'
            });

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

function init_popover()
{
    $('.custom_popover')
    .popover({
        trigger: 'manual',
        title: '',
        content: '',
        html: true
    })
    .on('click', showTodoQuickView)
    .parent()
    .delegate('button.close-pop', 'click', function (e) {
        e.preventDefault();
        $('.custom_popover').popover('hide');
    })
    .delegate('button.approve-pop', 'click', function (e) {

        e.preventDefault();
        var form_id     = $(this).data('forms-id');
        var user_id     = $(this).data('user-id');
        var user_name   = $(this).data('user-name');
        var form_owner  = $(this).data('form-owner');
        var form_name   = $(this).data('form-name');
        var decission   = $(this).data('decission');

       comment = $("#comment-" + form_id).val();

        var data = {
            formid: form_id,
            userid: user_id,
            username: user_name,
            decission: decission,
            formownerid: form_owner,
            formname: form_name,
            comment: comment
        };

        submitDecission(data);
    })
    .delegate('button.decline-pop', 'click', function (e) {

        e.preventDefault();
        var form_id = $(this).data('forms-id');
        var user_id = $(this).data('user-id');
        var form_owner  = $(this).data('form-owner');
        var decission = $(this).data('decission');
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
            decission: decission,
            comment: comment,
            formownerid: form_owner
        };

        submitDecission(data);
    });
}

var showTodoQuickView = function (e) {

        e.preventDefault();
        $('.custom_popover').not(this).popover('hide')
        $(this).popover('show');
    }, hideTodoQuickView = function (e) {

            e.preventDefault();
            $(this).popover('hide');
        };

    var submitDecission = function (data) {

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

                $('.custom_popover').popover('hide');
                if (response.action == 'insert') {
                    after_save(response);
                    $('#todo-lst-' + data.formid).fadeOut().hide();
                }
                // 1. now reload the todo contents
                // 2. update badge count
                $.ajax({
                    url: base_url + module.get('route') + '/get_todos',
                    type: "POST",
                    async: false,
                    dataType: "json",
                    success: function (response) {
                        $("#todo_badge").html(response.count);
                    }
                });
            }
        });
    };

function hbd_showmore( nxt, button )
{
    for( var i = nxt; i < (nxt + 5); i++ )
    {
        $('li.toggle-'+i).removeClass('hidden');
    }
    
    $('li.toggler-'+(i-1)).removeClass('hidden');
    $('li.toggler-'+(nxt-1)).remove();
}

function todo_showmore()
{
    $('li.todo_more').removeClass('hidden');
    $('.show_more').hide();
}

function comments_showmore( nxt, button, feeds_id )
{
    for( var i = nxt; i > (nxt - 5); i-- )
    {
        $('#comment-list-'+feeds_id+' li.comment-toggle-'+i).removeClass('hidden');
    }
    $('#comment-list-'+feeds_id+' li.comment-toggler-'+(i-1)).removeClass('hidden');
    $('#comment-list-'+feeds_id+' li.comment-toggler-'+(nxt-1)).remove();
}

$(document).on('input.textarea', '.comment_box', function(){
  var minRows = this.getAttribute('data-min-rows')|0,
        rows    = this.value.split("\n").length;
  this.rows = rows < minRows ? minRows : rows;
});

//Comment posting handler
$(document).on('keypress', '.comment_box', function (e) {
    //&& str.replace(/^\s\s*/, '').replace(/\s\s*$/, '')
    var comment = this.value;
    trimmed_comment = comment.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    if (e.which == 13 && (trimmed_comment != "")) {
        var feeds_id = $(this).data('feeds-id');
        var comment_id = $(this).data('comment-id');
        var comment_count = $(this).data('comment-count');
        var feeds_userid = $(this).data('feeds-userid');
        submitComment(comment_id, feeds_id, trimmed_comment, comment_count, feeds_userid)
    } else return;
});



function submitComment(comment_id, feeds_id, trimmed_comment, comment_count, feeds_userid) {
    var data = {
        feeds_id: feeds_id,
        trimmed_comment: trimmed_comment,
        comment_id: comment_id,
        comment_count: comment_count,
        feeds_userid: feeds_userid
    };

    $.ajax({
        url: base_url + module.get('route') + '/save_comment',
        type: "POST",
        async: false,
        data: data,
        dataType: "json",
        beforeSend: function () {
            $('.comment_box').block({message: ''});
        },
        success: function (response) {
                $('.comment_box').unblock();
                $('.comment_box').val('');
                $('#comment_box_'+feeds_id).attr('rows', '1');
                if (typeof (response.comment_feed) != 'undefined') {
                    if(response.action=='update'){
                        $('.comment-list-item-'+response.record_id).html(response.edit_comment);
                        /*$('.comment-list-item-'+response.record_id).each(function() {
                            $(this).html(emojione.shortnameToImage($(this).html()));
                        });*/ 
                    }else{
                        $(response.new_comment).insertBefore("#insert_comment-"+feeds_id).fadeIn();
                    }
                }

            $.unblockUI();
            /*$(".comment-toggle-").find('span').each(function() {
                $(this).html(emojione.shortnameToImage($(this).html()));
            });*/ 
        }
    });

}

function delete_comment( record_id, callback )
{
    bootbox.confirm("Are you sure you want to delete this comment?", function(confirm) {
        if( confirm )
        {
            _delete_comment( record_id, callback );
        } 
    });
}

function _delete_comment( records, callback )
{
    $.ajax({
        url: base_url + module.get('route') + '/delete_comment',
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

// edit comment
$(document).on('click', '.edit-comment', function (e) {
    e.preventDefault();
    var data = {
        comment_feeds_id: $(this).data('comment-commentid'),
        id: $(this).data('comment-feedsid'),
        user_id: $(this).data('comment-userid'),
        comment: $(this).data('comment-comment'),
        fuserid: $(this).data('comment-fuserid')
    };
    edit_comment( $(this).data('comment-commentid'), data );

});

function edit_comment( comment_feeds_id, data )
{    
    if(comment_feeds_id > 0){
    $.ajax({
        url: base_url + module.get('route') + '/edit_comment',
        type:"POST",
        data: data,
        dataType: "json",
        async: false,
        beforeSend: function () {
            $('.comment-list-item-'+comment_feeds_id).block({message: ''});
        },
        success: function (response) {            
            $('.comment-list-item-'+comment_feeds_id).unblock();
            if (typeof (response.comment_feed) != 'undefined') {
                $('.comment-list-item-'+comment_feeds_id).html(response.edit_comment);
                // $(response.new_comment).insertBefore("#insert_comment-"+feeds_id).fadeIn();
            }
            $(".message").find('textarea').each(function() {
                    //$(this).html(emojione.shortnameToImage($(this).html()));

                    var feeds_id = $(this).data('feeds-id');
                    var comment_id = $(this).data('comment-id');
                    var comment_count = $(this).data('comment-count');
                    var feeds_userid = $(this).data('feeds-userid');

                });
        $.unblockUI();
        }
    });
    }
}

$(document).on('keypress', '#partners_personal-mobile', function (e) {  
    if (e.which == 13) {
        e.preventDefault();
        update_mobilephone($(this));
    } else return;
});

function update_password(){  
    $.ajax({
        url: base_url + 'get_password_form',
        type:"POST",
        dataType: "json",
        async: false,
        success: function ( response ) {
            $('.modal-container').attr('data-width', '500');
            $('.modal-container').html(response.password_form);
            $('.modal-container').modal({
                backdrop: 'static',
                keyboard: false
            });
            init_password_form();
            $('input[name="current_password"]').val('password'),
            $('.cur_pass').closest('div').hide();

            $('.modal-container').on('hidden.bs.modal', function () {
                update_mobile();
            })            
        }
    });
}

function update_mobile(){    
    $.ajax({
        url: base_url + module.get('route') + '/update_mobile',
        type:"POST",
        async: false,
        dataType: "json",
        beforeSend: function(){
                    // $('body').modalmanager('loading');
                },
                success: function ( response ) {

                    if( typeof(response.update_mobile) != 'undefined' )
                    {

                        if ($.cookie('page_visited') != 'yes' ){
                            $('#prompt_sms').html(response.update_mobile);
                            $('#prompt_sms').modal();    

                            $.cookie("page_visited", 'yes', { path: '/' });  
                            for( var i in response.message )
                            {
                                if(response.message[i].message != "")
                                {
                                    var message_type = response.message[i].type;
                                    notify(response.message[i].type, response.message[i].message);
                                }
                            } 
                        }else{
                            // console.log($.cookie('page_visited'));
                            // console.log("else");
                        }
                    }

                }
        }); 
}

function update_mobilephone(form){
    var mobile = $('#partners_personal-mobile').val();
    $.ajax({
        url: base_url + module.get('route') + '/update_mobilephone',
        type:"POST",
        async: false,
        data : "partners_personal[mobile]=" + mobile ,
        dataType: "json",
        beforeSend: function(){
                    // $('body').modalmanager('loading');
                },
                success: function ( response ) {

                    if(response)
                    {   
                        for( var i in response.message )
                        {
                            if(response.message[i].message != "")
                            {
                                var message_type = response.message[i].type;
                                notify(response.message[i].type, response.message[i].message);
                            }
                        }

                        if(response.invalid){
                            $('#invalid_mobile').html(response.invalid_message);
                        }else{
                            $('#invalid_mobile').html('');                        
                            $('#prompt_sms').modal('hide');
                        }
                    }

                }
        }); 
}


function internal_hiring(request_id, position){
    var request_data = {
        request_id: request_id,
        position: position
    };

    $.blockUI({ message: loading_message(), 
    onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/internal_hiring',
                type:"POST",
                async: false,
                data : request_data,
                dataType: "json",
                beforeSend: function(){
                },
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( typeof(response.internal_hiring) != 'undefined' )
                    {
                        $('#internal_hiring_modal').html(response.internal_hiring);
                        $('#internal_hiring_modal').modal();  
                    }
                }
            });
        }
    });
    $.unblockUI();  
}

function save_internal_hiring(request_id){
    var request_data = {
        request_id: request_id,
        cover_letter: $('#cover_letter').val(),
        position: $('#position').val()
    }; 
    $.blockUI({ message: loading_message(), 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/save_internal_hiring',
                type:"POST",
                async: false,
                data : request_data,
                dataType: "json",
                beforeSend: function(){
                            // $('body').modalmanager('loading');
                        },
                        success: function ( response ) {

                            if(response)
                            { 
                                for( var i in response.message )
                                {
                                    if(response.message[i].message != "")
                                    {
                                        var message_type = response.message[i].type;
                                        notify(response.message[i].type, response.message[i].message);
                                    }
                                }                      
                                $('#internal_hiring_modal').modal('hide');
                            }

                        }
            }); 
        }
    });
    $.unblockUI();  
}

//close popover once orientation change
window.addEventListener("orientationchange", function() {
    $('.custom_popover').popover('hide');
}, false);

//dashboard only
function get_user_notification(user_id, data){ 
    $.ajax({
        url: base_url + module.get('route') + '/get_user_notification',
        type:"POST",
        data: {user_id: user_id, notif_data: data},
        dataType: "json",
        async: false,
        success: function ( response ) {
            if(response.total_notification > 0){

                notify('info', lang.alert.new_notification);
                $('#header_notification_bar span.badge').html( response.total_notification );
                $(".feeds_container").prepend(response.feed_latest).fadeIn(); 
            }

            if (typeof (response.greetings) != 'undefined') {

                $('#birthday-greetings').prepend(response.greetings);
            }

            $('#header_notification_bar li#notification-summary').html( '<p>'+lang.alert.you_have+' '+response.total_unread+' '+lang.alert.new_notification_s+'</p>' ); 
            $('#header_notification_bar ul#notification-detail').html('');

            for(var i in response.notification){

                $('#header_notification_bar ul#notification-detail').append( response.notification[i] );    
            }
        }
    }); 
}

function view_post(feed_id)
{
    $.ajax({
        url: base_url + module.get('route') + '/view_post',
        type:"POST",
        data: {feed_id: feed_id},
        dataType: "json",
        async: false,
        success: function ( response ) {
            // console.log(response);
            
            $('.likes-'+feed_id).remove();

            if(response.like_str != "")
            {
                $('.comments-'+feed_id).prepend(response.like_str);
            }

            socket.emit('get_push_data', 
                {
                    channel: 'update_feed_like',
                    args: { 
                        broadcaster: user_id,
                        feed_id: feed_id 
                    }
                }
            );  
        }
    });
}

function feed_like( feed_id, element )
{
    var status = 0;
    if( element.hasClass('btn-default') )
    {
        element.removeClass('btn-default');
        element.addClass('btn-success');
        status = 1;
    }
    else{
        element.removeClass('btn-success');
        element.addClass('btn-default');
    }

    $.ajax({
        url: base_url + module.get('route') + '/feed_like',
        type:"POST",
        data: {feed_id: feed_id, status: status},
        dataType: "json",
        async: false,
        success: function ( response ) {
            $('.likes-'+feed_id).remove();

            if(response.like_str != "")
            {
                $('.comments-'+feed_id).prepend(response.like_str);
            }

            socket.emit('get_push_data', 
                {
                    channel: 'update_feed_like',
                    args: { 
                        broadcaster: user_id,
                        feed_id: feed_id 
                    }
                }
            );  
        }
    });
}

function update_feed_like( feed_id )
{
    $.ajax({
        url: base_url + module.get('route') + '/update_feed_like',
        type:"POST",
        data: {feed_id: feed_id},
        dataType: "json",
        async: false,
        success: function ( response ) {
            $('.likes-'+feed_id).remove();

            if(response.like_str != "")
            {
                $('.comments-'+feed_id).prepend(response.like_str);
            } 
        }
    });    
}

socket.on('update_feed_like', function (data) {
    try {
        update_feed_like(data.feed_id);
    }
    catch(err) {
        // Handle error(s) here
    }
});
