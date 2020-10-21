@extends('layouts.master')

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption" id="header-caption">&nbsp;</div>
					<div class="actions">
						<div class="btn-group">
                            <a id="goadd" href="javascript:quick_add()" class="btn btn-success"><i class="fa fa-plus"></i></a>
                        </div>

						<div class="btn-group">
                            <a class="btn default hidden-lg hidden-md" href="#" data-toggle="dropdown" data-close-others="true">
							<i class="fa fa-filter"></i> 
                            </a>
                            <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                            	<label>Options </label>
								<label><input type="radio" name="mobile-filter" value="{{ date('Y') + 1 }}"/> {{ date('Y') + 1 }}</label>
                                <label><input type="radio" name="mobile-filter" value="{{ date('Y') }}"/> {{ date('Y') }}</label>
								<div class="divider"></div>
								@for( $i = 1; $i <= 12; $i++ )
									<label><input type="radio" name="mobile-filter" value="{{ date("F", mktime(0, 0, 0, $i, 10)) }}"/> {{ date("F", mktime(0, 0, 0, $i, 10)) }}</label>	
								@endfor
								<div class="divider"></div>
								<label><input type="radio" name="mobile-filter" value="{{ date('Y') }}"/> {{ date('Y') - 1 }}</label>
							</div>
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
				</div>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<style>
					.event-block {cursor:pointer;margin-bottom:5px;display:inline-block;position:relative;}
				</style>
				<div class="portlet-title" style="margin-bottom:3px;">
					<div class="caption">Options</div>
					<span class="pull-right"><a href="javascript:view_trash()" id="trash" class="text-muted">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
				</div>

				<div class="portlet-body">
					<span class="small text-muted">Show inclusive date per calendar month</span>
					<div class="margin-top-10">
						<span class="event-block label label-info event-block-year" search="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</span></a>
						<span class="event-block label label-info event-block-year" search="{{ date('Y') }}">{{ date('Y') }}</span></a>
						@for( $i = 1; $i <= 12; $i++ )
							<span class="event-block label label-default" search="{{ date("F", mktime(0, 0, 0, $i, 10)); }}">{{ date("F", mktime(0, 0, 0, $i, 10)); }}</span>	
						@endfor
						<span class="event-block label label-info event-block-year" search="{{ date('Y') + 1 }}">{{ date('Y') + 1 }}</span>
					</div>
                </div>

				<div class="clearfix margin-bottom-20">
                	@include('common/search-form')
				</div>
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/dtr_processing/lists.js"></script>
@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/lists.js"></script>
	<script type="text/javascript">
		
	</script>
@stop