<tr class="record">
<td>
    <div>
        <input type="checkbox" class="record-checker checkboxes" value="<?php echo $record_id; ?>" />
    </div>
</td>
<td>
    <a id="partners_offense_sanction_sanction_category_id" href="{{ $detail_url }}">{{ $partners_offense_sanction_sanction_category_id }}</a>
</td>
<td>
{{ $partners_offense_sanction_sanction_level_id }}
</td>
<td>
{{ $partners_offense_sanction_sanction }}
</td>   
    <td>
        @if( isset( $permission['edit'] ) && $permission['edit'] )
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('offense_sanction.edit') }}</a>
        </div>
        @endif
        @if( !empty( $options ) )
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('offense_sanction.options') }}</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
        @endif
    </td>
</tr>