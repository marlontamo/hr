<div class="col-md-12">
	<div class="portlet">
		<div class="portlet-body">
			<div class="row">
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active"><a href="{{ $mod->url }}/discussion/{{ $current_group->group_id }}">Discussion</a></li>
						<li class=""><a href="{{ $mod->url }}/members/{{ $current_group->group_id }}">Members</a></li>
						<li class=""><a href="{{ $mod->url }}/files/{{ $current_group->group_id }}">Files</a></li>
						<li class=""><a href="{{ $mod->url }}/photos/{{ $current_group->group_id }}">Photo</a></li>
					</ul>
					<div class="tab-content">
						<form name="add-post">
							<!--<input type="hidden" value="{{ $current_group->group_id }}" class="filter" name="group_id">
							<div class="chat-form">
								<div class="input-cont">   
									<input type="text" name="post" placeholder="Type a message here..." class="form-control">
								</div>
								<div class="btn-cont"> 
									<span class="arrow"></span>
									<button class="btn blue icn-only"><i class="fa fa-comments icon-white"></i></button>
								</div>
							</div>-->
							<input type="hidden" value="{{ $current_group->group_id }}" class="filter" name="group_id">
							<div class="share">
								<div class="arrow"></div>
								<div class="panel panel-default">
									<div class="panel-heading"><i class="fa fa-pencil"></i> Write Post</div>
									<div class="panel-body">
										<div class="">
											<textarea name="post" cols="40" rows="10" id="status_message" class="form-control" style="height: 62px; overflow: hidden;" placeholder="What's on your mind ?"></textarea> 
										</div>
									</div>
									<div class="panel-footer">
										<div class="row">
											<div class="col-md-7">
												<div data-provides="fileupload" class="fileupload fileupload-new" id="discussion_upload-upload_id-container">
													<input type="hidden" name="discussion_upload[upload_id]" id="discussion_upload-upload_id" />
													<span class="btn btn-success btn-sm btn-file">
														<span class="fileupload-new"><i class="fa fa-paper-clip"></i> 
														<i class="fa fa-plus" type="file"></i>
														<span>Add Files...</span>
														</span>
														<input type="file" id="discussion_upload-upload_id-fileupload" type="file" name="files[]" multiple="">
													</span>
													<ul class="padding-none margin-top-10">
													@if( !empty($record['discussion_upload.upload_id']) )
													<?php 
													$upload_ids = explode( ',', $record['discussion_upload.upload_id'] );
													foreach( $upload_ids as $upload_id )
													{
														$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id))->row();
														$file = FCPATH . urldecode( $upload->upload_path );

														if( file_exists( $file ) )
														{
															$f_info = get_file_info( $file );
															$f_type = filetype( $file );

															$finfo = finfo_open(FILEINFO_MIME_TYPE);
															$f_type = finfo_file($finfo, $file);

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
															echo '<li class="padding-3 fileupload-delete-'.$upload_id.'" style="list-style:none;">
															<span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															<span>'. basename($f_info['name']) .'</span>
															<span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id.'" href="javascript:void(0)"></a></span>
															</li>';
														}
													}
													?>                              @endif
													</ul>
												</div>  
											</div>
											<div class="col-md-5">
												<button class="btn btn-primary pull-right">Post</button>  
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
						<br/>
						<div class="clearfix margin-bottom-25"><h4>Recent Activity</h4></div>
						<ul class="feeds-list"></li>
						<div id="no_record" class="well" style="display:none;">
							<p class="bold"><i class="fa fa-exclamation-triangle"></i> {{ lang('common.no_record_found') }}</p>
							<span><p class="small margin-bottom-0">{{ lang('common.zero_record') }}</p></span>
						</div>
						<div id="loader" class="text-center"><img src="{{ theme_path() }}img/ajax-loading.gif" alt="loading..." /> {{ lang('common.get_record') }}</div>	
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>