<?php
$social = unserialize($public_profile_details['social']);
if(is_array($social)){
	foreach($social as $index => $value){
?>
<tr rel="0">
	<!-- this first column shows the year of this holiday item -->
	<td>
		<span class="text-info"><?php echo $index;?></span>
		<input type="hidden" class="form-control" maxlength="64" value="<?php echo $index;?>" name="users_profile_public[social][]" id="users_profile_public-social">
	</td>
	<td>
		<input value="<?php echo $value ?>" type="text" class="form-control" maxlength="64" id="maxlength_defaultconfig" placeholder="" name="users_profile_public[social_account][]" id="users_profile_public-social_account">
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
	</td>
</tr>
<?php
	}
}
?>