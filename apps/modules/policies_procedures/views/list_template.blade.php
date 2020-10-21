<tr class="record">
	<td>
		<?php 
			$file = FCPATH . urldecode( $resources_policies_attachments);
			if( file_exists( $file ) )
			{
				$f_info = get_file_info( $file );
				$f_type = filetype( $file );

				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$f_type = finfo_file($finfo, $file);
			
		?>
			<a href="{{ base_url($resources_policies_attachments) }}" target="_blank" class="text-success">{{$resources_policies_title}}</a>
		<?php
			} else {
		?>
			<span class="text-success">{{$resources_policies_title}}</span>
		<?php
			}
		?>
		<br />
		<span class="help-block small">
			<?php echo date("Y-m-d",strtotime($resources_policies_created_on)); ?>
		</span>
	</td>
	<td>
		<span class="text-muted">{{$resources_policies_description}}</span>
	</td>
    <!-- td class="hidden-xs">< ?php echo date("M-d",strtotime($resources_policies_created_on)); ?> 
		<span class="text-muted small">< ?php echo date("D",strtotime($resources_policies_created_on)); ?></span><br>
        <span class="text-muted small">< ?php echo date("Y",strtotime($resources_policies_created_on)); ?></span>
    </td -->
	<td>
			<?php 
				$file = FCPATH . urldecode( $resources_policies_attachments);
				if( file_exists( $file ) )
				{
					$f_info = get_file_info( $file );
					$f_type = filetype( $file );

					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$f_type = finfo_file($finfo, $file);
				
			?>
			<a href="{{ base_url($resources_policies_attachments) }}" target="_blank" class="btn btn-xs text-muted">
				<span class="padding-right-5">
				    <i class="fa fa-search"></i>
				</span> 
				View
			</a>
			<?php
				} else {
			?>
			<span class="help-block small">No attachment found.</span>
			<?php
				} 
			?>

		<!-- <div class="btn-group">
			<a class="btn btn-xs text-muted" href="javascript: ajax_export({{$record_id}})"><i class="fa fa-search"></i> View</a>
		</div>
		<div class="btn-group">
			<a class="btn btn-xs text-muted" href="{{$export_url}}"><i class="fa fa-print"></i> Export</a>
		</div> -->
	</td>
</tr>