<tr>
	<td>
		<input type="text" class="form-control" maxlength="64" value="<?php echo $form_value;?>" name="users_profile_public[language_spoken][]" id="users_profile_public-language_spoken">
	</td>
	<td>
		<select  class="form-control select2me input-sm" data-placeholder="Select..." name="users_profile_public[language_spoken_proficiency][]" id="users_profile_public-language_spoken_proficiency">
			<option value="1">Elementary Proficiency</option>
			<option value="2">Limited Working Proficiency</option>
			<option value="3">Professional Working Proficiency</option>
			<option value="4">Full Professional Proficiency</option>
			<option value="5">Native or Bilingual Proficiency</option>
		</select>
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
	</td>
</tr>

<script language="javascript">
    $(document).ready(function(){
        $('select.select2me').select2();
    });
</script>