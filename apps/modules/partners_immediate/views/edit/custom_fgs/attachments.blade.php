<div class="portlet">
	<div class="portlet-title">
		<div class="caption" >{{ lang('partners_immediate.attachment') }}</div>
		<div class="actions">
			<a class="btn btn-default" data-toggle="modal" href="#actb-add">
                <i class="fa fa-plus"></i>
            </a>
            <a class="btn btn-default" href="#">
            	<i class="fa fa-times"></i>
            </a>
		</div>
	</div>
	<div class="portlet-body form">
	    <div class="form-horizontal">
	        <div class="form-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<th width="1%"><input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" /></th>
							<th width="30%">{{ lang('partners_immediate.name') }}</th>
							<th width="45%" class="hidden-xs">{{ lang('partners_immediate.filename') }}</th>
							<th width="20%">{{ lang('common.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							foreach($attachment_tab as $index => $attachment){ 
						?>
						<tr rel="0">
							<!-- this first column shows the year of this holiday item -->
							<td><input type="checkbox" class="checkboxes" value="1" /></td>
							<td>
								<a id="date_name" href="#" class="text-success">
											<?php echo array_key_exists('attachment-name', $attachment) ? $attachment['attachment-name'] : ""; ?>	
										</a>
								<br />
								<span id="date_set" class="small">
									<?php echo array_key_exists('attachment-category', $attachment) ? $attachment['attachment-category'] : ""; ?>	
								</span>
							</td>
							<td class="hidden-xs">
											<?php echo array_key_exists('attachment-file', $attachment) ? substr( $attachment['attachment-file'], strrpos( $attachment['attachment-file'], '/' )+1 ) : ""; ?>	
							</td>
							<td>
								<div class="btn-group">
											<input type="hidden" id="attachment_sequence" name="attachment_sequence" value="<?=$index?>" />
											<a  href="javascript:edit_personal_details('attach_form_edit_modal', 'attachment', <?=$index?>);" class="btn btn-xs text-muted" ><i class="fa fa-pencil"></i> {{ lang('common.edit') }}</a>		
								</div>
								<div class="btn-group">									
									<a class="btn btn-xs text-muted" href="#" data-close-others="true" data-hover="dropdown" data-toggle="dropdown-toggle"><i class="fa fa-gear"></i> {{ lang('common.options') }}</a>
									<ul class="dropdown-menu pull-right">
                                		<li><a href="#"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a></li>
                                		<li><a href="#"><i class="fa fa-ban"></i> {{ lang('partners_immediate.disable') }}</a></li>
                            		</ul>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>