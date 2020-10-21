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
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Memo Title</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="memo[memo_title]" id="memo-memo_title" value="{{ $record['memo.memo_title'] }}" placeholder="Enter Memo Title" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Publish From</label>
				<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" class="form-control" name="memo[publish_from]" id="memo-publish_from" value="{{ $record['memo.publish_from'] }}" placeholder="Enter Publish From" readonly>
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Publish To</label>
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
			</div>	</div>
</div>