<?php 
foreach($movement_details as $index => $movement_detail){
	?>
	<tr class="record">
		<td>
			<a id="type" href="#" class="text-success">
				<?php echo $movement_detail['type']; ?>	
			</a>
			<br />
			<span id="date_set" class="small">
				<?php echo $movement_detail['display_name']; ?>	
			</span>
		</td>
		<td class="hidden-xs">
			<?php echo ($movement_detail['effectivity_date'] && $movement_detail['effectivity_date'] != '0000-00-00' && $movement_detail['effectivity_date'] != 'November 30, -0001' && $movement_detail['effectivity_date'] != '1970-01-01') ? date('F d, Y', strtotime($movement_detail['effectivity_date'])) : '' ?>	
		</td>
		<td class="hidden-xs">
			<?php echo $movement_detail['action_remarks']; ?>	
		</td>
<!-- 		<td class="hidden-xs">
            <?php
            	if( !empty($movement_detail['photo']) ) {
					$file = FCPATH . urldecode( $movement_detail['photo'] );
					if( file_exists( $file ) )
					{	
						$f_type = '';

						if (function_exists('get_file_info')) {
							$f_info = get_file_info( $file );
							$f_type = filetype( $file );
						}

						if (function_exists('finfo_open')) {
							$finfo = finfo_open(FILEINFO_MIME_TYPE);
							$f_type = finfo_file($finfo, $file);
						}

						switch( $f_type )
						{
							case 'image/jpeg':
								$icon = 'fa-picture-o';
								break;
							case 'video/mp4':
								$icon = 'fa-film';
								break;
							case 'audio/mpeg':
								$icon = 'fa-volume-up';
								break;
							default:
								$icon = 'fa-file-text-o';
						}
						
						$filepath = base_url()."partners/admin/movement/download_file/".$movement_detail['movement_id'];
						echo '<li class="padding-3 fileupload-delete-'.$movement_detail['movement_id'].'" style="list-style:none;">
				            <a href="'.$filepath.'">
				            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
				            <span>'. basename($f_info['name']) .'</span>
				            <span class="padding-left-10"></span>
				        </a></li>';	
					}
				}
			?>									
		</td>	 -->		
		<td>
			<div class="btn-group">
				<input type="hidden" id="action_id" name="action_id" value="<?=$movement_detail['action_id']?>" />
				<a  href="javascript:edit_movement_details(<?=$movement_detail['type_id']?>, <?=$movement_detail['action_id']?>);" class="btn btn-xs text-muted"  ><i class="fa fa-pencil"></i> Edit</a>
			</div>
			<div class="btn-group">
				<a href="javascript:delete_movement_type(<?=$movement_detail['action_id']?>)" class="btn btn-xs text-muted"><i class="fa fa-trash-o"></i> Delete</a>
			</div>
		</td>
	</tr>
<?php } ?>