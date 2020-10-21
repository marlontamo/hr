<tr class="record">
	<td>
		<span class="text-success">{{ $performance_template_template }}</span>
		<br>
		<span class="small">{{ $performance_template_template_code }}</span>
	</td>
	<td class="hidden-xs">
		{{ $performance_template_applicable_to_id }}
	</td>
	<td class="hidden-xs">
		<?php
			if( !empty( $performance_template_applicable_to ) )
			{
				$applicable_tos = $mod->_get_applicable_options($applicable_to_id,$performance_template_applicable_to);
				unset($applicable_tos[''] );
				foreach($applicable_tos as $applicable_to )
				{?>
					<span class="btn btn-xs text-muted default"> {{ $applicable_to }}</span><?php
				}
			}
		?>
	</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>