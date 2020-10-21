@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
	<div class="col-md-11">
		<!-- BEGIN FORM-->
		<div class="row">
			<!-- FORM -->
			<div class="col-md-12">

				<div class="portlet">
					<div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                            	<div class="note note-default">

				                    <h3 class="page-title">
				                    <?php echo lang('dashboard.pay_ref') ?>:
				                    </h3>
				                    <!-- <p class="small">{{ lang('user_manager.p_profiles') }}</p> -->

				                    <hr class="margin-bottom-25" />

									<div class="{{ $payroll_view_permission['payroll_transactions'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_list')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('payroll_transactions') }}" href="{{ get_mod_route('payroll_transactions') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['loan_type'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_ltypes')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('loan_type') }}" href="{{ get_mod_route('loan_type') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['loan'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_loans')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('loan') }}" href="{{ get_mod_route('loan') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['overtime_rates'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_otrates')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('overtime_rates') }}" href="{{ get_mod_route('overtime_rates') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['overtime_rates_fixed_amount'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_otrates_fa')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('overtime_rates_fixed_amount') }}" href="{{ get_mod_route('overtime_rates_fixed_amount') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['accounts_chart'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.util_acharts')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('accounts_chart') }}" href="{{ get_mod_route('accounts_chart') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['sub_accounts_chart'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.util_sacharts')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('sub_accounts_chart') }}" href="{{ get_mod_route('sub_accounts_chart') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['bank_settings'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_bank_settings')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('bank_settings') }}" href="{{ get_mod_route('bank_settings') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['leave_conversion'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_leave_convert')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('leave_conversion') }}" href="{{ get_mod_route('leave_conversion') }}">{{ lang('dashboard.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
                        </form>
					</div>
				</div>

				<div class="portlet">
					<div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                            	<div class="note note-default">

				                    <h3 class="page-title">
				                    <?php echo lang('dashboard.general') ?>:
				                    </h3>
				                    <!-- <p class="small">{{ lang('user_manager.p_set_con') }}</p> -->

				                    <hr/>

									<div class="{{ $payroll_view_permission['transaction_class'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_class')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('transaction_class') }}" href="{{ get_mod_route('transaction_class') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['rate_type'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.util_rates')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('rate_type') }}" href="{{ get_mod_route('rate_type') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['transaction_method'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_method')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('transaction_method') }}" href="{{ get_mod_route('transaction_method') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['transaction_mode'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.pay_modes')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('transaction_mode') }}" href="{{ get_mod_route('transaction_mode') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['account_type'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.util_atypes')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('account_type') }}" href="{{ get_mod_route('account_type') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['whtax_table'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.whtax_table')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('whtax_table') }}" href="{{ get_mod_route('whtax_table') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['annual_tax_rate'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.annual_tax_rate')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('annual_tax_rate') }}" href="{{ get_mod_route('annual_tax_rate') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['sss_table'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.sss_table')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('sss_table') }}" href="{{ get_mod_route('sss_table') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>

									<div class="{{ $payroll_view_permission['phic_table'] ? '' : 'hidden' }}">
										<div class="col-md-9 margin-bottom-10">
											<h4>{{ lang('dashboard.phic_table')}}</h4>
											<div class="text-muted small"></div>
										</div>
										<div class="col-md-3 margin-bottom-25">
											<a class="btn btn-default" type="button" rel="{{ get_mod_route('phic_table') }}" href="{{ get_mod_route('phic_table') }}">{{ lang('user_manager.view_list_button') }}</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
                        </form>
					</div>
				</div>
			</div>
		</div>
        <!-- END FORM-->
	</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
@parent
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
