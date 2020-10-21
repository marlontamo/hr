	<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Employee Movement</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>Due To
			</label>
			<div class="col-md-7">
				<?php									                            		
				$db->select('cause_id,cause');
				$db->order_by('cause', '0');
				$db->where('deleted', '0');
				$options = $db->get('partners_movement_cause'); 	                            
				$partners_movement_due_to_id_options = array('' => 'Select...');
				?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					<input type="hidden" class="form-control" name="partners_movement[due_to_id]" value="2" />
					<select name="partners_movement[due_to_id]" id="partners_movement-due_to_id"
					 class="form-control form-select" data-placeholder="Select..." disabled>
					 <option value="">Select... </option>
						<?php 
							foreach($options->result() as $option)
							{
							$selected = ($option->cause_id == $record['partners_movement.due_to_id']) ? "selected" : $option->cause_id == 2 ? "selected"  : "";
						?>
							<option <?php echo $selected; ?> value="<?php echo $option->cause_id ?>"><?php echo $option->cause; ?> </option>
						<?php
							} 
						?>
					</select>
				</div> 				
			</div>	
		</div>		
		<div class="form-group">
			<label class="control-label col-md-3">Justification Remarks</label>
			<div class="col-md-7">							
				<textarea class="form-control" name="partners_movement[remarks]" id="partners_movement-remarks" placeholder="Enter Remarks" rows="4"><?php echo $record['partners_movement.remarks'] ?></textarea> 				
			</div>	
		</div>	
<!-- 		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>Remarks
			</label>
			<div class="col-md-7">
				<?php									                            		
				$db->select('remarks_print_report_id,remarks_print_report');
				$db->order_by('remarks_print_report', '0');
				$db->where('deleted', '0');
				$options = $db->get('partners_movement_remarks'); 	                            
				$partners_movement_action_type_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$partners_movement_remarks_print_report_id_options[$option->remarks_print_report_id] = $option->remarks_print_report;
				} 
				?>							
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('remarks_print_report_id',$partners_movement_remarks_print_report_id_options, $record['partners_movement.remarks_print_report_id'], 'class="form-control select2me" data-placeholder="Select..." id="remarks_print_report_id"') }}
				</div> 				
			</div>	
		</div> -->			
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span><?php echo lang('movement.type') ?>
			</label>
			<div class="col-md-7">
				<?php									                            		
				$db->select('type_id,type');
				$db->order_by('type', '0');
				$db->where('deleted', '0');
				$db->where_in('type_id',array(6,11));
				$options = $db->get('partners_movement_type'); 	                            
				$partners_movement_action_type_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$partners_movement_action_type_id_options[$option->type_id] = $option->type;
				} 
				?>							
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('type_id',$partners_movement_action_type_id_options, $record['partners_movement_action.type_id'], 'class="form-control select2me" data-placeholder="Select..." id="type_id"') }}
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" onclick="edit_movement_details()"><i class="fa fa-plus"></i></button>
					</span>
				</div> 				
			</div>	
		</div>
		<div class="form-group cat_type" style="<?php echo ($record['partners_movement_action.type_id'] != 8) ? 'display:none' : '' ?>">
			<label class="control-label col-md-3">
				<span class="required">* </span><?php echo lang('movement.cat') ?>
			</label>
			<div class="col-md-7">
				<?php									                            		
				$db->select('type_category_id,type_category');
				$db->order_by('type_category', '0');
				$db->where('deleted', '0');
				$options = $db->get('partners_movement_type_category'); 	                            
				$partners_movement_action_type_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$partners_movement_action_type_id_options[$option->type_category_id] = $option->type_category;
				} 
				?>							
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('type_category_id',$partners_movement_action_type_id_options, $record['partners_movement_action.type_id'], 'class="form-control select2me" data-placeholder="Select..." id="type_category_id"') }}
				</div> 				
			</div>	
		</div>		
	</div>
</div>
<br>
<div id="nature_movement" class="portlet-body form">
    <input type="hidden" name="movement_count" id="movement_count" value="{{ $record['movement_count'] }}" />
    <div class="form-horizontal">
        <div class="form-body">
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<th width="15%">Movement Type</th>
						<th width="15%" class="hidden-xs">Effective</th>
						<th width="15%" class="hidden-xs">Reason</th>
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
								<?php echo ($movement_detail['effectivity_date'] && $movement_detail['effectivity_date']!= '0000-00-00' && $movement_detail['effectivity_date'] != 'November 30, -0001' ? date('F d, Y', strtotime($movement_detail['effectivity_date'])) : ''); ?>	
						</td>
						<td class="hidden-xs">
								<?php echo $movement_detail['action_remarks']; ?>	
						</td>				
						<td>
							<div class="btn-group">
								<input type="hidden" id="action_id" name="action_id" value="<?=$movement_detail['action_id']?>" />
								<a  href="javascript:edit_movement_details(<?=$movement_detail['type_id']?>, <?=$movement_detail['action_id']?>);" class="btn btn-xs text-muted"  ><i class="fa fa-pencil"></i> Edit</a>
							</div>
							<div class="btn-group">
								<a href="javascript:delete_movement_type(<?=$movement_detail['action_id']?>)" class="btn btn-xs text-muted"><i class="fa fa-trash-o"></i> Delete</a>
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
<div class="form-actions fluid">
    <div class="row" align="center">
        <div class="col-md-12">
            <div>
            	<?php 
            		if ( $record['partners_movement.status_id'] == 1 || empty($record_id) ){
				?>
                <button class="btn green btn-sm" type="button" onclick="save_movement( $(this).closest('form'), 1)" ><i class="fa fa-check"></i> Save as draft</button>
				<button class="btn blue btn-sm" type="button" onclick="save_movement( $(this).closest('form'), 2)"><i class="fa fa-undo"></i> Submit</button>                 
                <?php
					}elseif( in_array($record['partners_movement.status_id'], array(2,3,7)) ){
				?>
				<button class="btn green btn-sm" type="button" onclick="save_movement( $(this).closest('form'), 3)"><i class="fa fa-check"></i> Save</button>  
				<?php
					}
				?>                              
            	<a class="btn default btn-sm" href="{{ $mod->url }}">Back to list</a>
            </div>
        </div>
    </div>
</div>
