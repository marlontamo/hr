@extends('layouts.master')

@section('page_styles')
	@parent
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/blog.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}css/pages/news.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />		

	<style>
		div.spinner {
			/*//position:relative;*/
			background: none;
			border: none;
			/*display: none;*/
			padding-top: 5px;
			padding-bottom: 5px;
			overflow: hidden;
			/*//width: 550px;
			//height: 300px;
			//border:1px solid red;*/
		}
		
		div.spinner img{
			margin-top: 5px;
			margin-bottom: 5px;
			position:absolute;
			top:50%;
			left: 50%;
		}
    </style>    
    
@stop

@section('page_content')
	@parent
   

	<div class="row">

				<div class="col-md-4">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">Leave Form</div>
						</div>
						<div class="portlet-body">

							<div class="clearfix">
								<ul class="media-list">
									<li class="media">
										<a href="admin_user_company.php" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Annual Leave</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="{{ get_mod_route('form_application', 'vl') }}">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<li class="media">
										<a href="admin_user_division.php" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Sick Leave</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_sl.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Emergency</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_el.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<li class="media">
										<a href="admin_user_group.php" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Bereavement</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_bl.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Maternity</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_m.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Paternity</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_p.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Leave Without Pay</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_lwop.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Birthday Leave</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_bday.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Special Leave for Women</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_splw.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>										
								</ul>

							</div>
						</div>
					</div>

				</div> <!-- <div class="col-md-12"> -->


				<div class="col-md-4">

					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">Other Forms</div>
						</div>

						<div class="portlet-body">

							<div class="clearfix">

								<ul class="media-list">
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Business Trip</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_bt.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Overtime</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_ot.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Undertime</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_ut.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Manual Attendance Form</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_dtrp.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>	
									<li class="media">
										<a href="#" class="hidden-xs pull-left">
											<i style="color:#646464;font-size:24px;line-height:24px;" class="fa fa-square-o"></i>
										</a>
										<div class="media-body">
											<h4 class="media-heading">Replacement Schedule</h4>
											<p class="small">
												Lorem ipsum dolor sit amet, consectetuer adipiscing elit aliquam erat volutpat. 
											</p>
											<a class="btn btn-xs green" href="time_application_form_cws.php">apply<i class="fa fa-arrow-circle-o-right"></i></a> 
										</div>
									</li>								
								</ul>

							</div>
						</div>
					</div>

				</div> <!-- <div class="col-md-12"> -->


				<div class="col-md-1">
				</div>


				<div class="col-md-3">

					<div class="portlet">
						<!-- <div class="portlet-title">
							<div class="caption">Menu Link</div>
						</div>	 -->	

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">Leave Status</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">Type</th>
											<th class="small">Pending</th>
											<th class="small">Approved</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">Annual Leave</td>
											<td class="small text-info">3</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Sick Leave</td>
											<td class="small text-info">3</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Leave Without Pay</td>
											<td class="small text-info">0</td>
											<td class="small text-success">4</td>
										</tr>
										<tr>
											<td class="small">Birthday Leave</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Bereavement</td>
											<td class="small text-info">2</td>
											<td class="small text-success">0</td>
										</tr>
										<tr>
											<td class="small">Emergency</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Paternity</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Leave Without Pay</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Birthday Leave</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">Other Forms Status</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">Type</th>
											<th class="small">Pending</th>
											<th class="small">Approved</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">Business Trip</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Overtime</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Undertime</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">DTR Probleme</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
										<tr>
											<td class="small">Replacement Schedule</td>
											<td class="small text-info">0</td>
											<td class="small text-success">1</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title">Approver/s</h4>
								</div>

								<ul class="list-group">
									<li class="list-group-item">Mahistardo, John<br><small class="text-muted">Manager</small> </li>
									<li class="list-group-item">Mendoza, Joel<br><small class="text-muted">Director</small> </li>
								</ul>
							</div>
						</div>

					</div>

				</div>


			</div>



    
    <!--START MODAL DIALOG ELEMENTS-->
    @include('common/modals')
    <!--END MODAL DIALOG ELEMENTS-->
    
@stop

@section('page_plugins')
	@parent
    
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <!-- <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script> -->
    <script type="text/javascript" src="{{ theme_path() }}plugins/jquery.lazyload.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>   
    <script type="text/javascript" src="{{ theme_path() }}plugins/fuelux/js/spinner.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>	
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" ></script>	    
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-touchspin/bootstrap.touchspin.js" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" ></script>	

 	<script src="{{ theme_path() }}plugins/bootstrap-toastr/toastr.min.js"></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

	<!-- Additional for FORM COMPONENTS -->
	<script src="{{ theme_path() }}plugins/jquery-inputmask/jquery.inputmask.bundle.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript" ></script>	
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/timerecord/edit_custom.js"></script>	     
	<script src="{{ theme_path() }}scripts/table-managed.js"></script>   
    <script src="{{ theme_path() }}scripts/form-wizard.js"></script>
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
	<script src="{{ theme_path() }}scripts/form-components.js"></script>       
@stop

@section('view_js')
	@parent
    

@stop