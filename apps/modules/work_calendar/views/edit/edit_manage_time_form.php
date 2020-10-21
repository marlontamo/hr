<div class="col-md-12" id="edit-mtf-form">
<form class="form-horizontal" name="edit-mtf-form">

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="customCloseButtonCallback();"></button>
		<h4 class="modal-title">Select Date/s</h4>
        <span class="text-muted padding-3 small">March 7, 2014 - Fri</span>
	</div>

	<div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">From<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" id="start_date" name="date_from" class="form-control" readonly>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <div class="help-block small">
											Select Start Date
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">To<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" id="end_date" class="form-control">
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                        <div class="help-block small">
											Select End Date
										</div>
                                        <div class="help-block small margin-top-20">
                                            Lorem ipsum dolor sit amet, nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                        </div>
                                    </div>
                                </div>                                
                            </div>                            
                        </form>
                        <!-- END FORM--> 
                    </div>
            	</div>
			</div>
		</div>
	</div>
	<div class="modal-footer margin-top-0">
		<a type="button" class="btn blue btn-sm" onclick="load_partners_list()">Next</a>
	</div>
</form>
</div>

<form class="form-horizontal" name="edit-mtf-list" id="edit-mtf-list" style="display: none;">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Partner List Form</h4>
        <span class="text-muted padding-3 small">March 5, 2014 - Wed to March 7, 2014 - Fri</span>
    </div>
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet">
                    <div class="portlet-body" >
                        <div class="small text-muted margin-bottom-20">
                            Lorem ipsum dolor sit amet,  nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
                        </div>
                        <!-- Table -->
                        <table class="table table-condensed table-striped table-hover" >
                            <thead>
                                <tr>
                                    <th width="1%"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
                                    <th width="40%">Employee</th>
                                    <th width="45%" class="hidden-xs">Schedule</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>
                                <tr rel="0">
                                    <!-- this first column shows the year of this holiday item -->
                                    <td><input type="checkbox" class="checkboxes" value="1" /></td>
                                    <td>
                                        <span class="text-success">Doe, John E.</span>
                                        <br>
                                       <a id="date_name" href="#" class="text-muted small">E1234</a>
                                    </td> 
                                    <td>
                                        9:30am - 6:00pm 
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        <button type="button" class="btn green btn-sm">Save changes</button>
    </div>
</form>

<script>
    
    $(document).ready(function(){

        $('#check_all').on('click', function(){   

            var checkboxes = $("input[type=checkbox]:not(.toggle)");

            if (checkboxes.size() > 0) { 

                checkboxes.each(function () {
                    if (!$(this).parents(".checker").children('span').hasClass('checked')) {

                        $(this).parents(".checker").children('span').addClass('checked'); 
                        $('.checkboxes').attr('checked', true);                     
                    }
                    else{
                        $(this).parents(".checker").children('span').removeClass('checked');
                        
                        $('.checkboxes').attr('checked', false);
                    }
                });
            }
        });
    });

    var load_partners_list = function( ){

        request_data = {date_from: $('#start_date').val(), date_to: $('#end_date').val(), page: '2'};

        $.ajax({
            url: base_url + module.get('route') + '/get_manager_partners',
            type: "POST",
            async: false,
            data: request_data,
            dataType: "json",
            beforeSend: function () {
                // nothing really has to be done here..
            },
            success: function (response) {

                if(response.proceed == true){
                    
                    //$("#pop_date").text(response.start_date + ' - ' + response.end_date);
                    
                    $("#hid_start_date").val(response.start_date);
                    $("#hid_end_date").val(response.end_date);
                    
                    $('#edit-mtf-form').hide();
                    $('#edit-mtf-list').show();
                    customHandleUniform();
                    FormComponents.init();
                }

                
                for (var i in response.message) {
                    if (response.message[i].message != "") {
                        notify(response.message[i].type, response.message[i].message);
                    }
                }
            }
        });
    }
</script>