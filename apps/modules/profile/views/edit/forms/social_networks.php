<?php
if(strtolower($form_value) == 'facebook'){
	$social_class = "facebook"; 
		$social_url = "https://www.facebook.com/";
}
elseif(strtolower($form_value) == 'twitter'){
	$social_class = "twitter"; 
		$social_url = "https://twitter.com/";
}
elseif(strtolower($form_value) == 'pinterest'){
	$social_class = "pintrest"; 
		$social_url = "http://www.pinterest.com/";
}
elseif(strtolower($form_value) == 'linkedin'){
	$social_class = "linkedin"; 
		$social_url = "https://www.linkedin.com/in/";
}
elseif(strtolower($form_value) == 'instagram'){
	$social_class = "instagram"; 
		$social_url = "http://instagram.com/";
}

?>
<tr rel="0">
	<!-- this first column shows the year of this holiday item -->
	<td>
		<span class="text-info"><?php echo $social_url;?></span>
		<div class="social-bullet" >
			<a target="_blank" class="social-icon social-icon-color <?php echo $social_class ?>" href="<?php echo $social_url?>">
			</a>
		</div>
		<input type="hidden" class="form-control" maxlength="64" value="<?php echo $form_value;?>" name="users_profile_public[social][]" id="users_profile_public-social">
	</td>
	<td>
		<input type="text" class="form-control" maxlength="64" id="maxlength_defaultconfig" placeholder="" name="users_profile_public[social_account][]" id="users_profile_public-social_account">
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
	</td>
</tr>