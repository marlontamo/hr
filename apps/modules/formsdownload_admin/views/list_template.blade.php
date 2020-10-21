<tr class="record">
	<td>
		<a href="#" class="text-success">{{$createdbyname}}</a>
		<br />
		<span class="small">{{$login}}</span>
	</td>
	<td>
		<a href="#" class="text-success">{{$resources_downloadable_title}}</a>
	</td>
    <td class="hidden-xs"><?php echo date("M-d",strtotime($resources_downloadable_created_on)); ?> <span class="text-muted small"><?php echo date("D",strtotime($resources_downloadable_created_on)); ?></span><br>
        <span class="text-muted small"><?php echo date("Y",strtotime($resources_downloadable_created_on)); ?></span>
    </td>
	<td>
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{$quickedit_url}}"><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>
		</div>

			<?php 
				$file = FCPATH . urldecode( $resources_downloadable_attachments);
				if( file_exists( $file ) )
				{
					$f_info = get_file_info( $file );
					$f_type = filetype( $file );

					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$f_type = finfo_file($finfo, $file);
				
			?>
			<a href="{{ base_url($resources_downloadable_attachments) }}" target="_blank" class="btn btn-xs text-muted">
				<span class="padding-right-5">
				    <i class="fa fa-search"></i>
				</span> 
				View
			</a>
			<?php
				}
			?>
       <!--  @if( $options != "" )
	        <div class="btn-group">
	            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
	            <ul class="dropdown-menu pull-right">
		    		<li><a href="javascript: ajax_export({{$record_id}})" ><i class="fa fa-search"></i> View</a></li>
		    		<li><a href="{{$export_url}}"><i class="fa fa-print"></i> Export</a></li>
	            </ul>
	        </div>
        @endif -->
		<!-- <div class="btn-group">
			<a class="btn btn-xs text-muted" href="#" data-close-others="true" data-hover="dropdown" data-toggle="dropdown-toggle"><i class="fa fa-gear"></i> Options</a>
			<ul class="dropdown-menu pull-right">
			</ul>
		</div>
 -->	</td>
</tr>