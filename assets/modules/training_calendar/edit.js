$(document).ready(function(){
    count_confirmed();
    
    $('#sessionsDiv').show('fast');

    if (jQuery().datepicker) {
        $('#training_calendar-revalida_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    $('#training_calendar-planned-temp').change(function(){
        if( $(this).is(':checked') )
            $('#training_calendar-planned').val('1');
        else
            $('#training_calendar-planned').val('0');
    });
    $('#training_calendar-partner_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#training_calendar-closed-temp').change(function(){
        if( $(this).is(':checked') )
            $('#training_calendar-closed').val('1');
        else
            $('#training_calendar-closed').val('0');
    });
    $('#training_calendar-with_certification-temp').change(function(){
        if( $(this).is(':checked') )
            $('#training_calendar-with_certification').val('1');
        else
            $('#training_calendar-with_certification').val('0');
    });
    $('#training_calendar-training_revalida_master_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    if (jQuery().datepicker) {
        $('#training_calendar-publish_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    //$('#training_calendar-feedback_category_id').multiselect();
   

    if (jQuery().datepicker) {
        $('#training_calendar-last_registration_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#training_calendar-registration_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    $('#training_calendar-tba-temp').change(function(){
        if( $(this).is(':checked') )
            $('#training_calendar-tba').val('1');
        else
            $('#training_calendar-tba').val('0');
    });
    $('#training_calendar-calendar_type_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#training_calendar-course_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });   

     $('#training_calendar-feedback_category_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    $('#training_calendar-company_id,#training_calendar-location_id,#training_calendar-branch_id,#training_calendar-department_id,#training_calendar-employees').multiselect();    

    $('#training_calendar-course_id').live('change',function(){
        get_training_course_info();
    });

    $('#training_calendar-location_id,#training_calendar-company_id,#training_calendar-department_id,#training_calendar-branch_id').live('change',function (){
        get_employees();
    })

    $('.participant_status').live('change',function(){
        count_confirmed(); 
    });

    $('.participants-nominate').change(function(){
        if( $(this).is(':checked') ){
            $(this).closest('td').find('.participants-nominate-val').val('1');
        }
        else {
            $(this).closest('td').find('.participants-nominate-val').val('0');
        }
    });  

    $('#participants-no_show').change(function(){
        if( $(this).is(':checked') ){
            $(this).closest('td').find('.participants-no_show-val').val('1');
        }
        else {
            $(this).closest('td').find('.participants-no_show-val').val('0');
        }
    }); 

    //For Training Cost
    $('#add_training_cost').click(function(event) {

        event.preventDefault();
        var url = base_url + module.get('route') + '/get_training_cost_form';
        var data = 'cost_count=' + ( parseInt($('.cost_count').val()) + 1 ) +'&training_calendar_id=' + ($('#training_calendar_id').val());

         $.ajax({
            url: url,
            dataType: 'html',
            type:"POST",
            data: data,
            success: function (response) {

                var item_count = parseInt($('.cost_count').val());
                $('.cost_count').val( item_count + 1 );
                $('.form-multiple-add-training-cost').append(response);

            }

        });

    });

    $('a.delete_training_cost').live('click', function () {

        var remove_item_no = parseInt($(this).parents('div.add_more_training_cost').find('.sequence').val());
        $(this).parents('div.add_more_training_cost').remove();

        var cost_count = parseInt($('.cost_count').val());
        $('.cost_count').val( cost_count - 1 );

        // $('.sequence').each(function(){

        //     if( parseInt($(this).val()) > remove_item_no ){
        //         var item_no = parseInt($(this).val());
        //         $(this).val( item_no - 1 );
        //     }

        // });

        calculate_total_cost_pax();

    });

    $('.cost, .pax').live('change',function(){

        var sub_cost = $(this).parents('div.add_more_training_cost').find('.cost').val();
        var sub_pax = $(this).parents('div.add_more_training_cost').find('.pax').val();
        var sub_total = ( sub_cost * sub_pax ).toFixed(2)

        $(this).parents('div.add_more_training_cost').find('.total').val( sub_total );

        calculate_total_cost_pax();

    });  

    if (jQuery().datepicker) {
        
        $('.session_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }

    if (jQuery().timepicker) {
        $('.session-time_start').timepicker({
            autoclose: true,
            minuteStep: 1,
            secondStep: 1,
            defaultTime: false
        });
    }
    if (jQuery().timepicker) {
        $('.session-time_end').timepicker({
            autoclose: true,
            minuteStep: 1,
            secondStep: 1,
            defaultTime: false
        });
    }

    if (jQuery().timepicker) {
        $('.break-time_start').timepicker({
            autoclose: true,
            minuteStep: 1,
            secondStep: 1,
            defaultTime: false
        });
    }

    if (jQuery().timepicker) {
        $('.break-time_end').timepicker({
            autoclose: true,
            minuteStep: 1,
            secondStep: 1,
            defaultTime: false
        });
    }  

    $('#add_session').click(function(event) {
        event.preventDefault();
        var url = base_url + module.get('route') + '/get_session_form';
        var data = 'session_count=' + ( parseInt($('.session_count').val()) + 1 ) +'&training_calendar_id=' + ($('#training_calendar_id').val());

         $.ajax({
            url: url,
            dataType: 'html',
            type:"POST",
            data: data,
            success: function (response) {

                    var item_count = parseInt($('.session_count').val());
                    $('.session_count').val( item_count + 1 );
                    $('.form-multiple-add-session fieldset').append(response);

            }

        });
    });

    $('a.delete_session').live('click', function () {
        var remove_item_no = parseInt($(this).parents('div.add_more_session_field').find('.sequence').val());
        $(this).parents('div.add_more_session_field').remove();

        var session_count = parseInt($('.session_count').val());
        $('.session_count').val( session_count - 1 );

        $('.sequence').each(function(){

            if( parseInt($(this).val()) > remove_item_no ){
                var item_no = parseInt($(this).val());
                $(this).val( item_no - 1 );
            }

        });
    });                 
});

function add_participants(){
    if( ( $('#training_calendar-employees').val() == null ) ){
        notify('error', 'Please select an employee');
        return false;
    }
    else{
        $.ajax({
            url: base_url + module.get('route') + '/add_participants',
            dataType: 'json',
            type:"POST",
            data: 'user_id='+$('#training_calendar-employees').val(),
            success: function (response) {

                $('#form-list').append(response.content_list);

                var nid = "";

                $('.participants').each(function(){
                    nid = nid + $(this).val() + ',';
                });
                

                $.ajax({
                    url: base_url + module.get('route') + '/get_employee_filter',
                    data: 'nid=' + nid,
                    dataType: 'json',
                    type: 'post',
                    async: false,
                    beforeSend: function(){
                        
                    },                              
                    success: function ( response ) {
                        $.unblockUI(); 
                        $('#training_calendar-employees option').remove();
                        $('#training_calendar-employees').append(response.employees);
                        $("#training_calendar-employees").multiselect("refresh"); 
                        $('.make-switch').not(".has-switch")['bootstrapSwitch']();

                        $('.participants-nominate').change(function(){
                            if( $(this).is(':checked') ){
                                $(this).closest('td').find('.participants-nominate-val').val('1');
                            }
                            else {
                                $(this).closest('td').find('.participants-nominate-val').val('0');
                            }
                        });  

                        $('#participants-no_show').change(function(){
                            if( $(this).is(':checked') ){
                                $(this).closest('td').find('.participants-no_show-val').val('1');
                            }
                            else {
                                $(this).closest('td').find('.participants-no_show-val').val('0');
                            }
                        });                         
                    }
                });
                $("#training_calendar-employees").multiselect("uncheckAll"); 
            }
        });
    }
}

function clear_participants(){
    $('#form-list').empty();

    get_employees();

    count_confirmed();
}

$('.delete-participant').live('click',function(){

    $(this).parent().parent().remove();

    get_employees();

    count_confirmed();  
});

function get_employees(){
    var location_id = $('#training_calendar-location_id').val();
    var company_id = $('#training_calendar-company_id').val();
    var branch_id = $('#training_calendar-branch_id').val();
    var department_id = $('#training_calendar-department_id').val();
    $.ajax({
        url: base_url + module.get('route') + '/get_employees',
        type: 'post',
        dataType: 'json',
        data: 'location_id='+ location_id +'&company_id='+ company_id +'&branch_id=' + branch_id + '&department_id=' + department_id,
        beforeSend:function() {
        },
        success: function (response) {
            $('#training_calendar-employees option').remove();
            if (response !== null) {
                $('#training_calendar-employees').append(response.employees);
/*                if (response.employees !== '') {
                    $.each(response.employees, function(index, values){
                        $('#multiselect-employee_id option[value="' + values + '"]').attr('selected','selected');
                    });
                };*/
            };
            $('#training_calendar-employees').multiselect("refresh");
        }
    });
}

function count_confirmed(){
    if( $('#form-list tr').length > 0 ){
        var confirmed_count = 0;
        $('.participant_status').each(function(){

            if( $(this).val() == "2" ){

                confirmed_count++;

            }

        });
        $('.total_confirmed').val(confirmed_count);
    }
    else{
        $('.total_confirmed').val("0");
    }
}

function get_training_course_info(){

    var url = base_url + module.get('route') + '/get_training_course_info';
   // var data = $('#record-form').serialize()+'&view='+module.get('view');
//var data = form.find(":not('.dontserializeme')").serialize();
//console.log($('#training-calendar-form').serialize());
    $.ajax({
        url: url,
        dataType: 'json',
        type:"POST",
        //data: data,
        data: 'course='+$('#training_calendar-course_id').val(),
        success: function (response) {

            //if( module.get_value('view') == 'edit' ){

                $('input[name="training_calendar[calendar_type_id]"]').val(response.training_provider);
                $('input[name="training_calendar[training_category_id]"]').val(response.training_category);

           // }
           /* else if( module.get_value('view') == 'detail' ){

                $('label[for="training_provider"]').parent().find('div').html(response.training_provider);
                $('label[for="training_category_id"]').parent().find('div').html(response.training_category);

            }*/

        }
    });
}


//remove phone
function remove_form(div_form, mode, tab){
    if(tab == 'history'){
        $('#'+div_form).parent().parent().parent().remove();
        var count = ($('#'+mode+'_count').val() - 1);
        $('#'+mode+'_count').val(count);
    }else{
        $('#'+div_form).parent().parent().remove();
        var count = ($('#'+mode+'_count').val() - 1);
        var counting = $('#'+mode+'_counting').val();
        if( count == 1 ){
            $('.action_'+mode).remove();
            var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';
            $('.add_delete_'+mode).append(span_delete_add);
        }else{
            $( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child a.add_"+mode ).remove();
            var span_delete_add = '<a class="btn btn-default action_'+mode+' add_'+mode+'" id="add_'+mode+'" onclick="add_form(\'contact_'+mode+'\', \''+mode+'\')" ><i class="fa fa-plus"></i></a>';           
            $( "#personal_"+mode+" div.form-group:last-child span.add_delete_"+mode+":last-child" ).append(span_delete_add);    
        }
        $('#'+mode+'_count').val(count);    
        var count_val = 1;
        var num = 1;
        while(counting >= num){
            if( $('#'+mode+'_display_count-'+num).length ) {
                if(count_val == 1){
                    $('#'+mode+'_display_count-'+num).text('');
                }else{
                    $('#'+mode+'_display_count-'+num).text(count_val);
                }
                count_val++;
            }
            num++;
        }
    }
}

//add phone 
function add_form(add_form, mode, sequence){
    var count = $('#'+mode+'_count').val();
    var counting = $('#'+mode+'_counting').val();
    var form_category = ( $('#'+mode+'_category').length ) ? $('#'+mode+'_category').val() : '';
    if( count == 1 ){
        $('.action_'+mode).remove();
        var span_delete_add = '<a class="btn btn-default action_"'+mode+' id="delete_'+mode+'-'+counting+'" onclick="remove_form(this.id, \''+mode+'\')" ><i class="fa fa-trash-o"></i></a>';
        $('.add_delete_'+mode).append(span_delete_add);
    }
    $.ajax({
        url: base_url + module.get('route') + '/add_form',
        type:"POST",
        async: false,
        data: 'add_form='+add_form+'&count='+count+'&category='+form_category+'&counting='+counting,
        dataType: "json",
        beforeSend: function(){
        },
        success: function ( response ) {

            for( var i in response.message )
            {
                if(response.message[i].message != "")
                {
                    var message_type = response.message[i].type;
                    notify(response.message[i].type, response.message[i].message);
                }
            }
            if( typeof(response.add_form) != 'undefined' )
            {   
                console.log(mode);
                $('#add_'+mode).remove();
                $('#'+mode+'_count').val(response.count);
                $('#'+mode+'_counting').val(response.counting);
                $('#'+mode).append(response.add_form);
                // handleSelect2();
                FormComponents.init();
            }

           /* $("[id^='partners_personal_history-cost_center-cost_center']").change(function(){

                var id = $(this).attr("id")
                id = id.replace("partners_personal_history-cost_center-cost_center", "");
                get_project_code($('#partners_personal_history-cost_center-cost_center'+id).val(), id);
            });*/
        }
    }); 
}

function calculate_total_cost_pax(){

    var url = base_url + module.get('route') + '/calculate_total_cost_pax';
    var total = 0;
    var pax = 0;

    $('.total').each(function(){
        total += parseFloat($(this).val());
    });

    $('.pax').each(function(){
        pax += parseFloat($(this).val());
    });

    $.ajax({
        url: url,
        dataType: 'json',
        type:"POST",
        data: 'sub_total=' + total + '&sub_pax=' + pax,
        success: function (response) {

            $('.total_cost').val( response.total_cost );
            $('.total_pax').val( response.total_pax );
        }
    });
}
