<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Purchase Request</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		@include('common/form_head')
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">List of Items</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="portlet margin-top-25">
				<div class="portlet-body" >
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
								$item->po_amount = "";
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
								<input type="hidden" name="requisition_items[po_number][]" value="{{ $item->po_number }}" />
								<input type="hidden" name="requisition_items[po_note][]" value="{{ $item->po_note }}" />
								<input type="hidden" name="requisition_items[po_quantity][]" value="{{ $item->po_quantity }}" />
								<input type="hidden" name="requisition_items[po_price][]" value="{{ $item->po_price }}" />

								<table style="border-bottom:1px solid #d6e9c6" class="table table-condensed table-striped table-hover">
		                            <tbody>
		                            	<tr>
		                            		<td width="20%" class="padding-10 bold">Description</td>
		                            		<td width="20%" class="padding-10 bold">Reason</td>
		                            		<td width="10%" class="padding-10 bold">Date</td>
		                            		<td width="12%" class="padding-10 bold">Quantity</td>
		                            		<td width="12%" class="padding-10 bold">Unit</td>
		                            		<td width="16%" class="padding-10 bold">Amount</td>
		                            	</tr>
		                                <tr>
		                                    <td>{{ $item->item }}</td>
		                                    <td>{{ $item->reason }}</td>
		                                    <td>{{ date('M d, Y', strtotime($item->date)) }}</td>
		                                    <td>{{ number_format($item->quantity, 2, '.', ',') }}</td>
		                                    <td>{{ number_format($item->actual_price, 2, '.', ',') }}</td>
		                                   	<td>{{ number_format($item->actual_amount, 2, '.', ',') }}</td>
		                                </tr>
		                                <tr>
		                            		<td class="padding-10 bold">PO Number</td>
		                            		<td class="padding-10 bold">Note</td>
		                            		<td>&nbsp;</td>
		                            		<td class="padding-10 bold">Quantity</td>
		                            		<td class="padding-10 bold">Unit</td>
		                            		<td class="padding-10 bold">Amount</td>
		                            	</tr>
		                            	<tr>
		                                    <td>{{ $item->po_number }}</td>
		                                    <td>{{ $item->po_note }}</td>
		                                    <td>&nbsp;</td>
		                                    <td>{{ number_format($item->po_quantity, 2, '.', ',') }}</td>
		                                    <td>{{ number_format($item->po_price, 2, '.', ',') }}</td>
		                                    <td>{{ number_format($item->po_amount, 2, '.', ',') }}</td>
		                                </tr>
		                                <tr class="warning">
		                            		<td class="padding-10 bold">FROM ACCOUNTING</td>
		                            		<td class="padding-10 bold">Remarks</td>
		                            		<td class="padding-10 bold">Date Received</td>
		                            		<td class="padding-10 bold">Quantity</td>
		                            		<td>&nbsp;</td>
		                            		<td>&nbsp;</td>
		                            	</tr>
		                            	<tr>
											<td class="warning bold" >&nbsp;</td>
											<td>{{$item->accounting_remarks}}</td>
											<td><?php if( !empty($item->date_received) && $item->date_received != '0000-00-00' ) echo date('M d, Y', strtotime($item->date_received)) ?></td>
											<td colspan="2">{{ number_format($item->received_quantity, 2, '.', ',') }}</td>
											<td>&nbsp;</td>
										</tr>
		                            </tbody>
		                        </table>
								
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>