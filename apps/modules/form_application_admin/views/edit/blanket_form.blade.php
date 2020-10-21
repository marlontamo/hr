@extends('layouts/master')

@section('page_styles')
@parent
@include('edit/page_styles')
	<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-timepicker/compiled/timepicker.css">
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
		<form class="form-horizontal" action="<?php echo $url?>/save_form">
			 <input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
			 <input type="hidden" id="form_status_id" name="form_status_id" value="{{ $form_status_id }}">
			<input type="hidden" id="form_id" name="form_id" value="{{ $form_id }}">
			<input type="hidden" name="forms_title" id="forms_title" value="{{ $form_title }}">
			<input type="hidden" name="view" id="view" value="edit_blanket" > 
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">Blanket Form</div>
					<div class="tools"><a class="collapse" href="javascript:;"></a></div>
				</div>
				<div class="portlet-body form" id="main_form">

					<div class="form-group">
						<label class="control-label col-md-4">Form Type<span class="required">* </span></label>
						<div class="col-md-6">
							<?php							
							$db->select('form_id,form');
							$db->where('deleted', '0');
							$db->where('is_blanket', '1');
                    		$options = $db->get('time_form');

							$form_type_options = array('' => 'Select...');
                    		foreach($options->result() as $option)
                    		{
                    			$form_type_options[$option->form_id] = $option->form;
                    		} 

							?>							
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('form_type',$form_type_options, $form_type, 'id="form_type" class="form-control select2me" data-placeholder="Select..."') }}
							</div> 				
						</div>	
					</div>

					<div id="form_details" name="form_details" class="hidden">

						<div id="blanket_details" name="blanket_details">
						</div>

						<div class="form-group">
							<label class="control-label col-md-4">Reason<span class="required">* </span></label>
							<div class="col-md-6">							
								<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				
							</div>	
						</div>
						<hr>
						<div class="form-group">
							<label class="control-label col-md-4">Location</label>
							<div class="col-md-6">
								<?php
									$db->select('location_id,location');
									$db->where('deleted', '0');
                            		$options = $db->get('users_location');

									$location_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			$location_id_options[$option->location_id] = $option->location;
                            		} 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('users_location[location_id][]',$location_id_options, $record['users_location.location_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="users_location-location_id"') }}
		                        </div>
	                    	</div>
	                    </div>
						<div class="form-group">
							<label class="control-label col-md-4">Company</label>
							<div class="col-md-6">
								<?php
									$db->select('company_id,company');
									$db->where('deleted', '0');
                            		$options = $db->get('users_company');

									$company_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			$company_id_options[$option->company_id] = $option->company;
                            		} 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('users_company[company_id][]',$company_id_options, $record['users_company.company_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="users_company-company_id"') }}
		                        </div>
	                    	</div>
	                    </div>	                    
						<div class="form-group">
							<label class="control-label col-md-4">Project</label>
							<div class="col-md-6">
								<?php
									$db->select('project_id,project');
									$db->where('deleted', '0');
                            		$options = $db->get('users_project');

									$project_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			$project_id_options[$option->project_id] = $option->project;
                            		} 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('users_project[project_id][]',$project_id_options, $record['users_project.project_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="users_project-project_id"') }}
		                        </div>
	                    	</div>
	                    </div>
						<div class="form-group">
							<label class="control-label col-md-4">Department</label>
							<div class="col-md-6">
								<?php
									$db->select('department_id,department');
									$db->where('deleted', '0');
                            		$options = $db->get('users_department');

									$department_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			$department_id_options[$option->department_id] = $option->department;
                            		} 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('users_department[department_id][]',$department_id_options, $record['users_department.department_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="users_department-department_id"') }}
		                        </div>
	                    	</div>
	                    </div>

	                    <div class="form-group" id="assignment_show">
							<label class="control-label col-md-4">Assignment</label>
							<div class="col-md-6">
								<?php
									$db->select('assignment_id,assignment');
									$db->where('deleted', '0');
                            		$options = $db->get('users_assignment');

									$assignment_id_options = array();
                            		foreach($options->result() as $option)
                            		{
                            			$assignment_id_options[$option->assignment_id] = $option->assignment;
                            		} 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('users_assignment[assignment_id][]',$assignment_id_options, $record['users_assignment.assignment_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="users_assignment-assignment_id"') }}
		                        </div>
	                    	</div>
	                    </div>

						<!-- <div class="form-group">
							<label class="control-label col-md-4">Employee<span class="required">*</span></label>
							<div class="col-md-6">
								<?php
									// $db->select('department_id,department');
									// $db->where('deleted', '0');
         //                    		$options = $db->get('users_department');

									$partner_id_options = array();
                            		// foreach($options->result() as $option)
                            		// {
                            		// 	$department_id_options[$option->department_id] = $option->department;
                            		// } 
                            	?>
	                            <div class="input-group">
									<span class="input-group-addon">
		                            <i class="fa fa-list-ul"></i>
		                            </span>
		                            {{ form_dropdown('partners[partner_id][]',$partner_id_options, $record['partners.partner_id'], 'class="form-control " data-placeholder="Select..." multiple="multiple" id="partners-partner_id"') }}
		                        </div>
	                    	</div>
	                    </div> -->

						<div class="form-group">
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

					</div>		

				</div>	
			</div>	
	
<!-- </div>
</div> -->

<div name="change_options" id="change_options">
</div>
<div name="change_employees" id="change_employees">
</div>



<div class="form-actions fluid" style="display: block;">
	 <div class="row">
		<div class="col-md-12">
			<div class="col-md-offset-4 col-md-8">
				<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 6 )">Save</button>
				<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )">Cancel this application</button>	
				<a href="<?php echo $mod->url;?>" class="btn default btn-sm">Back</a>
			</div>
		</div>
	</div> 
</div>


</form>
</div>  
	<!-- <div class="col-md-3 visible-lg visible-md">
		<div class="portlet">
			<div class="portlet-body">
				<div class="clearfix">
					<div class="panel panel-success"> -->
						<!-- Default panel contents -->
						<!-- <div class="panel-heading">
							<h4 class="panel-title">Leave Credits</h4>
						</div> -->

						<!-- Table -->
						<!-- <table class="table">
							<thead>
								<tr>
									<th class="small">Type</th>
									<th class="small">Used</th>
									<th class="small">Bal</th>
								</tr>
							</thead> -->
							<!-- <tbody>
								<?php foreach($leave_balance as $index => $value){ ?>
								<tr>
									<td class="small"><?=$value['form']?><br/>
											<small class="text-muted">exp. <?=date('M d, Y', strtotime($value['period_extension']))?></small>
										</td>
									<td class="small text-info"><?=number_format($value['used'])?></td>
									<td class="small text-success"><?=number_format($value['balance'])?></td>
								</tr>
								<?php } ?>
							</tbody> -->
						<!-- </table>
					</div>
				</div>

				<div class="clearfix">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">Approver/s</h4>
						</div> -->

						<!-- <ul class="list-group">
							<?php foreach($approver_list as $index => $value){ ?>
								<li class="list-group-item"><?=$value['lastname'].', '.$value['firstname']?><br><small class="text-muted"><?=$value['position']?></small> </li>
							<?php } ?>
						</ul> -->
					<!-- </div>
				</div> 
				
			</div>
		</div>
	</div>	 -->	
</div>
@stop

@section('page_plugins')
@parent
@include('edit/page_plugins')
@stop

@section('page_scripts')
@parent
@include('edit/page_scripts')
<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
@stop

@section('view_js')
@parent
{{ get_edit_js( $mod ) }}
@stop





