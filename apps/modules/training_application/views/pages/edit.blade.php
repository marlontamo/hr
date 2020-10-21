@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-8">
			<form class="form-horizontal">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('edit/fgs')
				@include('buttons/edit')
			</form>
       	</div>  
       	
       	<div class="col-md-1"></div>

       	<div class="col-md-3">
			<div class="portlet">
				<div class="portlet-body">
					<div class="clearfix">
						<div class="panel panel-success">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<h4 class="panel-title">Training Budget</h4>
							</div>
							
							<!-- Table -->
							<table class="table">
								<thead>
									<tr>
										<th class="small">Type</th>
										<th class="small">Used</th>
										<th class="small">Bal</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="small">Individual Budget</td>
										<td class="small text-info">10,000</td>
										<td class="small text-success">15,000</td>
									</tr>
									<tr>
										<td class="small">Common Budget</td>
										<td class="small text-info">0.00</td>
										<td class="small text-success">10,000.00</td>
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
								<li class="list-group-item">Mahistrado, John<br><small class="text-muted">Manager</small> </li>
								<li class="list-group-item">Mendoza, Joel<br><small class="text-muted">Director</small> </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
    		
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
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop