<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Memo Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Basic memorandum information</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Memo Type</label>
				<div class="col-md-7"><?php									                            		$db->select('memo_type_id,memo_type');
	                            			                            		$db->order_by('memo_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('memo_type'); 	                            $memo_memo_type_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$memo_memo_type_id_options[$option->memo_type_id] = $option->memo_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('memo[memo_type_id]',$memo_memo_type_id_options, $record['memo.memo_type_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Recipient</label>
				<div class="col-md-7"><?php									                            		$db->select('apply_to_id,apply_to');
	                            			                            		$db->order_by('apply_to', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('memo_apply_to'); 	                            $memo_apply_to_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$memo_apply_to_id_options[$option->apply_to_id] = $option->apply_to;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('memo[apply_to_id]',$memo_apply_to_id_options, $record['memo.apply_to_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                        </div> 				</div>	
			</div>

			<div class="form-group">
				<label class="control-label col-md-3"></label>
				<div class="col-md-7">
				<div class="help-block text-muted small">
					<!-- <span class="required"> -->
					Use Company to select all employees which will be the recipient of this memo
					<!-- </span> -->
				</div>
					<?php
						$options = "";
						if( !empty( $record_id ) )
						{
							$options = $mod->_get_applied_to_options( $record_id, true );
						}
					?>
                    <div class="input-group">
						<span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                        </span>
                        <select name="memo[applied_to][]" id="memo-applied_to" class="select2me form-control" multiple>
                        	{{ $options }}
                        </select>
                    </div>
                </div>	
			</div>



			<div class="form-group">
				<label class="control-label col-md-3">Memo Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="memo[memo_title]" id="memo-memo_title" value="{{ $record['memo.memo_title'] }}" placeholder="Enter Memo Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Publish From</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="memo[publish_from]" id="memo-publish_from" value="{{ $record['memo.publish_from'] }}" placeholder="Enter Publish From" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Publish To</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="memo[publish_to]" id="memo-publish_to" value="{{ $record['memo.publish_to'] }}" placeholder="Enter Publish To" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Publish</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['memo.publish'] ) checked="checked" @endif name="memo[publish][temp]" id="memo-publish-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="memo[publish]" id="memo-publish" value="@if( $record['memo.publish'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Allow Comments</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['memo.comments'] ) checked="checked" @endif name="memo[comments][temp]" id="memo-comments-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="memo[comments]" id="memo-comments" value="@if( $record['memo.comments'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">Email Recipients</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['memo.email'] ) checked="checked" @endif name="memo[email][temp]" id="memo-email-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="memo[email]" id="memo-email" value="@if( $record['memo.email'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>
			@if(!empty($record_id))
			<div class="form-group">
				<label class="control-label col-md-3">Resend Email</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" name="reemail[temp]" id="reemail-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="reemail" id="reemail" value="0"/>
							</div> 				</div>	
			</div>
			@endif
				</div>
</div><div class="portlet">
	<div class="portlet-title">
		<div class="caption">Memorandum Detail</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Enter memorandum details</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3">Memo Body</label>
				<div class="col-md-9">	
					<div class="help-block text-muted small">Kindly use the text editor below in formatting the content of your memo.</div>
						<textarea class="wysihtml5 form-control" name="memo[memo_body]" id="memo-memo_body" placeholder="Enter Memo Body" rows="6">{{ $record['memo.memo_body'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Attachment</label>
				<div class="col-md-7">							<div data-provides="fileupload" class="fileupload fileupload-new" id="memo-attachment-container">
								@if( !empty($record['memo.attachment']) )
									<?php 
										$file = FCPATH . urldecode( $record['memo.attachment'] );
										if( file_exists( $file ) )
										{
											$f_info = get_file_info( $file );
										}
									?>								@endif
								<input type="hidden" name="memo[attachment]" id="memo-attachment" value="{{ $record['memo.attachment'] }}"/>
								<div class="input-group">
									<span class="input-group-btn">
										<span class="uneditable-input">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview">@if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif</span>
										</span>
									</span>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" accept="application/pdf, image/*" id="memo-attachment-fileupload" type="file" name="files[]">
									</span>
									<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
									
								</div>
								<div class="help-block text-muted small">Allow only image and pdf files.</div>
							</div> 				</div>	
			</div>	</div>
</div>