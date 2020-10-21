<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-body">
			<div class="row">
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class=""><a href="{{ $mod->url }}/discussion/{{ $current_group->group_id }}">Discussion</a></li>
						<li class=""><a href="{{ $mod->url }}/members/{{ $current_group->group_id }}">Members</a></li>
						<li class=""><a href="{{ $mod->url }}/files/{{ $current_group->group_id }}">Files</a></li>
						<li class="active"><a href="{{ $mod->url }}/photos/{{ $current_group->group_id }}">Photo</a></li>
					</ul>
					<div class="tab-content">
						<input type="hidden" value="{{ $current_group->group_id }}" class="filter" name="group_id">
						<table id="record-table" class="table table-condensed table-striped table-hover">
		                    <tbody id="record-list"></tbody>
		                </table>
		                <div id="no_record" class="well" style="display:none;">
							<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
							<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
						</div>
						<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>	
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>