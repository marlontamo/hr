
	<div class="row">
		<div class="col-lg-9 col-md-8">
			<div class="margin-top-25">
				<!-- Summary -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><span class="circle b-green margin-right-10"><i class="fa fa-list"></i></span> Summary </div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="info-text">
									<p style="white-space:pre-wrap;">{{$public_profile_details['summary']}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Interest -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><span class="circle l-pink margin-right-10"><i class="fa fa-heart"></i></span> Interest</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">
								<div class="info-text">
								@if(is_array($public_profile_details['interest']))
									@foreach($public_profile_details['interest'] as $index => $value)
									<span class="btn default green-stripe interest-tags">{{$value}}</span>
									@endforeach
								@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Language -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><span class="circle b-blue margin-right-10"><i class="fa fa-globe"></i></span> Language</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">

								<div class="padding-left-50">
									<ul class="list-unstyled list-inline language-list">
										@if(is_array($public_profile_details['language_spoken']))
											@foreach($public_profile_details['language_spoken'] as $index => $value)
											<li>
												<h3 class="margin-bottom-0">{{$index}}</h3>
												<span class="text-muted small">
												@if($value == 1)
													{{"Elementary Proficiency"}}
												@elseif($value == 2)
													{{"Limited Working Proficiency"}}
												@elseif($value == 3)
													{{"Professional Working Proficiency"}}
												@elseif($value == 4)
													{{"Full Professional Proficiency"}}
												@elseif($value == 5)
													{{"Native or Bilingual Proficiency"}}
												@endif</span>
												<ul class="star-list list-inline">
													@for($count=5; $value>0 ;$value--, $count--)
													<li class="rate-stars"><i class="fa fa-star"></i></li>
													@endfor
													@for($counter=0; $count>$counter ;$count--)
													<li class="rate-stars"><i class="fa fa-star-o"></i></li>
													@endfor
												</ul>
											</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Social Networks -->
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption"><span class="circle yellow margin-right-10"><i class="fa fa-star"></i></span> Social Networks</div>
						<div class="tools">
							<a class="collapse" href="javascript:;"></a>
						</div>
					</div>
					<div class="portlet-body form">
						<!-- START FORM -->
						<div class="row">
							<div class="col-md-12">

								<div class="padding-left-50">
									<ul class="list-unstyled social-list">
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
											<li>
												<div class="social-bullet"><a target="_blank" class="social-icon social-icon-color {{$social_class}}" href="{{$social_url}}{{$value}}"></a></div>
												<div class="social-text">: <a target="_blank" href="{{$social_url}}{{$value}}">{{$social_url}}{{$value}}</a></div>
											</li>
											@endforeach
										@endif
									</ul>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
