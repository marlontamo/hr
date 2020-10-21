@extends('layouts.master')

@section('page_content')
	@parent
   
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="row">
		<div class="col-md-9">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption"><i class="fa {{ $mod->icon}}"></i>{{ $current_group->group_name }}</div>
					<div class="caption" id="head-caption">&nbsp;</div>
				</div>
				@if( isset( $permission['add']) && $permission['add'] && !$mod->check_pending_request( $current_group->group_id, $user['user_id'] ) )
					<div class="clearfix">
						<div class="alert alert-warning">
							Join this group to see the discussion, post and comment.
							<button id="goadd" onclick="join_group({{ $current_group->group_id }})" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Join Group</button>
						</div>
					</div>
				@else
					<div class="clearfix">
						<div class="alert alert-warning">
							Join this group to see the discussion, post and comment.
							<span id="goadd" class="btn btn-sm btn-default pull-right">Request Pending</span>
						</div>
					</div>
				@endif
					
				<div class="portlet-title">
					<div class="caption"><i class="fa {{ $mod->icon}}"></i>Members</div>
					<div class="caption" id="head-caption">&nbsp;</div>
				</div>
				<table class="table table-striped table-hover" style="width:100%">
					<tbody><?php
						$admins = $mod->get_admins( $current_group->group_id );
						if( $admins ):
							foreach( $admins as $admin ): 
								$photo = get_photo( $admin->photo ); ?>
								<tr>
									<td width="7%"><img class="avatar img-responsive" width="45px" src="{{ $photo['avatar'] }}"> </td>
									<td>
										<span class="text-success">{{ $admin->full_name }}</span><br>
										<span class="text-muted small">{{ $admin->position }}</span></td>
									<td width="1%" class="text-right"><span class="text-success text-sm">Admin</span></td>
								</tr><?php
							endforeach;
						endif;
						$members = $mod->get_members( $current_group->group_id );
						if( $members ):
							foreach( $members as $member ): 
								$photo = get_photo( $member->photo ); ?>
								<tr>
									<td width="1%"><img class="avatar img-responsive" width="45px" src="{{ $photo['avatar'] }}"> </td>
									<td>
										<span class="text-success">{{ $member->full_name }}</span><br>
										<span class="text-muted small">{{ $member->position }}</span></td>
									<td width="1%" class="text-right"><span class="text-info text-sm">Member</span></td>
								</tr><?php
							endforeach;
						endif;?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">				
                @include('restricted/list_filter')
			</div>
		</div>
	</div>
	<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
	@parent

@stop

@section('view_js')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/{{ $mod->mod_code }}/restricted.js"></script>
@stop
