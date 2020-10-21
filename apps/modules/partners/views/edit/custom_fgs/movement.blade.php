<div class="portlet">
	<div class="portlet-title">
		<div class="caption" >{{ lang('partners.movement') }}</div>
		<div class="actions hidden">
			<a class="btn btn-default" href="javascript:edit_personal_details('attach_form_edit_modal', 'movement', 0);" >
                <i class="fa fa-plus"></i>
            </a>
            <a class="btn btn-default" href="javascript:delete_records('movement')">
            	<i class="fa fa-times"></i>
            </a>
		</div>
	</div>
	<div class="portlet-body form">
	    <div class="form-horizontal">
	        <div class="form-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<!-- <th width="1%"><input type="checkbox" class="group-checkable" data-set=".record-checker" /></th> -->
							<th width="30%">Movement Type</th>
							<th width="25%" class="hidden-xs">Due To</th>
							<th width="25%" class="hidden-xs">{{ lang('common.remarks') }}</th>
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
	</div>
</div>