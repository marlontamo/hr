@extends('layouts.master')

@section('theme_styles')
	@parent

	<style>
		.portlet.calendar .fc-button {
			color : #545454;
			top : -56px;
		}
	</style>

	<link href="{{ theme_path() }}plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
	<link href="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.css" rel="stylesheet" type="text/css"/>

@stop

@section('page_content')
	@parent

	<div class="row">

	    <div class="col-md-12">

	        <div class="portlet" id="list">

	            <div class="breadcrumb hidden-lg hidden-md">
	                <div class="block input-icon right">
	                    <i class="fa fa-search"></i>
	                    <input type="text" placeholder="Search..." class="form-control">
	                </div>
	            </div>

	            <div class="portlet-title">

	            	<form method="post" id="report-form" fg_id="1" class="form-horizontal">

	            		<div class="col-md-6">
		            		
		            		<div class="" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: left">
				            	Type: 
				            	<select  
		                        	name="report-type" 
		                            id="report-type"
		                            class="select2"
		                            style="width:350px; float: right;">
		                            
		                            <option value="">Select a Report...</option>

		                            <?php for($j=0; $j < count( $report_list ); $j++){ ?>
		                            	<option value="<?php echo $report_list[$j]['report_id']; ?>" data-show-employee="<?php echo $report_list[$j]['show_employee_option']; ?>">
		                                	<?php echo $report_list[$j]['report']; ?>
		                                </option>
		                            <?php } ?>
		                        </select>
				            </div>


				            <div id="employee-container" class="" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: left;">
				            	Employee:

				            	<div class="input-group" style="width: 300px; float: right;">
									<span class="input-group-addon">
					                	<i class="fa fa-list-ul"></i>
					                </span>

					                <select name="selected-employees[]" id="selected-employees" class="form-control" multiple>
					                    <?php for($j=0; $j < count( $company_list ); $j++){ ?>
					                    	<option value="<?php echo $company_list[$j]['company_id']; ?>">
					                        	<?php echo $company_list[$j]['company']; ?>
					                        </option>
					                    <?php } ?>
					                </select>
					            </div>

					            <!--  
					            	<select  
			                        	name="report-type" 
			                            id="report-type"
			                            class="select2"
			                            style="width:350px; float: right; margin-bottom: 10px;">
			                            
			                            <option value="">Select Employee/s</option>

			                            <?php for($j=0; $j < count( $partners ); $j++){ ?>
			                            	<option value="<?php echo $partners[$j]['partner_id']; ?>">
			                                	<?php echo $partners[$j]['partner_name']; ?>
			                                </option>
			                            <?php } ?>
			                        </select> 
		                        -->
				            </div>

				            <div class="" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: left">
				            	From: 
				            	
		                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy" style="width:300px; float: right;">
								    <input type="text" id="start_date" name="date_from" class="form-control" value="" readonly="">
								    <span class="input-group-btn">
								    	<button class="btn default" type="button">
								        	<i class="fa fa-calendar"></i>
								      	</button>
									</span>
								</div>
				            </div>

				            <div class="" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: left">
				            	To: 
				            	
				            	<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy" style="width:300px; float: right;">
								    <input type="text" id="end_date" name="date_to" class="form-control" value="" readonly="">
								    <span class="input-group-btn">
								    	<button class="btn default" type="button">
								        	<i class="fa fa-calendar"></i>
								      	</button>
									</span>
								</div>
				            </div>
		            	</div>

		            	<div class="col-md-6">
		            		
		            		<div class="" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: left">
				            	Company: 

					            <div class="input-group" style="width: 300px; float: right;">
									<span class="input-group-addon">
					                	<i class="fa fa-list-ul"></i>
					                </span>

					                <select name="selected-company[]" id="selected-company" class="form-control" multiple>
					                    <?php for($j=0; $j < count( $company_list ); $j++){ ?>
					                    	<option value="<?php echo $company_list[$j]['company_id']; ?>">
					                        	<?php echo $company_list[$j]['company']; ?>
					                        </option>
					                    <?php } ?>
					                </select>
					            </div>
				            </div>
		            	</div>


			            <div class="col-md-12" style="width: 500px; margin-bottom: 10px; display: inline-block; text-align: right">

			            	<button id="export-report" type="button" class="btn btn-primary">Export</button>
			            	<button id="generate-report" type="button" class="btn btn-primary">Generate</button>
			            	<input type="hidden" id="page-number" name="page" value="1">
			            </div>
		            </form>		            
	            </div>

	            <div class="portlet-body">
	                <!-- Table -->

	                <div id="loader" class="text-center" style="display: none">
					    <img src="{{theme_path()}}img/ajax-loading.gif" alt="loading..." />Fetching record(s)
					</div>

					<div id="no_record" class="well" style="display:none;">
					    <p class="bold"><i class="fa fa-exclamation-triangle"></i> No record/s found!</p>
					    <span><p class="small margin-bottom-0">No available Time Record/s.</p></span>
					</div>

					<div id="show_error" class="well" style="display:none;">
					    <p class="bold"><i class="fa fa-exclamation-triangle"></i> A problem has occured.</p>
					    <span><p class="small margin-bottom-0">Please try to reaload page and try again.</p></span>
					</div>

					<!-- 
						The contents of this area will be dynamically loaded from the serving
						report controller where the requested report has been retrieved.
					 -->

					<div id="paging-container" style="width: 100%; text-align: right; display: none;">
						<div id="pagination" style="max-width: 70%; display: inline-block"></div>
						<button id="export_report" type="button" class="btn blue fa fa-share-square" style="display: inline-block"></button>
					</div>
					
					 
	                <table id="report-table" class="table table-condensed table-hover" style="">
	                    <thead>
	                        <tr>
	                        </tr>
	                    </thead>

	                    <tbody>
	                    	
	                    </tbody>
	                </table>

	                <!-- End Table -->
	            </div>
	        </div>
	    </div>

	    <div class="col-md-3 visible-lg visible-md">

	        <div class="portlet">

	            <style>
	                .event-block {
	                    cursor: pointer;
	                    margin-bottom: 5px;
	                    display: inline-block;
	                    position: relative;
	                }
	            </style>
	        </div>
	    </div>
	</div>
