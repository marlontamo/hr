<div class="row">
	@if( isset( $regularLeaves ) && sizeof( $regularLeaves ) > 0 )
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">{{ lang('form_application.leave_form') }}</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body" style="display: block;">
				<div class="clearfix">	
					<ul class="app-list">
					@foreach( $regularLeaves as $form )
						<li class="in2">
							<div class="appicon">
								<i class="{{ $form['class'] }}"></i>
							</div>
							@if(array_key_exists ( $form['form_id'] , $no_credit_disable ))
								@if($no_credit_disable[$form['form_id']] == 0)
									<a class="btn btn-sm green pull-right" href="javascript:add_applicable_form( 'lwop' )">
										<i class="fa fa-plus"></i>
									</a>
								@else
									<a class="btn btn-sm green pull-right" href="javascript:add_applicable_form( '{{ strtolower($form['form_code']) }}' )">
										<i class="fa fa-plus"></i>
									</a>
								@endif
							@else
								<a class="btn btn-sm green pull-right" href="javascript:add_applicable_form( '{{ strtolower($form['form_code']) }}' )">
									<i class="fa fa-plus"></i>
								</a>
							@endif
							<div class="listname">
								<span class="text-primary bold">{{ $form['form'] }}</span>
							</div>
							<div class="appinfo">
								<span class="italic small">{{ $form['description'] }}</span>
							</div>
						</li>
					@endforeach						
					</ul>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if( isset( $otherForms ) && sizeof( $otherForms ) > 0 )
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">{{ lang('form_application.other_forms') }}</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>

			<div class="portlet-body">
				<div class="clearfix">
					<ul class="app-list">
					@foreach( $otherForms as $form )
						<li class="in2">
							<div class="appicon">
								<i class="{{ $form['class'] }}"></i>
							</div>
							<a class="btn btn-sm green pull-right" href="javascript:add_applicable_form( '{{ strtolower($form['form_code']) }}' )">
									<i class="fa fa-plus"></i>
								</a>
							<div class="listname">
								<span class="text-primary bold">{{ $form['form'] }}</span>
							</div>
							<div class="appinfo">
								<span class="italic small">{{ $form['description'] }}</span>
							</div>
						</li>	
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if( isset( $specialLeaves ) && sizeof( $specialLeaves ) > 0 )
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">{{ lang('form_application.special_leave') }}</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body" style="display: block;">
				<div class="clearfix">
					<ul class="app-list">
					@foreach( $regularLeaves as $form )
						<li class="in2">
							<div class="appicon">
								<i class="{{ $form['class'] }}"></i>
							</div>
							<a class="btn btn-sm green pull-right" href="javascript:add_applicable_form( '{{ strtolower($form['form_code']) }}' )">
									<i class="fa fa-plus"></i>
								</a>
							<div class="listname">
								<span>{{ $form['form'] }}</span>
							</div>
							<div class="appinfo">
								<span class="italic small">{{ $form['description'] }}</span>
							</div>
						</li>
					@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	@endif
	
	<div class="col-md-2 hidden">
		<div class="portlet">
			<div class="clearfix">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="panel-title">{{ lang('form_application.leave_status') }}</h4>
					</div>
										
					<table class="table">
						<thead>
							<tr>
								<th class="small">{{ lang('form_application.type') }}</th>
								<th class="small">{{ lang('form_application.pending') }}</th>
								<th class="small">{{ lang('form_application.approved') }}</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach( $form_status as $form_status_info ){ 
								if( $form_status_info['is_leave'] == 1 && in_array($form_status_info['form_id'], $leave_forms)){
							?>
							<tr>
								<td class="small">{{ $form_status_info['form'] }}</td>
								<td class="small text-info">{{ $form_status_info['pending'] }}</td>
								<td class="small text-success">{{ $form_status_info['approved'] }}</td>
							</tr>
							<?php 
								}
							} ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="clearfix">
				<div class="panel panel-success">
					<!-- Default panel contents -->
					<div class="panel-heading">
						<h4 class="panel-title">{{ lang('form_application.other_fstatus') }}</h4>
					</div>
					
					<!-- Table -->
					<table class="table">
						<thead>
							<tr>
								<th class="small">{{ lang('form_application.type') }}</th>
								<th class="small">{{ lang('form_application.pending') }}</th>
								<th class="small">{{ lang('form_application.approved') }}</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach( $form_status as $form_status_info ){ 
								if( $form_status_info['is_leave'] == 0  && in_array($form_status_info['form_id'], $other_forms)){
							?>
							<tr>
								<td class="small">{{ $form_status_info['form'] }}</td>
								<td class="small text-info">{{ $form_status_info['pending'] }}</td>
								<td class="small text-success">{{ $form_status_info['approved'] }}</td>
							</tr>
							<?php 
								}
							} ?>
						</tbody>

					</table>
				</div>
			</div>
		</div>
	</div>
</div>