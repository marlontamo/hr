@extends('layouts/master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.css" rel="stylesheet" type="text/css"/>
	</style>
@stop

@section('page-header')
	
	<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			{{ $mod->long_name }} <small>{{ $mod->description }}</small>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li class="btn-group">
				<a href="{{ $mod->url }}"><button class="btn blue" type="button">
				<span>Back</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">Home</a> 
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<!-- jlm i class="fa {{ $mod->icon }}"></i -->
				<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>{{ ucwords( $mod->method )}}</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>

@stop


@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-9">
        	<form class="form-horizontal">
        		<input type="hidden" name="view" id="view" value="edit" >
        		<input type="hidden" name="record_id" id="record_id" value="" >
				<div id="shift_class" class="portlet">
					<div class="portlet-title">
						<div class="caption">Shift Class <small class="text-muted">add</small></div>
					</div>
                    <div class="portlet-body form" id="main_form">
                        <!-- BEGIN FORM-->
                        <div class="form-body">
                        	<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Company :<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
											<?php
								                $db->order_by('company', 'asc');
								                $companies = $db->get_where('users_company', array('deleted' => 0));

												$company_list[''] = 'Select...';
												foreach($companies->result() as $company ){
													$company_list[$company->company_id] = $company->company;
												}
								            ?>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list-ul"></i>
												</span>
												{{ form_dropdown('time_shift_class_company[company_id]',$company_list, '', 'id="time_shift_class_company-company_id" class="form-control select2me" data-placeholder="Select..."') }}
				
								        	</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Shift :<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
								            <?php
								                $db->order_by('shift', 'asc');
								                $shifts = $db->get_where('time_shift', array('deleted' => 0));
								            
												$shift_list[''] = 'Select...';
												foreach($shifts->result() as $shift ){
													$shift_list[$shift->shift_id] = $shift->shift;
												}
								            ?>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list-ul"></i>
												</span>
												{{ form_dropdown('time_shift_class_company[shift_id]',$shift_list, '', 'id="time_shift_class_company-shift_id" class="form-control select2me" data-placeholder="Select..."') }}
				
								        	</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Class Code:<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
								            <?php
								            	$class_code_list = array();
								            ?>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list-ul"></i>
												</span>
												{{ form_dropdown('time_shift_class_company[class_id]',$class_code_list, '', 'id="time_shift_class_company-class_id" class="form-control select2me" data-placeholder="Select..."') }}
				
								        	</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Class Value :<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
											<input type="text" class="form-control" name="time_shift_class_company[class_value]" id="time_shift_class_company-class_value" value="" placeholder=""/>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Employment Status :<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
								            <?php
								                $db->order_by('employment_status', 'asc');
								                $employment_statuses = $db->get_where('partners_employment_status', array('deleted' => 0));
								            	
												foreach($employment_statuses->result() as $employment_status ){
													$employment_status_list[$employment_status->employment_status_id] = $employment_status->employment_status;
												}
								            ?>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list-ul"></i>
												</span>
												{{ form_dropdown('time_shift_class_company[employment_status_id][]',$employment_status_list, '', 'id="time_shift_class_company-employment_status_id" class="form-control" multiple="multiple" data-placeholder="Select..."') }}
				
								        	</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 col-sm-4 ">Employment Type :<span class="required">* </span></label>
										<div class="col-md-6 col-sm-6">
								            <?php
								                $db->order_by('employment_type', 'asc');
								                $employment_types = $db->get_where('partners_employment_type', array('deleted' => 0));
								            	
												foreach($employment_types->result() as $employment_type ){
													$employment_type_list[$employment_type->employment_type_id] = $employment_type->employment_type;
												}
								            ?>
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list-ul"></i>
												</span>
												{{ form_dropdown('time_shift_class_company[employment_type_id][]',$employment_type_list, '', 'id="time_shift_class_company-employment_type_id" class="form-control" multiple="multiple" data-placeholder="Select..."') }}
				
								        	</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group" id="filter_emp_container">
								<label class="control-label col-md-4 text-danger small">Filter Employees: </label>
								<div class="col-md-6">
									<div class="help-block small">
										<span id="employees_count" name="employees_count">All</span> employee/s selected. Click to select specific employees.
										<input type="hidden" id="employee_filtered" value="0">
									</div>
									<div class="btn-grp">
										<button id="filter_employees" class="btn blue btn-xs" type="button"><small>Select Employees</small></button>
									</div>
								</div>
							</div>
							<div id="change_employees" class="row" style="display:none">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-4 text-danger small text-right">&nbsp; </label>
										<div class="col-md-6">
											<div class="btn-grp">
							                <button id="backto_mainform_emp" onclick="back_to_mainform_emp(1)" class="btn btn-default btn-xs" type="button"><small>Close Filter</small></button>
											</div>
										</div>
									</div>
								</div>
							</div>

                        </div>

                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-4 col-md-8">
                                    	<button onclick="save_record( $(this).closest('form'), '')" class="btn green btn-sm" type="button"><i class="fa fa-check"></i> Save</button>
                                    	<a href="{{ $mod->url }}" class="btn btn-default btn-sm">Back to list</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM--> 
                    </div>

	            </div>

			</form>
       	</div>  
    	<div class="col-md-3 visible-lg visible-md hidden">
			<div class="portlet">
				<div class="portlet-body">
					<div class="clearfix">
						<div class="panel panel-success">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/jquery-multicheckbox/jquery.multiselect.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
@stop

@section('page_scripts')
	@parent
@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/shift_class/edit.js"></script>
@stop


