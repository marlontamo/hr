<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Basic Information
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">*</span> Report Code</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="report_generator[report_code]" id="report_generator-report_code" value="{{ $record['report_generator.report_code'] }}" placeholder="Enter Report Code">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">*</span> Report Title</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="report_generator[report_name]" id="report_generator-report_name" value="{{ $record['report_generator.report_name'] }}" placeholder="Enter Report Title">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Description</label>
			<div class="col-md-7">
				<textarea class="form-control" name="report_generator[description]" id="report_generator-description" placeholder="Enter Description" rows="4">
{{ $record['report_generator.description'] }}
</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">*</span> Category</label>
			<div class="col-md-7">
				<?php                                                                     $db->select('category_id,category');
																								$db->order_by('category', '0');
														$db->where('deleted', '0');
														$options = $db->get('report_generator_category');                               $report_generator_category_id_options = array('' => 'Select...');
												foreach($options->result() as $option)
												{
																							$report_generator_category_id_options[$option->category_id] = $option->category;
																					} ?>
				<div class="input-group">
					{{ form_dropdown('report_generator[category_id]',$report_generator_category_id_options, $record['report_generator.category_id'], 'class="form-control select2me" data-placeholder="Select..."') }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">*</span> Accessed By</label>
			<div class="col-md-7">
				<?php                                                             $db->select('role_id,role');
																						$db->where('deleted', '0');
													$options = $db->get('roles');
													$report_generator_roles_options = array();
													foreach($options->result() as $option)
													{
																									$report_generator_roles_options[$option->role_id] = $option->role;
																							} ?>
				<div class="input-group">
					{{ form_dropdown('report_generator[roles][]',$report_generator_roles_options, explode(',', $record['report_generator.roles']), 'class="form-control" data-placeholder="Select..." multiple="multiple" id="report_generator-roles"') }}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Tables
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage to add tables and configure each settings and relationship.</p>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3"><span class="required">*</span> Primary Table</label>
			<div class="col-md-5">
				<div class="input-group">
					<?php echo form_dropdown('primary_table', $tables, '', 'class="dontserializeme form-control select2me searchable" data-placeholder="Select..."'); ?>
					<span class="input-group-btn">
                    	&nbsp;
                    </span>
				</div>
				<div class="help-block small">
	            	Select primary table then click button to modify.
	        	</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Add Related Table</label>
			<div class="col-md-5">
				<div class="input-group">
					<?php echo form_dropdown('add_more_table', $tables, '', 'class="dontserializeme form-control select2me searchable" data-placeholder="Select..."'); ?>
					<span class="input-group-btn">
                    	<button class="btn btn-success" type="button" onclick="add_table('', 0)" ><i class="fa fa-plus"></i></button>
                    </span>
				</div>
				<div class="help-block small">
                	Select join type to add and modify related table.
            	</div>
			</div>
		</div>
		<div class="portlet margin-top-25">
			<h5 class="form-section margin-bottom-10"><b>List of Tables</b></h5>
			<div class="portlet-body">
				<table class="table table-condensed table-striped table-hover">
					<thead>
                        <tr>
                        	
                        	<th width="15%" class="padding-top-bottom-10">Join Type</th>
                        	<th width="20%" class="padding-top-bottom-10 hidden-xs">Table</th>
                            <th class="padding-top-bottom-10"></th>
                            <th width="15%" class="padding-top-bottom-10"></th>
                            <th width="10%" class="padding-top-bottom-10">Operator</th>
                            <th width="15%" class="padding-top-bottom-10">Join To</th>
                            <th class="padding-top-bottom-10">Action</th>
                        </tr>
                    </thead>
					<tbody id="listed-tables"><?php
						if( isset($saved_table) )
						{
							foreach($saved_table as $table)
							{
								echo $table;
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Fields and Columns
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage to add fields and columns and configure each settings.</p>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">Add Column</label>
			<div class="col-md-5">
				<div class="input-group">
					<?php echo form_dropdown('add_column', array(), '', 'class="dontserializeme form-control select2me searchable" data-placeholder="Select..."'); ?>
					<span class="input-group-btn">
						<button type="button" onclick="add_select()" class="btn btn-success"><i class="fa fa-plus"></i></button>
					</span>
				</div>
				<div class="help-block small">
                	Select column to add and modify.
            	</div>
			</div>
		</div>
		<br/>
		<div class="clearfix margin-top-25">
			<h5 class="form-section margin-bottom-10"><b>List of Columns</b></h5>
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<td>Column</td>
						<td>Alias</td>
						<td>Format</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody id="listed-select"><?php
					if( isset($saved_column) )
					{
						foreach($saved_column as $column)
						{
							echo $column;
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Add Filters
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage to add filters and configure each settings.</p>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">Filter Type</label>
			<div class="col-md-5">
				<?php echo form_dropdown('filter_type', array(1 => "Fixed", 2 => "Editable"), '', 'class="dontserializeme form-control select2me" data-placeholder="Select..."'); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Filter Column</label>
			<div class="col-md-5">
				<?php echo form_dropdown('filter_column', array(), '', 'class="dontserializeme form-control select2me" data-placeholder="Select..."'); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Uitype</label>
			<div class="col-md-5">
				<?php echo form_dropdown('filter_uitype', $uitypes, '', 'class="dontserializeme form-control select2me" data-placeholder="Select..."'); ?>
			</div>
		</div>
        <div class="form-group">
            <label class="control-label col-md-3">Required</label>
            <div class="col-md-5">
                <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                    <input type="checkbox" value="1" checked="checked" name="filter_required_chkbox" id="filter_required_chkbox" class="dontserializeme toggle"/>
                </div> 
            </div>
        </div>	
		<div id="additional-info-filter" style="display:none">
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">*</span> Table</label>
				<div class="col-md-5">
					<input type="text" class="dontserializeme form-control" name="ai-table" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">*</span> Value Column</label>
				<div class="col-md-5">
					<input type="text" class="dontserializeme form-control" name="ai-value" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">*</span> Label Column</label>
				<div class="col-md-5">
					<input type="text" class="dontserializeme form-control" name="ai-label" value="">	
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3"></label>
			<div class="col-md-5">
				<button type="button" onclick="add_filter()" class="btn btn-success"><i class="fa fa-plus"></i> Add Filter</button>
			</div>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Fixed Filters
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="clearfix">
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<td>Column</td>
						<td>Operator</td>
						<td>Filter</td>
						<td>Logical Operator</td>
						<td>Bracket</td>
						<td>Required</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody id="listed-fixed_filter"><?php
					if( isset($saved_ff) )
					{
						foreach($saved_ff as $ff)
						{
							echo $ff;
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Editable Filters
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="clearfix">
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<th width="10%">Column</th>
						<th width="10%">Operator</th>
						<th width="10%">Filter</th>
						<th width="10%">Logical Operator</th>
						<th width="10%">Bracket</th>
						<th width="10%">Required</td>
						<td width="10%">Order By</td> 
						<td width="10%">Filtering Only</td>									
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody id="listed-editable_filter"><?php
					if( isset($saved_ef) )
					{
						foreach($saved_ef as $ef)
						{
							echo $ef;
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Grouping
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage to group columns.</p>
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">Select Column</label>
			<div class="col-md-5">
				<div class="input-group">
					<?php echo form_dropdown('add_group', array(), '', 'class="dontserializeme form-control select2me searchable" data-placeholder="Select..."'); ?>
					<span class="input-group-btn">
                    	<button type="button" onclick="add_groupx()" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    </span>
				</div>
				<div class="help-block small">
                	Select column to group and modify.
            	</div>
			</div>
		</div>
		
		<div class="clearfix margin-top-25">
			<h5 class="form-section margin-bottom-10"><b>List of Groupings</b></h5>
			<table class="table table-condensed table-striped table-hover">
				<thead>
					<tr>
						<td>Group By</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody id="listed-group"><?php
					if( isset($saved_group) )
					{
						foreach($saved_group as $group)
						{
							echo $group;
						}
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Sorting
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section manage sorting and settings.</p>
	<div class="portlet-body form">
		<div class="portlet-body form">
			<div class="form-group">
				<label class="control-label col-md-3">Select Column</label>
				<div class="col-md-5">
					<div class="input-group">
						<?php echo form_dropdown('add_sort', array(), '', 'class="dontserializeme form-control select2me searchable" data-placeholder="Select..."'); ?>
						<span class="input-group-btn">
	                    	<button type="button" onclick="add_sortx()" class="btn btn-success"><i class="fa fa-plus"></i></button>
	                    </span>
					</div>
					<div class="help-block small">
                    	Select column to group and modify.
                	</div>
				</div>
			</div>
			<div class="clearfix margin-top-25">
				<h5 class="form-section margin-bottom-10"><b>List of Sortings</b></h5>
				<table class="table table-condensed table-striped table-hover">
					<thead>
						<tr>
							<td>Sort By</td>
							<td>Sort order</td>
						</tr>
					</thead>
					<tbody id="listed-sort"><?php
						if( isset($saved_sort) )
						{
							foreach($saved_sort as $sort)
							{
								echo $sort;
							}
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">
			Header and Footer
		</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="portlet-body form">
			<div class="form-group">
				<label class="control-label col-md-3">Header</label>
				<div class="col-md-7">
					<textarea rows="4" placeholder="Enter Header" name="report_generator_letterhead[1]" class="form-control"><?php if(isset($saved_header)) echo $saved_header?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-3">Footer</label>
				<div class="col-md-7">
					<textarea rows="4" placeholder="Enter Header" name="report_generator_letterhead[2]" class="form-control"><?php if(isset($saved_footer)) echo $saved_footer?></textarea>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var t_count = <?php echo $t_count?>;
	var tables = {};
	<?php
		if(isset( $tbls )){
			foreach ($tbls as $alias => $t_cols) { ?>
				tables['<?php echo $alias?>'] = ["<?php echo implode('", "', $t_cols)?>"]; <?php
			}
		}
	?>
</script>

<style>
	body.dragging, body.dragging * {
		cursor: move !important;
	}

	.dragged {
		position: absolute;
		opacity: 0.5;
		z-index: 2000;
	}
</style>