@extends('layouts/master')

@section('page_styles')
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/jquery-nestable/jquery.nestable.css" />
	<link href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
@stop

@section('page_content')
	@parent
	<div class="row">
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-cogs"></i>Approver Settings</div>
					<div class="tools"><a class="collapse" href="javascript:;"></a></div>
				</div>
				<div class="portlet-body" style="display: block;">
					<div class="col-md-5">
						<div class="portlet ">
							<input type="hidden" name="set_for" value="" />
							<input type="hidden" name="set_for_id" value="" />
							<input type="hidden" name="company_id" value="" />
							<input type="hidden" name="department_id" value="" />
							<input type="hidden" name="position_id" value="" />
							<input type="hidden" name="user_id" value="" />
							
							<p class="small text-muted">Choose class then select by company, department or position to set approver/s.</p>
							<div class="portlet-body">
								<div class="form-group">
                                    <label class="control-label small">Select Class:</label>
                                    {{ form_dropdown('class_id',$class_options, '', 'class="form-control select2me" data-placeholder="Select..."') }}
                                </div>
                            </div>

                            <div class="dd" id="company-tree">
								<ol class="dd-list">
									@foreach( $companies as $company )
										<li class="dd-item dd-collapsed" company_id="{{ $company->company_id }}">
											<button type="button" data-action="expand-company" style="display: block;">Expand</button>
											<button type="button" data-action="collapse-company" style="display: none;">Collapse</button>
											<div class="dd-handle2">{{ $company->company }}</div>
											<span class="dd-action pull-right">
												<a class="btn btn-xs text-muted" href="javascript:get_company_signatories({{ $company->company_id }})"><i class="fa fa-gears"></i> Set</a>
											</span>
											<ol class="dd-list" company_id="{{ $company->company_id }}"></ol>
										</li>
									@endforeach
								</ol>
							</div>


						</div>
					</div>

					<div class="col-md-7 border-left">
						<div class="portlet">
							<p class="small text-muted">Signatory listing.</p>
							<div class="portlet-title">
								<div class="caption"></div>
	                            <div class="actions">
	                                <a class="btn btn-default btn-sm" href="javascript:edit_signatory('')">
	                                	<i class="fa fa-plus"></i>
	                                </a>
	                                <a class="btn btn-default btn-sm">
	                                	<i class="fa fa-trash-o"></i>
	                                </a>
								</div>
							</div>
							<div class="portlet-body" id="signatory-listing">	
								
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/jquery-nestable/jquery.nestable.js"></script>
	<script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
@stop

@section('view_js')
	@parent
	<script src="{{ theme_path() }}modules/{{ $mod->mod_code }}/manager.js"></script>
@stop