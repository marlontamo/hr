<tr class="record">
    <td>
        <div>
            <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
        </div>
    </td>
    <td class="hidden-xs">
        <a id="display_name" href="#" class="text-success">{{ $performance_planning_year }}</a>
    </td>
    <td class="hidden-xs">
        <span class="text-info">{{ $performance_planning_performance_type_id}}</span>
        <br>
        <span class="text-muted small">{{ $performance_planning_date_from }} to {{ $performance_planning_date_to }}</span>
    </td>
    <td class="hidden-xs">{{ $performance_planning_immediate}}</td>
    <td class="hidden-xs" style="color:#666">
    {{ $performance_planning_notes }}
    </td>
    <td class="hidden-xs">
        @if(strtolower($performance_planning_status_id) == 'yes')
        <span class="badge badge-info">{{ lang('performance_planning.open') }}</span>
        @else
        <span class="badge badge-success">{{ lang('performance_planning.close') }}</span>
        @endif
        <br>
        @if(strtotime($performance_planning_modified_on))
        <span class="text-muted small">
            {{ date('F d, Y', strtotime($performance_planning_modified_on)) }}
             - 
            {{ date('h:ia', strtotime($performance_planning_modified_on)) }}</</span>
        @else
        <span class="text-muted small">
            {{ date('F d, Y', strtotime($performance_planning_created_on)) }}
             - 
            {{ date('h:ia', strtotime($performance_planning_created_on)) }}
        </span>
        @endif
    </td> 
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>