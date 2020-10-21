<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-md-4 text-muted text-right">
							Due To:
						</label>
						<div class="col-md-7">
							<?php echo $record['partners_movement_due_to'] ?>
						</div>	
					</div>	
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">Justification Remarks:</label>
				<div class="col-md-7">		
					<?php echo $record['partners_movement_remarks'] ?>					
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">
					Type:
				</label>
				<div class="col-md-7">
					<?php echo $record['partners_movement_action_type_id'] ?>			
				</div>	
			</div>			
			<?php
				if ($movement_approver_remarks && count($movement_approver_remarks) > 0){
			?>
					<div class="form-group">
						<label class="col-md-4 text-right">
							Approver Remarks:
						</label>
						<div class="col-md-7">
							&nbsp;			
						</div>	
					</div>			
			<?php
					foreach ($movement_approver_remarks as $key => $value) {
						if ($value['comment'] != ''){
			?>
							<div class="form-group">
								<label class="col-md-4 text-muted text-right">
									<?php echo $value['display_name'] ?> :
								</label>
								<div class="col-md-7">
									<span>
										<?php
											if ($value['comment_date'] && $value['comment_date'] != '0000-00-00 00:00:00' && $value['comment_date'] != 'January 01, 1970' && $value['comment_date'] != '1970-01-01'){
												echo date('F d, Y h:i a',strtotime($value['comment_date']));
											}											
										?>											
									</span><br />									
									<?php echo $value['comment'] ?>			
								</div>	
							</div>					
			<?php
						}
					}
				}
			?>
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">
					Requested By:
				</label>
				<div class="col-md-7">
					<?php echo $record['partners_movement_created_by_fname'] ?>
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">
					HR Reviewed By:
				</label>
				<div class="col-md-7">
					<?php 
						echo $record['partners_movement_reviewed_by'];
						if ($record['partners_movement_reviewed_by_approved_date'] && $record['partners_movement_reviewed_by_approved_date'] != '0000-00-00 00:00:00' && $record['partners_movement_reviewed_by_approved_date'] != 'January 01, 1970' && $record['partners_movement_reviewed_by_approved_date'] != '1970-01-01'){
							echo ' - ' . date('F d, Y h:i a',strtotime($record['partners_movement_reviewed_by_approved_date']));
						}
					?>
				</div>	
			</div>
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">
					HR Approver 1:
				</label>
				<div class="col-md-7">
					<?php 
						echo $record['partners_movement_approver1'];
						if ($record['partners_movement_approver1_approved_date'] && $record['partners_movement_approver1_approved_date'] != '0000-00-00 00:00:00' && $record['partners_movement_approver1_approved_date'] != 'January 01, 1970' && $record['partners_movement_approver1_approved_date'] != '1970-01-01'){
							echo ' - ' . date('F d, Y h:i a',strtotime($record['partners_movement_approver1_approved_date']));
						}						
					?>
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">
					HR Approver 2:
				</label>
				<div class="col-md-7">
					<?php 
						echo $record['partners_movement_approver2'];
						if ($record['partners_movement_approver2_approved_date'] && $record['partners_movement_approver2_approved_date'] != '0000-00-00 00:00:00' && $record['partners_movement_approver2_approved_date'] != 'January 01, 1970' && $record['partners_movement_approver2_approved_date'] != '1970-01-01'){
							echo ' - ' . date('F d, Y h:i a',strtotime($record['partners_movement_approver2_approved_date']));
						}							
					?>
				</div>	
			</div>	
			<div class="form-group">
				<label class="col-md-4 text-muted text-right">HRD Remarks:</label>
				<div class="col-md-7">		
					<?php echo $record['partners_movement_hrd_remarks'] ?>					
				</div>	
			</div>																	
		</div>
	</div>
</div>
<br>
<div id="nature_movement" class="portlet-body form">
	<input type="hidden" name="movement_count" id="movement_count" value="" />
	<div class="form-horizontal">
		<div class="form-body">
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<th width="15%">Movement Type</th>
						<th width="15%" class="hidden-xs">Effective</th>
						<th width="15%" class="hidden-xs">Remarks</th>	
						<th width="15%">Actions</th>															
					</tr>
				</thead>
				<tbody id="movement_details-list">
					<?php 
					if(count($movement_details) > 0){
						foreach($movement_details as $index => $movement_detail){
							?>
							<tr class="record">
								<td>
									<a id="type" href="#" class="text-success">
										<?php echo $movement_detail['type']; ?>	
									</a>
									<br />
									<span id="date_set" class="small">
										<?php echo $movement_detail['display_name']; ?>	
									</span>
								</td>
								<td class="hidden-xs">
									<?php echo ($movement_detail['effectivity_date'] && $movement_detail['effectivity_date'] != '0000-00-00' && $movement_detail['effectivity_date'] != 'November 30, -0001' && $movement_detail['effectivity_date'] != '1970-01-01') ? date('F d, Y', strtotime($movement_detail['effectivity_date'])) : '' ?>	
								</td>
								<td class="hidden-xs">
									<?php echo $movement_detail['action_remarks']; ?>	
								</td>
								<td>
									<div class="btn-group">
										<input type="hidden" id="action_id" name="action_id" value="<?=$movement_detail['action_id']?>" />
										<a  href="javascript:display_movement_details(<?=$movement_detail['type_id']?>, <?=$movement_detail['action_id']?>);" class="btn btn-xs text-muted"  ><i class="fa fa-info"></i> View</a>
									</div>
								</td>																													
							</tr>
							<?php }
						} 
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="modal fade modal-container-action" aria-hidden="true" data-width="800" ></div>