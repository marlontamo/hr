<li class="in2">
	<img class="avatar img-responsive" alt="" src="{{ base_url( $profile_photo ) }}" style="border-radius:5% !important" />
	<div class="message2">
		<span class="emp_name">
			{{$profile_name}}
		</span>
		<br>
		<span class="text-muted emp_position">{{$profile_position}}</span>
		<br>
		<span class="text-success emp_company">at {{$profile_company}}</span>
	</div>
</li>
<li class="in2 margin-top-10">
	<div class="profile-block">
		<span class="profile-title">
			Birthday
		</span>
		<br>
		<span class="profile-info">
			{{$profile_birthdate}}
		</span>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<span class="profile-title">
			Status
		</span>
		<br>
		<span class="profile-info">
			{{$profile_civil_status}}
		</span>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<span class="profile-title">
			Email
		</span>
		<br>
		<span class="profile-info">
			{{$profile_email}}
		</span>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<span class="profile-title">
			Phone
		</span>
		<br>
		<span class="profile-info">
			@foreach( $profile_telephones as $telephone )
				{{ $telephone }}
			@endforeach
		</span>
	</div>
</li>

@if(in_array('address_1', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<span class="profile-title">
			Address
		</span>
		<br>
		<span class="profile-info">
			{{$complete_address}}
		</span>
	</div>
</li>
@endif
@if(in_array('city_town', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<span class="profile-title">
			Address
		</span>
		<br>
		<span class="profile-info">
			{{$profile_live_in}}
		</span>
	</div>
</li>
@endif
<li class="in2 margin-top-10">
	<span class="profile-main">
		EMPLOYMENT
	</span>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Position
		</div>
		<div class="profile-info">
			{{$profile_position}}
		</div>

	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			ID Number
		</div>
		<div class="profile-info">
			{{$id_number}}
		</div>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Work Schedule
		</div>
		<div class="profile-info">
			{{$shift}}
		</div>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Status
		</div>
		<div class="profile-info">
			{{$status}}
		</div>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Type
		</div>
		<div class="profile-info">
			{{$type}}
		</div>
	</div>
</li>
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Date Hired
		</div>
		<div class="profile-info">
			{{$date_hired}}
		</span>
	</div>
</li>

<li class="in2 margin-top-10">
	<span class="profile-main">
		ID Numbers
	</span>
</li>
@if(in_array('sss_number', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			SSS Number
		</div>
		<div class="profile-info">
			{{$record['sss_number']}}
		</div>
	</div>
</li>
@endif
@if(in_array('pagibig_number', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Pag-Ibig Number
		</div>
		<div class="profile-info">
			{{$record['pagibig_number']}}
		</div>
	</div>
</li>
@endif
@if(in_array('philhealth_number', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Philhealth
		</div>
		<div class="profile-info">
			{{$record['philhealth_number']}}
		</div>
	</div>
</li>
@endif
@if(in_array('tin_number', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			TIN Number
		</div>
		<div class="profile-info">
			{{$record['tin_number']}}
		</div>
	</div>
</li>
@endif 
@if(in_array('bank_account_number', $partners_keys))
<li class="in2">
	<div class="profile-block">
		<div class="profile-title">
			Bank Account
		</div>
		<div class="profile-info">
			{{$record['bank_number']}}
		</div>
	</div>
</li>
@endif

<li class="in2 margin-top-10">
	<span class="profile-main">
		EDUCATION
	</span>
</li>
@foreach($education_tab as $index => $education)
	<li class="in2">
		<div class="profile-block">
			<div class="profile-title">
				Attainment
			</div>
			<div class="profile-info">
				<?php echo array_key_exists('education-type', $education) ? $education['education-type'] : ""; ?>
			</div>
		</div>
	</li>
	<li class="in2">
		<div class="profile-block">
			<div class="profile-title">
				Course
			</div>
			<div class="profile-info">
				<?php echo array_key_exists('education-degree', $education) ? $education['education-degree'] : ""; ?>
			</div>
		</div>
	</li>
	<li class="in2">
		<div class="profile-block">
			<div class="profile-title">
				School
			</div>
			<div class="profile-info">
				<?php echo array_key_exists('education-school', $education) ? $education['education-school'] : ""; ?>
			</div>
		</div>
	</li>
	<li class="in2 endlist">
		<div class="profile-block">
			<div class="profile-title">
				Year
			</div>
			<div class="profile-info">
				<?php echo array_key_exists('education-year-from', $education) ? $education['education-year-from'] : ""; ?>-<?php echo array_key_exists('education-year-to', $education) ? $education['education-year-to'] : ""; ?>
			</div>
		</div>
	</li>
@endforeach

