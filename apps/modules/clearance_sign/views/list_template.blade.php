<tr class="record">
	<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td> -->
	<?php if( $can_delete != 0 ){ ?>
        <td>
            <div>
                <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
            </div>
        </td>
    <?php }else{ ?>
        <td>
            <div>
            </div>
        </td>
    <?php } ?>
	<td>
    	<a id="layout_name" href="{{ $detail_url }}">{{$layout_name}}</a>
	</td>
	<td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('clearance_signatories.edit') }}</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('clearance_signatories.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>

</tr>