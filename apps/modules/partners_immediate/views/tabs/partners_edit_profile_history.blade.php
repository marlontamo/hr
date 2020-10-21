
	<div class="row">
		<div class="col-md-3" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#historical_tab1"><i class="fa fa-list"></i>{{ lang('partners_immediate.education') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#historical_tab2"><i class="fa fa-list"></i>{{ lang('partners_immediate.employment_history') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab3"><i class="fa fa-list"></i>{{ lang('partners_immediate.character_ref') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab4"><i class="fa fa-list"></i>{{ lang('partners_immediate.licensure') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab5"><i class="fa fa-list"></i>{{ lang('partners_immediate.training') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab6"><i class="fa fa-list"></i>{{ lang('partners_immediate.skills') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab7"><i class="fa fa-list"></i>{{ lang('partners_immediate.affiliation') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab8"><i class="fa fa-list"></i>{{ lang('partners_immediate.accountabilities') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab9"><i class="fa fa-files-o"></i>{{ lang('partners_immediate.attachment') }}</a></li>
			</ul>
		</div>

		<div class="tab-content col-md-9">
			<div class="tab-pane active" id="historical_tab1">
        	<form class="form-horizontal" id="form-5" partner_id="5" method="POST">
				<!-- Education : start doing the loop-->
				@include('edit/custom_fgs/education')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab2">
        	<form class="form-horizontal" id="form-6" partner_id="6" method="POST">
				<!-- Previous Employment : start doing the loop-->				
				@include('edit/custom_fgs/employment_history')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab3">
        	<form class="form-horizontal" id="form-7" partner_id="7" method="POST">
				<!-- Previous Character reference : start doing the loop-->			
				@include('edit/custom_fgs/character_reference')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab4">
        	<form class="form-horizontal" id="form-8" partner_id="8" method="POST">
				<!-- Previous Licensure : start doing the loop-->			
				@include('edit/custom_fgs/licensure')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab5">
        	<form class="form-horizontal" id="form-9" partner_id="9" method="POST">
				<!-- Previous Trainings : start doing the loop-->
				@include('edit/custom_fgs/training')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab6">
        	<form class="form-horizontal" id="form-10" partner_id="10" method="POST">
				<!-- Previous Trainings : start doing the loop-->
				@include('edit/custom_fgs/skills')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab7">
        	<form class="form-horizontal" id="form-11" partner_id="11" method="POST">
				<!-- Previous Trainings : start doing the loop-->
				@include('edit/custom_fgs/affiliation')
			</form>
			</div>
			<div class="tab-pane" id="historical_tab8">
				@include('edit/custom_fgs/accountabilities')
			</div>

			<div class="tab-pane" id="historical_tab9">
        	<form class="form-horizontal" id="form-13" partner_id="13" method="POST">
				<!--Attachments--> 
				@include('edit/custom_fgs/attachments')
			</form>
			</div>

		</div>
	</div>
