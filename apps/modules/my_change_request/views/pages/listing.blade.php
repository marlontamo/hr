@extends('layouts.master')

@section('page_styles')
	@parent
<link rel="stylesheet" type="text/css" href="<?php echo theme_path(); ?>plugins/jquery-tags-input/jquery.tagsinput.modal.css" />
	@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
						<li class="active"><a>{{ lang('common.personal') }}</a></li>
						@if( $approver )
							<li><a href="{{ get_mod_route('change_request') }}">{{ lang('common.manage') }}</a></li>
						@endif
					</ul>
					<div class="tab-content">
						<div class="portlet margin-bottom-50 margin-top-20">
							<div class="portlet-title">
								<div class="caption" id="head-caption">{{ lang('my_change_request.update_history') }}</div>
								<div class="actions">
									<a id="goadd" href="javascript:show_cr_form()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
								</div>
							</div>
						</div>
						<div class="clearfix">
							<table id="record-table" class="table table-condensed table-striped table-hover">
			                    <thead>
			                        <tr>
			                            @include('list_template_header')
			                            <th width="20%">
			                                Actions
			                            </th>
			                        </tr>
			                    </thead>
			                    <tbody id="record-list"></tbody>
			                </table>
			                <div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
                	@include('common/search-form')
                	<div class="actions margin-top-20 clearfix">
	                	<span class="pull-right"><a class="text-muted" id="trash" href="javascript:view_trash()">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div>
				</div>
				
                @include('list_filter')
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
<script src="<?php echo theme_path(); ?>plugins/jquery-tags-input/jquery.tagsinput.min.js" type="text/javascript" ></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop
