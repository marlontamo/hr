<?php
$language_spoken = unserialize($public_profile_details['language_spoken']);
if(is_array($language_spoken)){
	foreach($language_spoken as $index => $value){
?>
		<tr>
			<td>
				<input type="text" class="form-control" maxlength="64" value="<?php echo $index;?>" name="users_profile_public[language_spoken][]" id="users_profile_public-language_spoken">
			</td>
			<td>
				<select  class="form-control select2me input-sm" data-placeholder="Select..." name="users_profile_public[language_spoken_proficiency][]" id="users_profile_public-language_spoken_proficiency">
					<option value="1" <?php if($value == 1) echo "selected" ?> >Elementary Proficiency</option>
					<option value="2" <?php if($value == 2) echo "selected" ?>>Limited Working Proficiency</option>
					<option value="3" <?php if($value == 3) echo "selected" ?>>Professional Working Proficiency</option>
					<option value="4" <?php if($value == 4) echo "selected" ?>>Full Professional Proficiency</option>
					<option value="5" <?php if($value == 5) echo "selected" ?>>Native or Bilingual Proficiency</option>
				</select>
			</td>
			<td>
				<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
			</td>
		</tr>
<?php
	}
}
?>

<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
    });
</script>