@extends('layouts.master')

@section('head')
	@parent
	<style type="text/css">
		.fa-class {color:#646464;font-size:2.5em;line-height:1em;}
	</style>
@stop

@section('page-title')
	<h3 class="page-title">
		<?php echo lang('dashboard.admin_util') ?> <small><?php echo lang('dashboard.util_desc') ?></small>
	</h3>
@stop

@section('page_content')
	@parent
	<div class="row">
		<div class="col-md-4">

			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><?php echo lang('dashboard.util_database') ?></div>
				</div>
				<div class="portlet-body">
					<div class="clearfix">

						<ul class="media-list">
							<li class="media">
								<a href="{{ get_mod_route('db_backup') }}" class="hidden-xs pull-left">
									<i class="fa fa-folder-open-o fa-class"></i>
								</a>
								<div class="media-body">
									<h4 class="media-heading"><?php echo lang('dashboard.util_dbbackup') ?></h4>
									<p class="small">
										<?php echo lang('dashboard.util_manager') ?>
									</p>
									<a class="btn btn-xs green" href="{{ get_mod_route('db_backup') }}"><?php echo lang('dashboard.util_more') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
								</div>
							</li>															
						</ul>

					</div>
				</div>
                <div class="portlet-body">
                    <div class="clearfix">

                        <ul class="media-list">
                            <li class="media">
                                <a href="{{ get_mod_route('upload_manager') }}" class="hidden-xs pull-left">
                                    <i class="fa fa-cloud-upload fa-class"></i>
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo lang('dashboard.util_upload') ?></h4>
                                    <p class="small">
                                        <?php echo lang('dashboard.util_upload') ?>
                                    </p>
                                    <a class="btn btn-xs green" href="{{ get_mod_route('upload_manager') }}"><?php echo lang('dashboard.util_upload') ?><i class="fa fa-arrow-circle-o-right"></i></a> 
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
					<div class="caption"><?php echo lang('dashboard.util_misc') ?></div>
				</div>
				<div class="portlet-body">
					<div class="clearfix">

						<ul class="media-list">
							<li class="media">
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
							<li class="media">
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
							<li class="media">
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
							<li class="media">
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