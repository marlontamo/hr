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
								<li class="list-group-item"><?=$value['display_name']?>
									<br><small class="text-muted"><?=$value['position']?></small>
								<?php if($value['movement_status_id'] >= 2){ 
							            $form_style = 'info';
							            switch($value['movement_status_id']){
							                case 7:
							                    $form_style = 'danger';
							                break;
							                case 3:
							                case 6:
							                    $form_style = 'success';
							                break;
							                case 5:
							                case 4:
							                case 2:
							                    $form_style = 'warning';
							                break;
							                case 1:
							                    $form_style = 'info';
							                break;
							                case 8:
							                default:
							                    $form_style = 'default';
							                break;
							            }
							        ?>
								<br><p><span class="badge badge-<?php echo $form_style ?>"><?=$value['status']?></span></p> </li>
							<?php }
							} ?>
						</ul>
					</div>
				</div>
				<div class="clearfix">
					<div class="panel panel-success">
						<div class="panel-heading">
							<h4 class="panel-title">HR Approval Status</h4>
						</div>

						<ul class="list-group">
							<?php foreach($hr_approver_list as $index => $value){ ?>
								<li class="list-group-item"><?=$value['display_name']?>
									<br><small class="text-muted"><?=$value['position']?></small>
								<?php if($value['movement_status_id'] >= 2){ 
							            $form_style = 'info';
							            switch($value['movement_status_id']){
							                case 7:
							                    $form_style = 'danger';
							                break;
							                case 3:
							                case 6:
							                case 11:
							                    $form_style = 'success';
							                break;
							                case 5:
							                case 4:
							                case 2:
							                case 9:
							                    $form_style = 'warning';
							                break;
							                case 1:
							                    $form_style = 'info';
							                break;
							                case 8:
							                default:
							                    $form_style = 'default';
							                break;
							            }
							        ?>
								<br><p><span class="badge badge-<?php echo $form_style ?>"><?=$value['status']?></span></p></li>									
							<?php } } ?>
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
	<script type="text/javascript" src="{{ theme_path() }}modules/movement_admin/edit_custom.js"></script>  
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop