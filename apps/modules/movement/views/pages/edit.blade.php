@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-9">
			<form class="form-horizontal">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('edit/custom_fgs')
				<!-- @include('buttons/edit') -->
			</form>
       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="clearfix margin-bottom-20">
					@include('common/search-form')
					<div class="actions margin-top-20 clearfix">
						<span class="pull-left"><a class="text-muted" href="{{ $mod->url }}">Back to List &nbsp;<i class="m-icon-swapright"></i></a></span>
						<span class="pull-right"><a class="text-muted" id="trash">{{ lang('common.trash_folder') }} <i class="fa fa-trash-o"></i></a></span>
					</div>
				</div>
				<div class="clearfix">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">Approval Status</h4>
						</div>

						<ul class="list-group">
							<?php foreach($approver_list as $index => $value){ ?>
								<li class="list-group-item"><?=$value['lastname'].', '.$value['firstname']?>
									<br><small class="text-muted"><?=$value['position']?></small>
							<?php } ?>
						</ul>
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
	<script type="text/javascript" src="{{ theme_path() }}modules/movement/edit_custom.js"></script>  
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop