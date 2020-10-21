@extends('layouts.master')

@section('head')
	@parent
	<style type="text/css">
		.fa-class {color:#646464;font-size:2.5em;line-height:1em;}
	</style>
@stop

@section('page-title')
	<h3 class="page-title">
		<?php echo lang('dashboard.pymanager') ?> <small><?php echo lang('dashboard.pay_csection') ?></small>
	</h3>
@stop

@section('page_content')
	@parent
	<div class="row">
		<div class="col-md-4">

			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><?php echo lang('dashboard.pay_ref') ?></div>
				</div>
				<div class="portlet-body">
					<div class="clearfix">

						<ul class="media-list">
							<!-- TRANSACTION LIST -->
								<li class="media {{ $payroll_view_permission['payroll_transactions'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('payroll_transactions') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_list') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('payroll_transactions') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>	
							<!-- LOANS TYPES-->
								<li class="media {{ $payroll_view_permission['loan_type'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('loan_type') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_ltypes') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('loan_type') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>	
							<!-- LOANS -->
								<li class="media {{ $payroll_view_permission['loan'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('loan') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_loans') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('loan') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- OVERTIME RATES -->
								<li class="media {{ $payroll_view_permission['overtime_rates'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('overtime_rates') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_otrates') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('overtime_rates') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>	
							<!-- ACCOUNT CHARTS -->
								<li class="media {{ $payroll_view_permission['accounts_chart'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('accounts_chart') }}" class="hidden-xs pull-left">
										<i class="fa fa-copy fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.util_acharts') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('accounts_chart') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- Sub Account Chart -->
								<li class="media {{ $payroll_view_permission['sub_accounts_chart'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('sub_accounts_chart') }}" class="hidden-xs pull-left">
										<i class="fa fa-copy fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.util_sacharts') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('sub_accounts_chart') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- BANK -->
	                            <li class="media {{ $payroll_view_permission['bank_settings'] ? '' : 'hidden' }}">
	                                <a href="{{ get_mod_route('bank_settings') }}" class="hidden-xs pull-left">
	                                    <i class="fa fa-pencil-square-o fa-class"></i>
	                                </a>
	                                <div class="media-body">
	                                    <h4 class="media-heading"><?php echo lang('dashboard.pay_bank_settings') ?></h4>
	                                    <p class="small">
	                                        <?php echo lang('dashboard.util_master') ?>
	                                    </p>
	                                    <a class="btn btn-xs green" href="{{ get_mod_route('bank_settings') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
	                                </div>
	                            </li>       
	                        <!-- LEAVE CONVERSION -->
		                        <li class="media {{ $payroll_view_permission['leave_conversion'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('leave_conversion') }}" class="hidden-xs pull-left">
										<i class="fa fa-pencil-square-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_leave_convert') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('leave_conversion') }}"><?php echo lang('dashboard.pay_leave_convert') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
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
					<div class="caption"><?php echo lang('dashboard.general') ?></div>
				</div>
				<div class="portlet-body">
					<div class="clearfix">

						<ul class="media-list">

							<li class="media {{ $payroll_view_permission['settings'] ? '' : 'hidden' }}">
								<a href="#" class="hidden-xs pull-left">
									<i class="fa fa-wrench fa-class"></i>
								</a>
								<div class="media-body">
									<h4 class="media-heading"><?php echo lang('dashboard.util_settings') ?></h4>
									<p class="small">
										<?php echo lang('dashboard.util_master') ?>
									</p>
									<a class="btn btn-xs green" href="#"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
								</div>
							</li>
							<!-- TRANSACTION CLASS -->
								<li class="media {{ $payroll_view_permission['transaction_class'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('transaction_class') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_class') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('transaction_class') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- RATES -->
								<li class="media {{ $payroll_view_permission['rate_type'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('rate_type') }}" class="hidden-xs pull-left">
										<i class="fa fa-pencil-square-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.util_rates') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('rate_type') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- METHOD -->
								<li class="media {{ $payroll_view_permission['transaction_method'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('transaction_method') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_method') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('transaction_method') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- MODES -->
								<li class="media {{ $payroll_view_permission['transaction_mode'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('transaction_mode') }}" class="hidden-xs pull-left">
										<i class="fa fa-folder-open-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.pay_modes') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('transaction_mode') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>
							<!-- ACCOUNT TYPES -->
								<li class="media {{ $payroll_view_permission['account_type'] ? '' : 'hidden' }}">
									<a href="{{ get_mod_route('account_type') }}" class="hidden-xs pull-left">
										<i class="fa fa-file-text-o fa-class"></i>
									</a>
									<div class="media-body">
										<h4 class="media-heading"><?php echo lang('dashboard.util_atypes') ?></h4>
										<p class="small">
											<?php echo lang('dashboard.util_master') ?>
										</p>
										<a class="btn btn-xs green" href="{{ get_mod_route('account_type') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
									</div>
								</li>							
							<!-- WTAX Table -->
	                            <li class="media {{ $payroll_view_permission['whtax_table'] ? '' : 'hidden' }}">
	                                <a href="{{ get_mod_route('whtax_table') }}" class="hidden-xs pull-left">
	                                    <i class="fa fa-pencil-square-o fa-class"></i>
	                                </a>
	                                <div class="media-body">
	                                    <h4 class="media-heading"><?php echo lang('dashboard.whtax_table') ?></h4>
	                                    <p class="small">
	                                        <?php echo lang('dashboard.util_master') ?>
	                                    </p>
	                                    <a class="btn btn-xs green" href="{{ get_mod_route('whtax_table') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
	                                </div>
	                            </li>	  	 
                            <!-- Annual Tax Rates -->
	                            <li class="media {{ $payroll_view_permission['annual_tax_rate'] ? '' : 'hidden' }}">
	                                <a href="{{ get_mod_route('annual_tax_rate') }}" class="hidden-xs pull-left">
	                                    <i class="fa fa-pencil-square-o fa-class"></i>
	                                </a>
	                                <div class="media-body">
	                                    <h4 class="media-heading"><?php echo lang('dashboard.annual_tax_rate') ?></h4>
	                                    <p class="small">
	                                        <?php echo lang('dashboard.util_master') ?>
	                                    </p>
	                                    <a class="btn btn-xs green" href="{{ get_mod_route('annual_tax_rate') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
	                                </div>
	                            </li>	 
                            <!-- SSS Table -->
	                            <li class="media {{ $payroll_view_permission['sss_table'] ? '' : 'hidden' }}">
	                                <a href="{{ get_mod_route('sss_table') }}" class="hidden-xs pull-left">
	                                    <i class="fa fa-pencil-square-o fa-class"></i>
	                                </a>
	                                <div class="media-body">
	                                    <h4 class="media-heading"><?php echo lang('dashboard.sss_table') ?></h4>
	                                    <p class="small">
	                                        <?php echo lang('dashboard.util_master') ?>
	                                    </p>
	                                    <a class="btn btn-xs green" href="{{ get_mod_route('sss_table') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
	                                </div>
	                            </li>		 
                            <!-- PhilHealth Table -->
	                            <li class="media {{ $payroll_view_permission['phic_table'] ? '' : 'hidden' }}">
	                                <a href="{{ get_mod_route('phic_table') }}" class="hidden-xs pull-left">
	                                    <i class="fa fa-pencil-square-o fa-class"></i>
	                                </a>
	                                <div class="media-body">
	                                    <h4 class="media-heading"><?php echo lang('dashboard.phic_table') ?></h4>
	                                    <p class="small">
	                                        <?php echo lang('dashboard.util_master') ?>
	                                    </p>
	                                    <a class="btn btn-xs green" href="{{ get_mod_route('phic_table') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
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
				<h4 class="block"><?php echo lang('dashboard.linked_menu') ?></h4>
				<div class="list-group">
					<a class="list-group-item" href="{{ get_mod_route('user_manager') }}"><?php echo lang('dashboard.umanager') ?> <i class="fa fa-user pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.pnmanager') ?> <i class="fa fa-folder-open-o pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.amanager') ?> <i class="fa fa-trophy pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.trmanager') ?> <i class="fa fa-clock-o pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.plmanager') ?> <i class="fa fa-search-plus pull-right"></i></a>
					<a class="list-group-item active bg-blue" href="javascript:;"><?php echo lang('dashboard.pymanager') ?> <i class="fa fa-money pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.tmanager') ?> <i class="fa fa-th pull-right"></i></a>
					<a class="list-group-item" href="javascript:;"><?php echo lang('dashboard.asmanager') ?> <i class="fa fa-bar-chart-o pull-right"></i></a>
				</div>

			</div>
		</div>
	</div>
@stop

@section('module_js')
	<!-- Add Module JS -->
	{{ get_module_js( $mod, false ) }}
@stop