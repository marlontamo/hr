<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('permissions.basic_info') }}</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>{{ lang('permissions.profile_name') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="profiles[profile]" id="profiles-profile" value="{{ $record['profiles.profile'] }}" placeholder="{{ lang('permissions.p_profile_name') }}"/> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">{{ lang('permissions.description') }}</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="profiles[description]" id="profiles-description" value="{{ $record['profiles.description'] }}" placeholder="{{ lang('permissions.p_description') }}"/> 				</div>	
			</div>	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('permissions.data_access') }}</div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form" style="display: none;">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="36%">{{ lang('permissions.module') }}</th>
					<th width="16%" class="text-center">{{ lang('permissions.low') }}</th>
					<th width="16%" class="text-center">{{ lang('permissions.medium') }}</th>
					<th width="16%" class="text-center">{{ lang('permissions.high') }}</th>
					<th width="16%" class="text-center">{{ lang('permissions.critical') }}</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($modules as $mod_id => $module)
				@if($module->sensitivity_filter)
				<tr>
					<td>
						<span class="text-success">{{ $module->short_name }}</span><br/>
						<span class="small muted">{{ $module->mod_code }}</span>
					</td>
					<td class="text-center"><input type="checkbox" name="sensitivity[<?php echo $module->mod_id?>][1]" <?php echo isset($sensitivity[$mod_id][1]) ? 'checked="checked"' : '' ?>></td>
					<td class="text-center"><input type="checkbox" name="sensitivity[<?php echo $module->mod_id?>][2]" <?php echo isset($sensitivity[$mod_id][2]) ? 'checked="checked"' : '' ?>></td>
					<td class="text-center"><input type="checkbox" name="sensitivity[<?php echo $module->mod_id?>][3]" <?php echo isset($sensitivity[$mod_id][3]) ? 'checked="checked"' : '' ?>></td>
					<td class="text-center"><input type="checkbox" name="sensitivity[<?php echo $module->mod_id?>][4]" <?php echo isset($sensitivity[$mod_id][4]) ? 'checked="checked"' : '' ?>></td>
				</tr>
				@endif
			@endforeach
			</tbody>
		</table>

	</div>
	<div class="portlet-body form">	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('permissions.module_permission') }}</div>
		<div class="tools"><a class="expand" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form" style="display: none;">
		<table class="table table-bordered table-striped table-condensed flip-content">
			<thead class="flip-content">
				<tr>
					<th class="text-center" style="width:50%">{{ lang('permissions.module') }}</th>
					@foreach( $actions as $action_id => $action )
					<th class="text-center" style="width:10%">{{ $action->action }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				<?php 
				$parent_group = ''; 
				$sub_group = '';
				?>
				@foreach ($modules as $mod_id => $module)
				@if(!empty($module->parent_group))
					@if($parent_group != $module->parent_group)
						<tr>
							<td style="font-size:14px; font-weight: 600">
								{{ $module->parent_group}}
							</td>
						</tr>
						<?php $parent_group = $module->parent_group; ?>
					@endif
				@endif
				@if(!empty($module->sub_group))
					@if($sub_group != $module->sub_group)
						<tr>
							<td style="font-size:14px; font-weight: 600">
								{{ $module->parent_group.'-'.$module->sub_group}}
							</td>
						</tr>
						<?php $sub_group = $module->sub_group; ?>
					@endif
				@endif
					<tr class="module">
						<td>
							<!-- <span class="text-success">{{ lang('permissions.route') }}: </span>
							<span class="">{{ $module->route }}</span><br/> -->
							<!-- <span class=""></span> -->
							<span class="text-success tooltips" data-placement="right" data-original-title="{{ lang('permissions.route').': '.$module->route}}">{{ $module->long_name }}</span><br/>
						</td>
						@foreach( $actions as $action_id => $action )
							<td class="text-center"><input type="checkbox" name="permissions[{{ $mod_id }}][{{ $action_id }}]" <?php echo isset($permission[$mod_id][$action_id]) && $permission[$mod_id][$action_id] ? 'checked="checked"' : '' ?>></td>
						@endforeach	
					</tr>
				@endforeach	
			</tbody>
		</table>
	</div>
</div>