@stop


@section('view_js')
	@parent

	<script src="{{theme_path()}}scripts/ui-extended-modals.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script src="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.min.js" type="text/javascript" ></script>

	<!-- <script type="text/javascript" src="{{theme_path()}}modules/timerecord/lists.js"></script> -->

	<script type="text/javascript">
        $(document).ready(function(){

        	$(".select2").select2({
        		placeholder: "Select a Report...",
        	});

        	if (jQuery().datepicker) {
	            $('.date-picker').datepicker({
	                rtl: App.isRTL(),
	                autoclose: true
	            });
	            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        	}

        	$("#report-type").on("change", function(){

        		// Let's clear off result set upon the 
        		// selection of report type.
        		$("table#report-table > tbody > tr").remove();

        		// Determine if selected report type should show
        		// and allow user to select certain specific employees
        		if($(this).find(':selected').data("show-employee")){
        			$("#employee-container").show();
        		}
        		else{
        			$("#employee-container").hide();
        		}
        	});

        	$("#generate-report").on("click", function(){
        		
        		get_report( $(this).parents('form') );
        	});

        	$("a.page-num").live("click", function(e){
        		
        		e.preventDefault();
        		$("#page-number").val($(this).attr('href').replace('/',''));
        		get_report( $("#page-number").parents('form') );
        	});

        	// exporting report data to an excel file
        	$("#export_report").click(function(){

        		var data = $("#page-number").parents('form').serialize();
        		var export_url = base_url + 'report/export_report/?' + data;

        		window.open(export_url, '_blank');
        	});
        }); 

        // report_custom.js
        $(document).ready(function(){

		    $('#selected-company').multiselect();
		    $('select[name="memo[apply_to_id]"]').change(function(){
		        $.ajax({
		            url: base_url + module.get('route') + '/get_applied_to_options',
		            type:"POST",
		            data: { apply_to: $('select[name="memo[apply_to_id]"]').val()},
		            dataType: "json",
		            async: false,
		            success: function ( response ) {
		                // handle_ajax_message( response.message );

		                // $('#selected-company').html( response.options );
		                // $('#selected-company').multiselect("refresh");
		            }
		        });
		    });


		    $('#selected-employees').multiselect();
		    $('select[name="selected-employees"]').change(function(){
		        $.ajax({
		            url: base_url + module.get('route') + '/get_applied_to_options',
		            type:"POST",
		            data: { apply_to: $('select[name="selected-employees"]').val()},
		            dataType: "json",
		            async: false,
		            success: function ( response ) {
		                // handle_ajax_message( response.message );

		                // $('#selected-company').html( response.options );
		                // $('#selected-company').multiselect("refresh");
		            }
		        });
		    });
		});


        function get_report(form){

        	var data = form.find(":not('.dontserializeme')").serialize();

        	$.ajax({
				url: base_url + module.get('route') + '/get_report',
				type:"POST",
				data: data,
				dataType: "json",
				async: false,
				beforeSend: function(){

					$("table#report-table > tbody > tr").remove();
					$("#loader").show();
				},
				success: function ( response ) {

					console.log(response);
					handle_ajax_message( response.message );
					
					$("#loader").hide();
					$("#no_record").hide();
					$("#show_error").hide();

					if(response.count > 0){

						$("table#report-table").show();

						$("table#report-table > thead > tr > th").remove();
						$("table#report-table > thead > tr").append(response.header);

						$("table#report-table > tbody > tr").remove();
						$("table#report-table > tbody").append(response.body);

						//$("#page-number").val(response.current_page);
						

						$("#pagination").html(response.pages);
						//$("#pagination").prepend(response.pages);
						$("#pagination .page-group strong").addClass('btn default').css({"margin":"10px;"});
						$("#pagination .page-group a").addClass('btn red page-num').css({"margin":"10px;"});
						$("#paging-container").show();						
					}
					else{

						$("table#report-table").hide();
						$("#no_record").show();
					}
				},
				error: function(xhr, status, error){

					// do something here...

					$("#loader").hide();
					$("#no_record").hide();
					$("table#report-table").hide();
					$("#show_error").show();
				}
			});
        }

    </script>
@stop