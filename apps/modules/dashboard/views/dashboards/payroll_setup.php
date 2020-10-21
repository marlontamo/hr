@extends('layouts.master')


@section('page-title')
	<h3 class="page-title">
		<?php echo lang('dashboard.payroll') ?> <small><?php echo lang('dashboard.pay_settings') ?></small>
	</h3>
@stop

@section('page-breadcrumb')
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ base_url('') }}">Home</a> 
			<i class="fa fa-angle-right"></i>
		</li>
		@if( $mod->method != "index" )
			<li>{{ ucwords( $mod->method )}}</li>
		@endif
	</ul>
@stop


@section('page_content')
	@parent


	<div class="row">
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<!-- ?php echo lang('dashboard.pay_setup') ?>: --> 
						<span class="text-muted small"><?php echo lang('dashboard.pay_confi') ?></span>
					</div>

					<div class="tools">
						<a href="javascript:;" class="collapse"></a>
					</div>
				</div>
				<div class="portlet-body note">
					<!-- [1] Period -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_period') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_period_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" href="{{ get_mod_route('payroll_period') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [2] Partners -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_emp') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_emp_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" href="{{ get_mod_route('payroll_employee') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [3] Partners Loan -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.emp_loans') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.emp_loans_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('partner_loan') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [4] DTR Summary -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.dtr_sum') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.dtr_sum_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('dtr_summary') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<!-- ?php echo lang('dashboard.pay_setup') ?>: --> 
						<span class="text-muted small"><?php echo lang('dashboard.list_app') ?></span>
					</div>

					<div class="tools">
						<a href="javascript:;" class="collapse"></a>
					</div>
				</div>
				<div class="portlet-body note">
					<!-- [1] Recurring Entries -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_recur') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_recur_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('recurring_transaction') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [2] Batch Entries -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_btran') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_btran_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('batch_transaction') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [3] Bonus Entries -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_bonus') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_bonus_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('bonus') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [4] Payroll Transaction -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.pay_tran') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.pay_tran_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-success" href="{{ get_mod_route('current_transaction') }}"><?php echo lang('dashboard.pay_curr') ?>&nbsp;</a>
						</div>					
						<div class="clearfix"></div>
					</div>
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.pay_tran') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.pay_tran_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-info" href="{{ get_mod_route('closed_transaction') }}">&nbsp;<?php echo lang('dashboard.pay_close') ?>&nbsp;&nbsp;</a>
						</div>						
						<div class="clearfix"></div>
					</div>					
					<!-- [5] SBR -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.def_sbr') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.def_sbr_desc') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" type="button" href="{{ get_mod_route('sbr') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [6] YTD -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo "YTD" ?></h4>
							<div class="text-muted small"><?php echo "Year To Date" ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a type="button" class="btn btn-default" href="{{ get_mod_route('ytd') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<!-- [7] LEAVE CONVERSION -->
					<div>
						<div class="col-md-9 margin-bottom-10">
							<h4><?php echo lang('dashboard.pay_leave_convert') ?></h4>
							<div class="text-muted small"><?php echo lang('dashboard.pay_leave_convert') ?></div>
						</div>
						<div class="col-md-3 margin-bottom-25">
							<a class="btn btn-default" href="{{ get_mod_route('leave_conversion_period') }}"><?php echo lang('dashboard.view_list_button') ?></a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop

@section('module_js')
	<!-- Add Module JS -->
	{{ get_module_js( $mod, false ) }}
@stop
