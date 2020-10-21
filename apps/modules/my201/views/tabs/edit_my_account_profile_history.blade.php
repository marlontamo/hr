
	<div class="row">
		<div class="col-lg-3 col-md-4" style="margin-bottom:50px">
			<ul class="ver-inline-menu tabbable">
				<li class="active">
					<a data-toggle="tab" href="#historical_tab1"><i class="fa fa-list"></i>{{ lang('my201.education') }}</a>
					<span class="after"></span>
				</li>
				<li><a data-toggle="tab" href="#historical_tab2"><i class="fa fa-list"></i>{{ lang('my201.employment_history') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab3"><i class="fa fa-list"></i>{{ lang('my201.character_ref') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab4"><i class="fa fa-list"></i>{{ lang('my201.licensure') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab5"><i class="fa fa-list"></i>{{ lang('my201.training') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab6"><i class="fa fa-list"></i>{{ lang('my201.skills') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab7"><i class="fa fa-list"></i>{{ lang('my201.affiliation') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab8"><i class="fa fa-list"></i>{{ lang('my201.accountabilities') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab9"><i class="fa fa-files-o"></i>{{ lang('my201.attachments') }}</a></li>
				<li><a data-toggle="tab" href="#historical_tab17"><i class="fa fa-list"></i>Movement</a></li>
			</ul>
		</div>

		<div class="tab-content col-lg-9 col-md-8">
			<div class="tab-pane active" id="historical_tab1">
				<form id="form-5" class="form-horizontal" method="POST" partner_id="5">
					@include('tabs/edit_my201/education')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab2">
				<form id="form-6" class="form-horizontal" method="POST" partner_id="6">
					@include('tabs/edit_my201/employment_history')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab3">
				<!--Character Reference--> 
				<form id="form-7" class="form-horizontal" method="POST" partner_id="7">
					@include('tabs/edit_my201/character_reference')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab4">
				<!--Licensure--> 
				<form id="form-8" class="form-horizontal" method="POST" partner_id="8">
					@include('tabs/edit_my201/licensure')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab5">
				<!--Training & Seminar --> 
				<form id="form-9" class="form-horizontal" method="POST" partner_id="9">
					@include('tabs/edit_my201/training')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab6">
				<!--Skills--> 
				<form id="form-10" class="form-horizontal" method="POST" partner_id="10">
					@include('tabs/edit_my201/skills')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab7">
				<!--Affiliation--> 
				<form id="form-11" class="form-horizontal" method="POST" partner_id="11">
					@include('tabs/edit_my201/affiliation')
				</form>
			</div>
			<div class="tab-pane" id="historical_tab8">
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('my201.accountabilities') }}</div>
                    </div>
                    <div class="portlet-body">
						<!-- Table -->
						<table class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									
									<th width="30%">{{ lang('my201.item_name') }}</th>
									<th width="45%" class="hidden-xs">{{ lang('my201.qty') }}</th>
									<th width="20%">{{ lang('common.actions') }}</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($accountabilities_tab as $index => $accountable){ 
								?>
								<tr rel="0">
									<!-- this first column shows the year of this holiday item -->
									
									<td>
										<a id="date_name" href="#" class="text-success">
											<?php echo array_key_exists('accountabilities-name', $accountable) ? $accountable['accountabilities-name'] : ""; ?>	
										</a>
										<br />
										<span id="date_set" class="small ">
											<?php echo array_key_exists('accountabilities-code', $accountable) ? $accountable['accountabilities-code'] : ""; ?>	
										</span>
									</td>
									<td class="hidden-xs">
											<?php echo array_key_exists('accountabilities-quantity', $accountable) ? $accountable['accountabilities-quantity']." pcs" : ""; ?>
									</td>
									<td>
										<div class="btn-group">
											<input type="hidden" id="accountabilities_sequence" name="accountabilities_sequence" value="<?=$index?>" />
											<a  href="javascript:view_personal_details('accnt_form_modal', 'accountabilities', <?=$index?>);" ><i class="fa fa-search"></i> View</a>
											
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                </div>
                <!--end portlet-->
			</div>

			<div class="tab-pane" id="historical_tab9">
				<!--Attachments--> 
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('my201.attachment') }}</div>
                    </div>
                    <div class="portlet-body">
						<!-- Table -->
						<table class="table table-condensed table-striped table-hover">
							<thead>
								<tr>
									
									<th width="30%">{{ lang('my201.name') }}</th>
									<th width="45%" class="hidden-xs">{{ lang('my201.filename') }}</th>
									<th width="20%">{{ lang('common.actions') }}</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($attachment_tab as $index => $attachment){ 
								?>
								<tr rel="0">
									<td>
										<a id="date_name" href="#" class="text-success">
											<?php echo array_key_exists('attachment-name', $attachment) ? $attachment['attachment-name'] : ""; ?>	
										</a>
										<br />
										<span id="date_set" class="small text-muted">
											<?php echo array_key_exists('attachment-category', $attachment) ? $attachment['attachment-category'] : ""; ?>	
										</span>
									</td>
									<td class="hidden-xs">
											<?php echo array_key_exists('attachment-file', $attachment) ? substr( $attachment['attachment-file'], strrpos( $attachment['attachment-file'], '/' )+1 ) : ""; ?>	
									</td>
									<td>
										<div class="btn-group">
											<input type="hidden" id="attachment_sequence" name="attachment_sequence" value="<?=$index?>" />
											<a  href="javascript:view_personal_details('attach_form_modal', 'attachment', <?=$index?>);" ><i class="fa fa-search"></i> {{ lang('common.view') }}</a>									
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
                </div>
                <!--end portlet-->
			</div>

			<div class="tab-pane" id="historical_tab17">
				<!--Attachments--> 
                <div class="portlet">
                	<div class="portlet-title">
                    	<div class="caption">{{ lang('partners.movement') }}</div>
                    </div>
                    <div class="portlet-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<!-- <th width="1%"><input type="checkbox" class="group-checkable" data-set=".record-checker" /></th> -->
							<th width="30%">Movement Type</th>
							<th width="25%" class="hidden-xs">Due To</th>
							<th width="25%" class="hidden-xs">Remarks</th>
							<th width="25%" class="hidden-xs">Effective Date</th>
							<th width="20%">{{ lang('common.actions') }}</th>
						</tr>
					</thead>
					<tbody id="movement-list">
						<?php 
							foreach($movement_tab as $index => $movement){ 
						?>
						<tr class="record">
							<!-- this first column shows the year of this holiday item -->
							<td>
								<span class="text-success">
								<?php echo $movement['type']; ?>		
								</span>
								<br>
								<span class="text-muted small">
									<?php echo date('F d, Y - H:ia', strtotime($movement['created_on'])); ?>		
								</span>
							</td>
							<td>
								<?php echo $movement['cause']; ?>
							</td>
							<td>{{ $movement['remarks'] }}</td>
							<td class="hidden-xs">
								<?php echo date('F d, Y', strtotime($movement['effectivity_date'])); ?>	
							</td>
							<td>
								<div class="btn-group">
									<a  href="javascript:view_movement_details(<?php echo $movement['action_id'] ?>, <?php echo $movement['type_id'] ?>, '<?php echo $movement['cause'] ?>');" class="btn btn-xs text-muted" ><i class="fa fa-search"></i> {{ lang('common.view') }}</a>		
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
					</div>
                </div>
                <!--end portlet-->
			</div>

		</div>
	</div>
