<div class="row" id="profile_overview">
	<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
		<ul class="ver-inline-menu tabbable">
			<li class="active personalTab">
				<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-tags"></i>{{ lang('applicants.gen') }}</a>
				<span class="after"></span>
			</li>
			<!-- <li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-gear"></i>Application</a></li> -->
			<li class="personalTab recruitTab2" ><a @if (!empty($record['record_id'])) data-toggle="tab" href="#overview_tab3" @endif id="recruitTab2"><i class="fa fa-phone"></i>{{ lang('applicants.contacts') }}</a></li>
			<li class="personalTab recruitTab4" ><a @if (!empty($record['record_id'])) data-toggle="tab" href="#overview_tab5" @endif id="recruitTab4"><i class="fa fa-user"></i>{{ lang('applicants.personal') }}</a></li>
			<li class="personalTab famTab" ><a @if (!empty($record['record_id'])) data-toggle="tab" href="#overview_tab14" @endif class="historicalFam"><i class="fa fa-group"></i>{{ lang('applicants.family') }}</a></li>
		</ul>
	</div>
	<div class="tab-content col-lg-9 col-md-8" >
		<div class="tab-pane active personalPane" id="overview_tab1">
	        <form class="form-horizontal" id="form-1" partner_id="1" method="POST">
				<!-- General Information -->
				@include('edit/custom_fgs/general')
	        	<!-- Application Information -->
				@include('edit/custom_fgs/employment')
			</form>
		</div>

		<!-- <div class="tab-pane" id="overview_tab2">
	        <form class="form-horizontal" id="form-2" partner_id="2" method="POST">
			</form>
		</div> -->

		<div class="tab-pane personalPane" id="overview_tab3">
        <form class="form-horizontal" id="form-3" partner_id="3" method="POST">
			<!-- Personal Contact Information -->
			@include('edit/custom_fgs/personal_contact')
			<!-- Emergency Contact Information -->
			@include('edit/custom_fgs/emergency_contact')
		</form>
		</div>
		<div class="tab-pane personalPane" id="overview_tab5">
        <form class="form-horizontal" id="form-4" partner_id="4" method="POST">
			<!-- Personal Information -->
			@include('edit/custom_fgs/personal_info')
			<!-- Other Personal Information -->
			@include('edit/custom_fgs/other_info')
			@include('edit/custom_fgs/other_question')
		</form>
		</div>
		<div class="tab-pane" id="overview_tab14">
        <form class="form-horizontal" id="form-14" partner_id="14" method="POST">
			<!-- Personal Information -->
			@include('edit/custom_fgs/family_info')
		</form>
		</div>
	</div>
</div>