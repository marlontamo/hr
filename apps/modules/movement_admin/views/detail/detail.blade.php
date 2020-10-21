@extends('layouts.master')

@section('page_content')
	@parent

<div class="row">
	<div class="col-md-9">
		<form class="form-horizontal">
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
								<label class="control-label col-md-4 text-muted">
									Due To:
								</label>
								<div class="col-md-7">
									<?php									                            		
									$db->select('cause_id,cause');
									$db->order_by('cause', '0');
									$db->where('deleted', '0');
									$options = $db->get('partners_movement_cause'); 	                            
									$partners_movement_due_to_id_options = array('' => 'Select...');
									
									foreach($options->result() as $option)
									{
										if($option->cause_id == $record['partners_movement.due_to_id']) {
											$selected = $option->cause;
											break;
										}
									} 
									echo $selected;
									?>
								</div>	
							</div>	
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Movement Remarks</label>
						<div class="col-md-7">							
							<textarea class="form-control" name="partners_movement[remarks]" id="partners_movement-remarks" placeholder="Enter Remarks" rows="4" disabled="disabled"><?php echo $record['partners_movement.remarks'] ?></textarea> 				
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
								<th width="28%">Movement Type</th>
								<th width="25%" class="hidden-xs">Effective</th>
								<th width="25%" class="hidden-xs">Remarks</th>
								<th width="18%">Actions</th>
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
											<?php echo date('F d, Y', strtotime($movement_detail['effectivity_date'])); ?>	
										</td>
										<td class="hidden-xs">
											<?php echo $movement_detail['action_remarks']; ?>	
										</td>
										<td>
											
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
		</form>
	</div>
</div>
@stop

@section('page_plugins')
	@parent
<script type="text/javascript" src="{{ theme_path() }}modules/movement/lists_custom.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
	@parent
	{{ get_list_js( $mod ) }}
@stop

