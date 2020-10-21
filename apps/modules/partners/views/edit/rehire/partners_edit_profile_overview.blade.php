<div class="row" id="profile_overview">
	<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
		<ul class="ver-inline-menu tabbable">
			<li class="active">
				<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-tags"></i>{{ lang('partners.gen') }}</a>
				<span class="after"></span>
			</li>
			<li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-gear"></i>{{ lang('partners.employment') }}</a></li>
			<li><a data-toggle="tab" href="#overview_tab3"><i class="fa fa-phone"></i>{{ lang('partners.contacts') }}</a></li>
			<li><a data-toggle="tab" href="#overview_tab15"><i class="fa fa-list"></i>{{ lang('partners.id_nos') }}</a></li>
			<li><a data-toggle="tab" href="#overview_tab4"><i class="fa fa-user"></i>{{ lang('partners.personal') }}</a></li>
			<li><a data-toggle="tab" href="#overview_tab14"><i class="fa fa-group"></i>{{ lang('partners.family') }}</a></li>
		</ul>
	</div>
	<div class="tab-content col-lg-9 col-md-8" >
		<div class="tab-pane active" id="overview_tab1">
			<!-- General Information -->
			@include('edit/custom_fgs/general')
		</div>

		<div class="tab-pane" id="overview_tab2">
        <form class="form-horizontal" id="form-2" partner_id="2" method="POST">
			<!-- Company Information -->
			@include('edit/rehire/company')
			<!-- Employment Information -->
			@include('edit/rehire/employment')
			<!-- Work Assignment Information -->
			@include('edit/custom_fgs/work_assignment')
		</form>
		</div>
		<div class="tab-pane" id="overview_tab3">
        <form class="form-horizontal" id="form-3" partner_id="3" method="POST">
			<!-- Personal Contact Information -->
			@include('edit/custom_fgs/personal_contact')
			<!-- Emergency Contact Information -->
			@include('edit/custom_fgs/emergency_contact')
		</form>
		</div>
		<div class="tab-pane" id="overview_tab4">
        <form class="form-horizontal" id="form-4" partner_id="4" method="POST">
			<!-- Personal Information -->
			@include('edit/custom_fgs/personal_info')
			<!-- Other Personal Information -->
			@include('edit/custom_fgs/other_info')
		</form>
		</div>
		<div class="tab-pane" id="overview_tab15">
        <form class="form-horizontal" id="form-15" partner_id="15" method="POST">
			<!-- IDs -->
			@include('edit/custom_fgs/id_numbers')
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