	<div class="row" id="profile_overview">
		<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#overview_tab1"><i class="fa fa-gear"></i>{{ lang('my201.employment') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#overview_tab2"><i class="fa fa-phone"></i>{{ lang('my201.contacts') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab15"><i class="fa fa-user"></i>{{ lang('my201.id_no') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab3"><i class="fa fa-user"></i>{{ lang('my201.personal') }}</a></li>
				<li><a data-toggle="tab" href="#overview_tab14"><i class="fa fa-group"></i>{{ lang('my201.family') }}</a></li
			</ul>
		</div>
		<div class="tab-content col-lg-9 col-md-8" >
			<div class="tab-pane active" id="overview_tab1">			
					@include('tabs/edit_my201/employment')
			</div>

			<div class="tab-pane" id="overview_tab2">
				<form class="form-horizontal" id="form-3" partner_id="3" method="POST">
					@include('tabs/edit_my201/contacts')
				</form>
			</div>

			<div class="tab-pane" id="overview_tab15">
				<form class="form-horizontal" id="form-15" partner_id="15" method="POST">
					<!-- ID Numbers -->
					@include('tabs/edit_my201/id_number')
				</form>
			</div>
			<div class="tab-pane" id="overview_tab3">
				<form class="form-horizontal" id="form-4" partner_id="4" method="POST">
					@include('tabs/edit_my201/personal')
				</form>
			</div>
			<div class="tab-pane" id="overview_tab14">
				<form class="form-horizontal" id="form-14" partner_id="14" method="POST">
					@include('tabs/edit_my201/family')
				</form>
			</div>

		</div>
	</div>
