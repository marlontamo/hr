<tr class="record">
    <td>
        <a href="{{ $detail_url }}" id="date_name" class="text-success">{{ $recruitment_firstname }} {{ $recruitment_lastname }}</a>
        <br>
        <span class="small text-muted" id="date_set">{{ $applicant_type }}</span>
    </td>
    <td class="hidden-xs" >
        <span class="text-success">
            {{ $recruitment_position_sought }}
        </span>
     <br>
        <span class="small" >{{ $document_no }}</span>
    </td>
    <td class="hidden-xs">
        <span class="text-success">
            {{ $degree}}
        </span>
        <br />
        <span class="small">{{ $school }}</span>
    </td>
    <td class="hidden-xs">
        <?php 
            switch($recruitment_status_id){
                case 11:
                case 1:
                    ?><span class="badge badge-warning">{{ $recruit_status }}</span><?php
                break;
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                    ?><span class="badge badge-info">{{ $recruit_status }}</span><?php
                break;
                case 7:
                    ?><span class="badge badge-success">{{ $recruit_status }}</span><?php
                break;
                case 8:
                case 9:
                case 10:
                    ?><span class="badge badge-danger">{{ $recruit_status }}</span><?php
                break;
         } ?>
         @if(strtotime($recruitment_modified_on))
             <br>
            <span class="small text-muted" id="date_set">{{ date('F d, Y', strtotime($recruitment_modified_on)) }}</span>
        @endif    
     </td>
    <td>
        @if( $permission['edit'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
            </div>
            @if( $permission['detail'] == 1 AND $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                    <ul class="dropdown-menu pull-right">
                        @if($recruitment_status_id == 7)
                            <li><a href="javascript: history({{ $process_id }}, {{ $record_id }})"><i class="fa fa-file"></i> History</a></li>
                        @endif
                        {{ $options }}
                    </ul>
                </div> 
            @elseif( $permission['detail'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
                    <ul class="dropdown-menu pull-right">
                        <li><a class="" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a></li>
                        <li><a href="javascript: ajax_export({{ $record_id }})"><i class="fa fa-print"></i> Print</a></li>                        
                    </ul>
                </div>
            @elseif( $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                </div>
            @endif
        @elseif( $permission['detail'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $detail_url }}"><i class="fa fa-search"></i> {{ lang('common.view') }}</a>
            </div>
            @if( $permission['delete'] == 1 )
                <div class="btn-group">
                    <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                </div>
            @endif
        @elseif( $permission['delete'] == 1 )
            <div class="btn-group">
                <a class="btn btn-xs text-muted" href="{{ $delete_url_javascript }}"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
            </div>
        @endif

    </td>
</tr>