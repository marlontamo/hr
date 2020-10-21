<tr class="record">

    <td class="hidden-xs">
	   <input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes">
    </td>

    <td>
        {{ $class_code}}
		<br>
		<span class="help-block small">{{ $form }}</span>
		<span class="help-block small">{{ $description }}</span>
    </td>

    <!-- td>
        {{ $form }}
    </td -->

    <!-- td>
        {{ $severity }}
    </td -->

    <td>
        {{ $class_value }}
		<br>
		<span class="help-block small">{{ $severity }}</span>
    </td>

    <!-- td>
        {{ $description }}
    </td -->
    

    <td>
        @if( isset($permission['edit']) AND $permission['edit'] == 1 )

            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
            </div>

            @if( isset($permission['detail']) AND isset($permission['delete']) AND ( $permission['detail'] == 1 AND $permission['delete'] == 1 ) )

                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
                    <ul class="dropdown-menu pull-right">
                        {{ $options }}
                    </ul>
                </div> 

            @elseif( isset($permission['detail']) AND $permission['detail'] == 1 )

                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
                </div>

            @elseif( isset($permission['delete']) AND $permission['delete'] == 1 )

                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> Delete</a>
                </div>

            @endif

        @elseif( isset($permission['detail']) AND $permission['detail'] == 1 )

            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> View</a>
            </div>

            @if( isset($permission['delete']) AND $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> Delete</a>
                </div>
            @endif

        @elseif( isset($permission['delete']) AND $permission['delete'] == 1 )

            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> Delete</a>
            </div>

        @endif
    </td>
</tr>
