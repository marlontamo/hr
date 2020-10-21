
<div class="row">
	<div class="col-lg-9 col-md-8">
		<div class="margin-top-25">
			<!-- Summary -->
			<form>
				<input type="hidden" value="{{$user_id}}" name="record_id">
				<input type="hidden" value="summary" name="section">
				<div class="portlet margin-bottom-25">
					<div class="portlet-title">
						<div class="caption"><span class="circle b-green margin-right-10"><i class="fa fa-list"></i></span> Summary </div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<p class="small margin-bottom-25">Brief description of yourself. Distinguishing yourself from your company.</p>

					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<textarea rows="4" class="form-control" name="users_profile_public[summary]" id="users_profile_public-summary" placeholder="I am passionate about...">{{$public_profile_details['summary']}}</textarea>
							</div>

							<div class="col-md-12 margin-top-10">
								<div class="pull-right">
									<a onclick="save_record( $(this).closest('form'), '')" class="btn btn-success btn-xs" type="button"> Save Changes</a> 
									<a onclick="reset_form('summary', 'users_profile_public', {{$user_id}})" class="btn default btn-xs">Cancel</a>                              
								</div>
							</div>
						</div>

					</div>
				</div>
			</form>

			<!-- Interest -->
			<form>
				<input type="hidden" value="{{$user_id}}" name="record_id">
				<input type="hidden" value="interest" name="section">
				<div class="portlet margin-bottom-25">
					<div class="portlet-title">
						<div class="caption"><span class="circle l-pink margin-right-10"><i class="fa fa-heart"></i></span> Interest</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<p class="small margin-bottom-25">Examples: Investing, management training, skydiving or fishing.</p>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">

							<!-- BEGIN FORM-->
							<div class="form-group">
								<label class="control-label col-md-4">Add Interest</label>
								<div class="col-md-8 interest">
									<input type="text" class="form-control tags" name="users_profile_public[interest]" id="users_profile_public-interest" value="{{$public_profile_details['interest']}}"/>
								</div>
							</div>
							<!-- END FORM-->  

							<div class="col-md-12 margin-top-10">
								<div class="pull-right">
									<a onclick="save_record( $(this).closest('form'), '')" class="btn btn-success btn-xs" type="button"> Save Changes</a> 
									<a onclick="reset_form('interest', 'users_profile_public', {{$user_id}})" class="btn default btn-xs">Cancel</a>                                 
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!-- Language -->
			<form action="#" class="form-horizontal">
				<input type="hidden" value="{{$user_id}}" name="record_id">
				<input type="hidden" value="language" name="section">
				<div class="portlet margin-bottom-25">
					<div class="portlet-title">
						<div class="caption"><span class="circle b-blue margin-right-10"><i class="fa fa-globe"></i></span> Language</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<p class="small margin-bottom-25">Language spoken.</p>

					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="form-body">

							<div class="form-group">
								<label class="control-label col-md-4">Language</label>
								<div class="col-md-5">
									<div class="input-group">
										<input type="text" class="form-control" maxlength="64" id="language" name="language" placeholder="Enter Language..">

										<span class="input-group-btn">
											<button type="button" class="btn btn-success" onclick="add_form('language_spoken', 'language')"><i class="fa fa-plus"></i></button>
										</span>
									</div>
									<div class="help-block small">
										Enter language and set proficiency level.
									</div>
									<!-- /input-group -->
								</div>
							</div>
							<br>
							<div class="portlet margin-top-25">
								<h5 class="form-section margin-bottom-10"><b>{{ lang('profile.languages') }}</b>

								</h5>

								<div class="portlet-body" >
									<!-- Table -->
									<table class="table table-condensed table-striped table-hover" >
										<thead>
											<tr>
												<th width="35%" class="padding-top-bottom-10" >Language</th>
												<th width="55%" class="padding-top-bottom-10" >Proficiency Level</th>
												<th width="15%" class="padding-top-bottom-10" >Actions</th>
											</tr>
										</thead>
										<tbody id="languages" class="language_spoken">
											@if(is_array($public_profile_details['language_spoken']))
												@foreach($public_profile_details['language_spoken'] as $index => $value)
												<tr>
													<td>
														<input type="text" class="form-control" maxlength="64" value="{{$index}}" name="users_profile_public[language_spoken][]" id="users_profile_public-language_spoken">
													</td>
													<td>
														<select  class="form-control select2me input-sm" data-placeholder="Select..." name="users_profile_public[language_spoken_proficiency][]" id="users_profile_public-language_spoken_proficiency">
															<option value="1" @if($value == 1) {{"selected"}} @endif>Elementary Proficiency</option>
															<option value="2" @if($value == 2) {{"selected"}} @endif>Limited Working Proficiency</option>
															<option value="3" @if($value == 3) {{"selected"}} @endif>Professional Working Proficiency</option>
															<option value="4" @if($value == 4) {{"selected"}} @endif>Full Professional Proficiency</option>
															<option value="5" @if($value == 5) {{"selected"}} @endif>Native or Bilingual Proficiency</option>
														</select>
													</td>
													<td>
														<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
													</td>
												</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END FORM-->  

						<div class="col-md-12 margin-top-10">
							<div class="pull-right">
								<a onclick="save_record( $(this).closest('form'), '')" class="btn btn-success btn-xs" type="button"> Save Changes</a> 								
								<a onclick="reset_form('language_spoken', 'users_profile_public', {{$user_id}})" class="btn default btn-xs">Cancel</a>                               
							</div>
						</div>
					</div>
				</div>
			</form>

			<!-- Social Networks -->
			<form action="#" class="form-horizontal">
				<input type="hidden" value="{{$user_id}}" name="record_id">
				<input type="hidden" value="social" name="section">
				<div class="portlet margin-bottom-25">
					<div class="portlet-title">
						<div class="caption"><span class="circle yellow margin-right-10"><i class="fa fa-star"></i></span> Social Networks</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<p class="small margin-bottom-25">With account to any social service platform.</p>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="form-body">

							<div class="form-group">
								<label class="control-label col-md-4">Select</label>
								<div class="col-md-5">
									<div class="input-group">
										<select  class="form-control select2me input-sm" data-placeholder="Select..." name="social" id="social">
											<option value="Facebook">Facebook</option>
											<option value="Twitter">Twitter</option>
											<option value="LinkedIn">LinkedIn</option>
											<option value="Pinterest">Pinterest</option>
											<option value="Instagram">Instagram</option>
										</select>

										<span class="input-group-btn">
											<button type="button" class="btn btn-success" onclick="add_form('social_networks', 'social')"><i class="fa fa-plus"></i></button>
										</span>
									</div>
									<div class="help-block small">
										Select social network and modify.
									</div>
									<!-- /input-group -->
								</div>
							</div>
							<br>
							<div class="portlet margin-top-25">
								<h5 class="form-section margin-bottom-10"><b>List of your Social Networks</b>

								</h5>

								<div class="portlet-body" >
									<!-- Table -->
									<table class="table table-condensed table-striped table-hover" >
										<thead>
											<tr>
												<th width="25%" class="padding-top-bottom-10" >Social Networks</th>
												<th width="65%" class="padding-top-bottom-10" >Details</th>
												<th width="15%" class="padding-top-bottom-10" >Actions</th>
											</tr>
										</thead>
										<tbody id="socials" class="social">
											@if(is_array($public_profile_details['social']))
												@foreach($public_profile_details['social'] as $index => $value)
													@if(strtolower($index) == 'facebook')
														<?php $social_class = "facebook"; 
															$social_url = "https://www.facebook.com/";?>
													@elseif(strtolower($index) == 'twitter')
														<?php $social_class = "twitter"; 
															$social_url = "https://twitter.com/";?>
													@elseif(strtolower($index) == 'pinterest')
														<?php $social_class = "pintrest"; 
															$social_url = "http://www.pinterest.com/";?>
													@elseif(strtolower($index) == 'linkedin')
														<?php $social_class = "linkedin"; 
															$social_url = "https://www.linkedin.com/in/";?>
													@elseif(strtolower($index) == 'instagram')
														<?php $social_class = "instagram"; 
															$social_url = "http://instagram.com/";?>
													@endif
												<tr rel="0">
													<td>
														<!-- <span class="text-info">{{$index}}</span> -->
														<!-- <br> -->
														<span class="text-info">
															{{$social_url}}
														</span>
														<div class="social-bullet" >
															<a target="_blank" class="social-icon social-icon-color {{$social_class}}" href="{{$social_url}}">
															</a>
														</div>
														<input type="hidden" class="form-control" maxlength="64" value="{{$index}}" name="users_profile_public[social][]" id="users_profile_public-social">
													</td>
													<td>
														<input value="{{$value}}" type="text" class="form-control" maxlength="64" id="maxlength_defaultconfig" placeholder="" name="users_profile_public[social_account][]" id="users_profile_public-social_account">
													</td>
													<td>
														<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
													</td>
												</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END FORM-->  

						<div class="col-md-12 margin-top-10">
							<div class="pull-right">
								<a onclick="save_record( $(this).closest('form'), '')" class="btn btn-success btn-xs" type="button"> Save Changes</a> 
								<a onclick="reset_form('social', 'users_profile_public', {{$user_id}})" class="btn default btn-xs">Cancel</a>                                
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>
