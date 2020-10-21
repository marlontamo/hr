<div id="edit-mtf-form">

    <form class="form-horizontal" name="edit-mtf-form" id="form-calman-range" fg_id="calman-range">

        <input type="hidden" id="shift_id" name="shift_id" value="<?php echo $shift_id; ?>">
        <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">

    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="customCloseButtonCallback();"></button>
    		<h4 class="modal-title">Select Date/s <span style="padding-left:15px" id="loading"></span></h4>                
            <span id="drop_indicator" class="text-muted padding-3 small"><?php echo $start_date; ?></span>          
    	</div>      

    	<div class="modal-body padding-bottom-0">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="portlet">
                        <div class="portlet-body form">

                            <div class="small text-muted margin-bottom-20">
                                Note: Select date range to proceed to the next step.
                            </div>
                            
                            <!-- BEGIN FORM-->
                            <!-- <form action="#" class="form-horizontal"> -->
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">From<span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                                <input 
                                                    type="text" 
                                                    id="start_date" 
                                                    name="date_from" 
                                                    class="form-control" 
                                                    value="<?php echo $start_date; ?>" 
                                                    readonly>
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
                                                <input type="text" id="end_date" class="form-control" readonly>
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <div class="help-block small">
    											Select End Date
    										</div>
                                            <!-- <div class="help-block small margin-top-20">
                                                Lorem ipsum dolor sit amet, nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                            </div> -->
                                        </div>
                                    </div>                                
                                </div>                            
                            <!-- </form> -->
                            <!-- END FORM--> 
                        </div>
                	</div>
    			</div>
    		</div>
    	</div>
    	<div class="modal-footer margin-top-0">
            <a type="button" class="btn btn-default btn-sm" onclick="close_this()">Cancel</a>
    		<a type="button" class="btn btn-success btn-sm" id="next_btn">Next</a>
    	</div>
    </form>
</div>


<script type="text/javascript">

    var getDateDifference = function(date1, date2){

        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return diffDays;
    }

    var getStartDate = function(date1, date2, days){

        if(date2.getTime() < date1.getTime()){
            days = "-" + days + "d";
        }
        else{
            days = "+" + days + "d";
        }

        return days;
    }
    
    var close_this = function(){
        $('#calman_form').modal('hide'); 
        Calendar.init();
    }

    $('#calman_form').on('hidden.bs.modal', function () {
        close_this();
    })

    $(document).ready(function(){
        
        // MARCH 20, 2014
        // WORK-AROUND FOR THIS BOOTSTRAP CALENDAR 
        // DON'T WORK PROPERLY ON AJAX LOADED ELEMENTS
       
        // GET CURRENT DATE
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var minDate = $("#start_date").val();
        minDate = new Date(minDate);

        var days; 
        days = getDateDifference(now, minDate);

        $('#end_date').datepicker({ 
            startDate: getStartDate(now, minDate, days),
            format: 'MM dd, yyyy',
        }).data('datepicker');


        var startDate = $("#start_date")
            .datepicker({
                format: 'MM dd, yyyy',
            })
            .on('changeDate', function(ev) {

                days = getDateDifference(now, new Date( $(this).val() ));

                $('#end_date').datepicker("remove");
                $('#end_date').datepicker({
                    startDate: getStartDate(now, new Date( $(this).val() ), days),
                    format: 'MM dd, yyyy',
                });
            })
            .data('datepicker');

        $('#next_btn').click('function',function(){

            $('#loading').html('Please wait....');

            request_data = {
                date_from: $('#start_date').val(), 
                date_to: $('#end_date').val(), 
                page: '2',
                shift_id: $('#shift_id').val(),
                type: $('#type').val(),
            };

            $.ajax({
                url: base_url + module.get('route') + '/get_manager_partners',
                type: "POST",
                async: false,
                data: request_data,
                dataType: "json",
                beforeSend: function () {
                    blockMe();
                },
                success: function (response) { 

                    if(response.proceed == true){
                    
                    var scrollPos = 0;

                    $('.modal')
                        .on('show.bs.modal', function (){
                            scrollPos = $('body').scrollTop();
                            $('body').css({
                                overflow: 'hidden',
                                position: 'fixed',
                                top : -scrollPos
                            });
                        })
                        .on('hide.bs.modal', function (){
                            $('body').css({
                                overflow: '',
                                position: '',
                                top: ''
                            }).scrollTop(scrollPos);
                        });

                        $('#calman_form').modal('hide');
                        $('#calman_list').html(response.partners_list);
                        $('#calman_list').modal('show');
                        
                        customHandleUniform();
                    }

                    unBlockMe();

                    for (var i in response.message) {
                        if (response.message[i].message != "") {
                            notify(response.message[i].type, response.message[i].message);
                        }
                    }
                }
            });            
        });
    });
</script>