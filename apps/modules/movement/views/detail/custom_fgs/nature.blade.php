<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?php echo $type; ?> <small class="text-muted">detail</small></h4>
</div>
<form class="form-horizontal" id="form_action" method="POST">
    <div class="modal-body padding-bottom-0">	
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="action_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                        <div class="form-horizontal">
                            <div class="form-body move_action_modal">
								<div class="form-group">
									<label class="col-md-4 text-muted text-right">
										Employee:
									</label>
									<div class="col-md-7">
										<?php echo $record['partners_movement_action.display_name'] ?>
									</div>	
								</div>	    
								<div class="form-group">
									<label class="col-md-4 text-muted text-right">
										Effective:
									</label>
									<div class="col-md-7">
										<?php echo ($record['partners_movement_action.effectivity_date'] && $record['partners_movement_action.effectivity_date'] != '0000-00-00' && $record['partners_movement_action.effectivity_date'] != 'January 01, 1970' && $record['partners_movement_action.effectivity_date'] != '1970-01-01' && $record['partners_movement_action.effectivity_date'] != 'November 30, -0001') ? $record['partners_movement_action.effectivity_date'] : ''?>
									</div>	
								</div>	 
								<div class="form-group">
									<label class="col-md-4 text-muted text-right">
										Reason:
									</label>
									<div class="col-md-7">
										<?php echo $record['partners_movement_action.remarks_print_report'] ?>
									</div>	
								</div>	
								<div class="form-group">
									<label class="col-md-4 text-muted text-right">
										Photo:
									</label>
									<div class="col-md-7">
										<?php
											if (!empty($record['attachement'])){
												foreach ($record['attachement'] as $key => $value) {
													if ( !empty($value->photo)) {
														$file = FCPATH . urldecode( $value->photo );
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
															
															$filepath = base_url()."partners/admin/movement/download_file/".$value->movement_attachment_id;
															echo '<li class="padding-3 fileupload-delete-'.$value->movement_attachment_id.'" style="list-style:none;">
													            <a href="'.$filepath.'">
													            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
													            <span>'. basename($f_info['name']) .'</span>
													            <span class="padding-left-10"></span>
													        </a></li>';	
														}
													}
												}
											} 
										?>
									</div>	
								</div>									
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>