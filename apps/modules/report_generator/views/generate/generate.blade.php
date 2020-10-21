<div class="portlet" id="vl_container">
	<div class="portlet-title">
		<div class="caption">{{ $record['report_generator.report_name'] }}<small class="text-muted">{{ $record['report_generator.report_code'] }}</small></div>
	</div>

	<div class="portlet">
        @if( $fixed_filters->num_rows() > 0 )
	        <div class="portlet-title">
	            <div class="caption">Fixed Filters</div>
	        </div>
	        <div class="portlet-body form">
	        	<div class="form-body">
	        		<table class="table">
						<thead>
							<tr>
								<td>Column</td>
								<td>Operator</td>
								<td>Filter</td>
							</tr>
						</thead>
						<tbody>
							@foreach( $fixed_filters->result() as $filter )
								<?php switch( $filter->uitype_id ):
				                	case 1:
				                		$label = explode( '_', $filter->label_column );
				                		$label = ucwords( implode( ' ', $label ) );
				                		$db->limit(1);
				                		$value = $db->get_where( $filter->table, array($filter->value_column => $filter->filter) )->row();
										$temp = $filter->label_column;
				                		$value = $value->$temp;
				                		break;
				                	default:
				                		$label = explode( '.', $filter->column );
				                		$label = explode( '_', $label[1] );
				                		$label = ucwords( implode( ' ', $label ) );
				                		$value = $filter->filter;
				            	endswitch; ?>
								<tr>
									<td>{{ $label }}</td>
									<td>{{ $filter->label }}</td>
									<td>{{ $value }}</td>
								</tr>
			                @endforeach
						</tbody>
					</table>
	            </div>
	        </div>
        @endif
        @if( $editable_filters->num_rows() > 0 )
	        <div class="portlet-title">
	            <div class="caption">Editable Filters</div>
	        </div>
	        <div class="portlet-body form">
	        	<div class="form-body">
	        		<table class="table">
						<thead>
							<tr>
								<td>Column</td>
								<td>Operator</td>
								<td>Filter</td>
							</tr>
						</thead>
						<tbody>
							@foreach( $editable_filters->result() as $filter )
								<?php switch( $filter->uitype_id ):
				                	case 1:
				                		$label = explode( '_', $filter->label_column );
				                		$label = ucwords( implode( ' ', $label ) );
				                		break;
				                	default:
				                		$label = explode( '.', $filter->column );
				                		$label = explode( '_', $label[1] );
				                		$label = ucwords( implode( ' ', $label ) );
				                		$value = $filter->filter;
				            	endswitch; ?>

								<tr>
									<td>{{ $label }}</td>
									<td>{{ $filter->label }}</td>
									<td>
										<?php switch( $filter->uitype_id ):
						                	case 1:
						                		$d_label = $filter->label_column;
						                		$d_value = $filter->value_column;
						                		
						                		$db->where('deleted', 0);
												$db->order_by($d_label, 'ASC');
												$db->select($d_label.','.$d_value);
												$rows = $db->get( $filter->table )->result();

												$options = array();
												$options['all'] = "All";
												foreach( $rows as $row )
												{
													$options[$row->$d_value] = $row->$d_label;
												}
												echo form_dropdown('filter['.$filter->filter_id.']', $options, '', 'class="form-control select2me" data-placeholder="Select..."');
						                		break;
						                	case 2:
						                		$booleans = array(
													"1" => "YES",
													"0" => "NO"
												);
												echo form_dropdown('filter['.$filter->filter_id.']', $booleans, '', 'class="form-control select2me" data-placeholder="Select..."');
						                		break;
						                	case 3: ?>
												<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
													<input type="text" class="form-control" name="filter[{{$filter->filter_id}}]" value="" readonly>
													<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div> <?php
						                		break;
						                	case 4; //date and time ?>
												<div class="input-group date form_datetime">                                       
													<input type="text" size="16" readonly class="form-control dtp" name="filter[{{$filter->filter_id}}]" value="" />
													<span class="input-group-btn">
														<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
													</span>
													<span class="input-group-btn">
														<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div> <?php
												break;
											case 5; //time ?>
												<div class="input-group bootstrap-timepicker">                                       
													<input type="text" class="form-control timepicker-default" name="filter[{{$filter->filter_id}}]"/>
													<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
													</span>
												</div> <?php
												break;												
						                	case 9://multiselect
						                		$d_label = $filter->label_column;
						                		$d_value = $filter->value_column;
						                		
						                		$db->where('deleted', 0);
												$db->order_by($d_label, 'ASC');
												$db->select($d_label.','.$d_value);
												$rows = $db->get( $filter->table )->result();

												$options = array();
												$options['all'] = "All";
												foreach( $rows as $row )
												{
													$options[$row->$d_value] = $row->$d_label;
												}
												echo form_dropdown('filter['.$filter->filter_id.']', $options, '', 'class="form-control select2me" multiple="multiple" data-placeholder="Select..."');
						                		break;
						                	default: ?>
						                		<input type="text" class="form-control" name="filter[{{$filter->column}}][{{ $filter->operator }}]" value=""> <?php
						            	endswitch; ?>
									</td>
								</tr>
			                @endforeach
						</tbody>
					</table>
	            </div>
	        </div>
        @endif
    </div>
</div>

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/report_generator/generate.js"></script> 
@stop