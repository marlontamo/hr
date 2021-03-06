@foreach( $items as $item )
	@if( $item->proceed )
		<?php 
		if( !empty( $item->actual_price ) )
			$item->actual_amount = $item->actual_price * $item->quantity;
		else
			$item->actual_amount = "";	

		if( !empty( $item->po_price ) )
			$item->po_amount = $item->po_price * $item->quantity;
		else
			$item->po_amount = 0;
		?>
		<div class="panel panel-success">
    		<div class="panel-heading">
				<h3 class="panel-title">Purchase Order</h3>
			</div>
			<input type="hidden" name="requisition_items[item][]" value="{{ $item->item }}" />
			<input type="hidden" name="requisition_items[reason][]" value="{{ $item->reason }}" />
			<input type="hidden" name="requisition_items[date][]" value="{{ $item->date }}" />
			<input type="hidden" name="requisition_items[quantity][]" value="{{ $item->quantity }}" />
			<input type="hidden" name="requisition_items[unit_price][]" value="{{ $item->unit_price }}" />
			<input type="hidden" name="requisition_items[actual_price][]" value="{{ $item->actual_price }}" />

			<table style="border-bottom:1px solid #d6e9c6" class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                    	<th width="20%" class="padding-top-bottom-10">Description</th>
                    	<th width="20%" class="padding-top-bottom-10">Reason</th>
                    	<th width="10%" class="padding-top-bottom-10">Date</th>
                    	<th width="12%" class="padding-top-bottom-10">Quantity</th>
                    	<th width="12%" class="padding-top-bottom-10">Unit</th>
                    	<th width="16%" class="padding-top-bottom-10">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->reason }}</td>
                        <td>{{ date('M d, Y', strtotime($item->date)) }}</td>
                        <td>{{ number_format($item->quantity, 2, '.', ',') }}</td>
                        <td>{{ number_format($item->actual_price, 2, '.', ',') }}</td>
                       	<td>{{ number_format($item->actual_amount, 2, '.', ',') }}</td>
                    </tr>
                </tbody>
            </table>
			<table class="table table-condensed table-hover">
                <thead>
                    <tr>
                    	<th width="20%" class="padding-top-bottom-10">PO Number</th>
                    	<th width="30%" class="padding-top-bottom-10">Note</th>
                    	<th width="12%" class="padding-top-bottom-10">Quantity</th>
                    	<th width="12%" class="padding-top-bottom-10">Unit</th>
                    	<th width="16%" class="padding-top-bottom-10">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $item->po_number }}</td>
                        <td>{{ $item->po_note }}</td>
                        <td>{{ number_format($item->po_quantity, 2, '.', ',') }}</td>
                        <td>{{ number_format($item->po_price, 2, '.', ',') }}</td>
                        <td>{{ number_format($item->po_amount, 2, '.', ',') }}</td>
                    </tr>
                </tbody>
            </table>
		</div>
	@endif
@endforeach