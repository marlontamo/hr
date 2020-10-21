@extends('layouts/master')

@section('page_styles')
	@parent
	@include('edit/page_styles')
@stop

@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-11">
			<form class="form-horizontal">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				@include('edit/fgs')
				@include('buttons/edit')
			</form>
       	</div>  	
	</div>
	<table class="hidden add-new-tem">
		<tbody>
			<tr>
				<td>
					<textarea rows="2" name="requisition_items[item][]" class="form-control"></textarea>
				</td>
				<td>
					<textarea rows="2" name="requisition_items[reason][]" class="form-control"></textarea>
				</td>
				<td>
					<div class="input-group date date-picker" data-date-format="MM dd, yyyy">
						<input type="text"  class="form-control" name="requisition_items[date][]">
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
				</td>
				<td><input type="text" name="requisition_items[quantity][]" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control" value="1"></td>
				<td><input type="text" name="requisition_items[unit_price][]" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control"></td>
				<td><input type="text" name="requisition_items[amount][]" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false" class="form-control" readonly></td>
				<td><button class="btn btn-xs text-muted" onclick="delete_item($(this))"><i class="fa fa-trash-o"></i> Delete</button></td>
			</tr>
		</tbody>
	</table>
@stop

@section('page_plugins')
	@parent
	@include('edit/page_plugins')
@stop

@section('page_scripts')
	@parent
	@include('edit/page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@stop

@section('view_js')
	@parent
	{{ get_edit_js( $mod ) }}
@stop