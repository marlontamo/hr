
<?php 
foreach($attachment_tab as $index => $attachment){ 
	?>
	<tr class="record">
		<!-- this first column shows the year of this holiday item -->
		<td><input type="checkbox" class="checkboxes record-checker" value="<?=$index?>" /></td>
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
			<?php echo array_key_exists('attachment-file', $attachment) ? urldecode(substr( $attachment['attachment-file'], strrpos( $attachment['attachment-file'], '/' )+1 )) : ""; ?>	
		</td>
		<td>
			<div class="btn-group">
				<input type="hidden" id="attachment_sequence" name="attachment_sequence" value="<?=$index?>" />
				<a  href="javascript:edit_personal_details('attach_form_edit_modal', 'attachment', <?=$index?>);" class="btn btn-xs text-muted" ><i class="fa fa-pencil"></i> Edit</a>		
			</div>
			<div class="btn-group">
				<a href="javascript:delete_record(<?=$index?>, 'attachment')" class="btn btn-xs text-muted"><i class="fa fa-trash-o"></i> Delete</a>
			</div>
		</td>
	</tr>
	<?php } ?>