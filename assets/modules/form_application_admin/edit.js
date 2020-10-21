$(document).ready(function(){
    $('#time_forms_upload-upload_id-fileupload').fileupload({
        url: base_url + module.get('route') + '/multiple_upload',
        autoUpload: true,
    }).bind('fileuploadadd', function (e, data) {
    	$.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
    }).bind('fileuploaddone', function (e, data) {
    	$.unblockUI();
    	var file = data.result.file;
    	if(file.error != undefined && file.error != "")
        {
            notify('error', file.error);
        }
        else{
            var cur_val = $('#time_forms_upload-upload_id').val();
        	if( cur_val == '' )
        		$('#time_forms_upload-upload_id').val(file.upload_id);
        	else
        		$('#time_forms_upload-upload_id').val(cur_val + ',' +file.upload_id);
        	$('#time_forms_upload-upload_id-container ul').append(file.icon);
        }
    }).bind('fileuploadfail', function (e, data) {
    	$.unblockUI();
    	notify('error', data.errorThrown);
    });

    $('#time_forms_upload-upload_id-container .fileupload-delete').stop().live('click', function(event){
    	event.preventBubble=true;
    	var upload_id = $(this).attr('upload_id');
    	$('li.fileupload-delete-'+upload_id).remove();
    	var cur_val = $('#time_forms_upload-upload_id').val();
    	var new_val = new Array();
    	new_val_ctr = 0;
    	if(cur_val != ""){
    		cur_val = cur_val.split(',');
    		for(var i in cur_val)
    		{
    			if( cur_val[i] != upload_id )
    			{
    				new_val[new_val_ctr] = cur_val[i];
    				new_val_ctr++;
    			}
    		}
    	}

    	if( new_val_ctr == 0 )
    		$('#time_forms_upload-upload_id').val( '' );
    	else
    		$('#time_forms_upload-upload_id').val( new_val.join(',') );
    });
    $('#time_forms_maternity-delivery_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    if (jQuery().datepicker) {
        $('#time_forms_maternity-expected_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_forms_maternity-actual_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }
    if (jQuery().datepicker) {
        $('#time_forms_maternity-return_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

    $('#time_forms_date-shift_id').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    $('#time_forms_date-shift_to').select2({
        placeholder: "Select an option",
        allowClear: true
    });

    $('#users_location-location_id').multiselect();
    $('#users_company-company_id').multiselect();
    $('#users_project-project_id').multiselect();
    $('#users_department-department_id').multiselect();
    $('#users_assignment-assignment_id').multiselect();

    $('#form_type').change(function () {
        var form_type = $(this).val()
        if(form_type != 0){
            //location select all
            $('#users_location-location_id option').attr('selected', 'selected');
            $('input[name="multiselect_users_location-location_id"]').each( function() {
                $(this).attr('checked',true);
                $(this).attr('aria-selected',true);
            });
            $("#users_location-location_id").multiselect("destroy");
            $('#users_location-location_id').multiselect({
              numberDisplayed: $('input[name="multiselect_users_location-location_id"]').length
            });
            //company select all
            $('#users_company-company_id option').attr('selected', 'selected');
            $('input[name="multiselect_users_company-company_id"]').each( function() {
                $(this).attr('checked',true);
                $(this).attr('aria-selected',true);
            });
            $("#users_company-company_id").multiselect("destroy");
            $('#users_company-company_id').multiselect({
              numberDisplayed: $('input[name="multiselect_users_company-company_id"]').length
            });        
            //project select all
            $('#users_project-project_id option').attr('selected', 'selected');
            $('input[name="multiselect_users_project-project_id"]').each( function() {
                $(this).attr('checked',true);
                $(this).attr('aria-selected',true);
            });
            $("#users_project-project_id").multiselect("destroy");
            $('#users_project-project_id').multiselect({
              numberDisplayed: $('input[name="multiselect_users_project-project_id"]').length
            });
            //department select all
            $('#users_department-department_id option').attr('selected', 'selected');
            $('input[name="multiselect_users_department-department_id"]').each( function() {
                $(this).attr('checked',true);
                $(this).attr('aria-selected',true);
            });
            $("#users_department-department_id").multiselect("destroy");
            $('#users_department-department_id').multiselect({
              numberDisplayed: $('input[name="multiselect_users_department-department_id"]').length
            });
            //assignment select all
            $('#users_assignment-assignment_id option').attr('selected', 'selected');
            $('input[name="multiselect_users_assignment-assignment_id"]').each( function() {
                $(this).attr('checked',true);
                $(this).attr('aria-selected',true);
            });
            $("#users_assignment-assignment_id").multiselect("destroy");
            $('#users_assignment-assignment_id').multiselect({
              numberDisplayed: $('input[name="multiselect_users_assignment-assignment_id"]').length
            });
            load_form(form_type)
            $('#change_employees').hide();
            $('#form_details').removeClass('hidden');
        }else{
            $('#form_details').addClass('hidden');
            $('#blanket_details').addClass('hidden');
        }
    });

    $('#users_company-company_id').change(function(){
        update_department( $(this).val() );
        update_employees( $('#users_location-location_id').val(), $('#users_company-company_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
    });

    $('#users_location-location_id').change(function(){
        update_employees( $('#users_location-location_id').val(), $('#users_company-company_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
    });

    $('#users_department-department_id').change(function(){
        update_employees( $('#users_location-location_id').val(), $('#users_company-company_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
    });

    $('#users_assignment-assignment_id').change(function(){
        update_employees( $('#users_location-location_id').val(), $('#users_company-company_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
    });

    $('#filter_employees').click(function () {
        var forms = ['1','2','3','4','5','6','7','8','14','15','16','19','20'];
        if ($('#partners-partner_id').length > 0){
            if ($.inArray($('#form_type').val(),forms) >= 0){
                $('#partners-partner_id').multiselect({
                    multiple: false
                });
            }
            else{
                $('#partners-partner_id').multiselect({
                    multiple: true
                });            
            }
        }
        if($('#employee_filtered').val() == 0){
            update_employees( $('#users_location-location_id').val(), $('#users_company-company_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
        }
        $('#main_form').hide();
        $('.form-actions').hide();
        $('#change_employees').show();
    });

});

function load_form(form_type){
    $.blockUI({ message: loading_message(), 
     onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/edit_blanket_form',
                type:"POST",
                async: false,
                data: 'form_type='+form_type,
                dataType: "json",
                beforeSend: function(){
                },
                success: function ( response ) {
                    $('#blanket_details').html(response.blanket_form);
                    if(form_type == 1 || form_type == 2 || form_type == 3 || form_type == 4 || form_type == 5 || form_type == 6 || form_type == 7 || form_type == 8 || form_type == 14 || form_type == 16 || form_type == 19 || form_type == 20){
                        get_selected_dates($('#record_id').val(), $('#form_status_id').val(), $('#time_forms-date_from').val(), $('#time_forms-date_to').val());   
                        $('#change_options').hide();
                    }
                    $("#ut_time_in_out").datetimepicker({
                        format: "MM dd, yyyy - HH:ii p",
                        autoclose: true,
                        todayBtn: false,
                        pickerPosition: "bottom-left",
                        minuteStep: 1
                    });                         
                }
            }); 
     }
    });
    $.unblockUI();   
}
function back_to_mainform_emp(cancel){    
    $('#employee_filtered').val(1);
    if(cancel==1){
        update_employees( $('#users_location-location_id').val(), $('#users_project-project_id').val(), $('#users_department-department_id').val(), $('#users_assignment-assignment_id').val() );
    }
    var employees_count = $("#partners-partner_id :selected").length;
    $('#employees_count').html(employees_count);
    $('#change_employees').hide();
    $('#main_form').show();
    $('.form-actions').show();
}

function update_employees( location_id, company_id, project_id, department_id, assignment_id )
{
    if( (location_id != "" && location_id != null) || ((project_id != "" && project_id != null) && (department_id != "" && department_id != null) && (assignment_id != "" && assignment_id != null)) )
    {
        // $.blockUI({ message: '<div>Loading employees, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />', 
        //  onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/update_employees',
                type: "POST",
                async: false,
                data: { location_id: location_id,
                        company_id: company_id,
                        project_id: project_id,
                        department_id: department_id},
                dataType: "json",
                beforeSend: function () {
                    // need to do something 
                    // on before send?
                },
                success: function (response) {  
                    $('#employees_count').html(response.count);
                    $('#change_employees').html(response.filtered_employees);
                    $('#partners-partner_id').html(response.employees);
                    // $("#partners-partner_id").multiselect("destroy");
                    var forms = ['1','2','3','4','5','6','7','8','14','15','16','19','20'];

                    if ($.inArray($('#form_type').val(),forms) >= 0){
                        $('#partners-partner_id').multiselect({
                            multiple: false
                        });
                    }
                    else{
                        $('#partners-partner_id').multiselect({
                            numberDisplayed: response.count,
                            multiple: true
                        });                        
                    }
                    $('input[name="multiselect_partners-partner_id"]').each( function() {
                        $(this).attr('checked',true);
                        $(this).attr('aria-selected',true);
                    });
                }
            }); 
        //  }
        // });
        // $.unblockUI();   
    }
    else{
        $('#partners-partner_id').html('');
        $("#partners-partner_id").multiselect("destroy");
        $('#partners-partner_id').multiselect({
            noneSelectedText: 'Select All'
        });
    }      
}

function update_department( company_id )
{
    if( company_id != "" && company_id != null )
    {
        $.ajax({
            url: base_url + module.get('route') + '/update_department',
            type: "POST",
            async: false,
            data: {company_id: company_id},
            dataType: "json",
            beforeSend: function () {
                // need to do something 
                // on before send?
            },
            success: function (response) { 
                $('#users_department-department_id').html(response.departments);
                $("#users_department-department_id").multiselect("destroy");
                $('#users_department-department_id').multiselect({
                    numberDisplayed: response.count
                });
                $('input[name="multiselect_users_department-department_id"]').each( function() {
                    $(this).attr('checked',true);
                    $(this).attr('aria-selected',true);
                });
            }
        }); 
    }
    else{
        $('#users_department-department_id').html('');
        $("#users_department-department_id").multiselect("destroy");
        $("#users_department-department_id").multiselect();
    }       
}