
$(document).ready(function(){
    $('.approve_view').click(function(){
        var elem = $(this);
        bootbox.confirm({
            message: "Are you sure you want to approve?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result){
                    var plan_id     = $(elem).data('plan-id');
                    var decission   = $(elem).data('decission');
                    var data = {
                        plan_id: plan_id,
                        decission: decission,
                    };

                    submitDecission(data,'detail');                    
                }
                else{
                    return;
                }
            }
        });
    });

    $('.disapprove_view').click(function(){
        var elem = $(this);
        bootbox.confirm({
            message: "Are you sure you want to disapprove?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result){
                    var plan_id     = $(elem).data('plan-id');
                    var decission   = $(elem).data('decission');
                    var data = {
                        plan_id: plan_id,
                        decission: decission,
                    };

                    submitDecission(data,'detail');                    
                }
                else{
                    return;
                }
            }
        });
    });
});

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