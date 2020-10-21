@extends('layouts.master')

@section('page_styles')
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/jquery-nestable/jquery.nestable.css" />
@stop

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-3">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-user"></i>{{ lang('menu_manager.choose_role') }}</div>
				</div>
				<div class="form-group"><?php
					$db->select('role,role_id');
					$db->where('deleted', '0');
					$db->order_by('role');
					$options = $db->get('roles');
					$role_options = array('' => 'Select...');
					foreach($options->result() as $option)
					{
						$role_options[$option->role_id] = $option->role;
					} ?>
					<div class="input-group">
						{{ form_dropdown('role_id', $role_options, '', 'class="form-control select2me" data-placeholder="Select..."') }}
					</div> 
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="portlet">
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-list"></i>{{ lang('menu_manager.menu_tree') }}</div>
						<div class="actions">
							<a href="javascript:save_role_menu()" class="save-btn btn btn-info"><i class="fa fa-save"></i></a>
							<a id="goadd" href="javascript:quick_add()" class="btn btn-success"><i class="fa fa-plus"></i></a>
						</div>
					</div>

				</div>
				<div class="portlet-body">
					<div class="dd" id="menu-tree"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/jquery-nestable/jquery.nestable.js"></script> 
@stop

@section('view_js')
	@parent
	<script src="{{ theme_path() }}modules/common/lists.js"></script>
	<script src="{{ theme_path() }}modules/{{ $mod->mod_code }}/manager.js"></script>
@stop