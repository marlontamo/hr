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
					<?php
					switch($record['requisition.status_id'])
					{
						case 7:
						case 11: ?>
							@include('common/item_view_updated') <?php
							break;
						case 5:
						case 10:
						case 12:?>
							@include('common/item_view_po') <?php
							break;
						case 9:
						case 13: ?>
							@include('common/item_view_completed') <?php
							break;
						default: ?>
							@include('common/item_view') <?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Approver Remarks</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
			<div class="portlet margin-top-25">
				<div class="portlet-body" >
					@include('common/approver_remarks_view')
				</div>
			</div>
		</div>
	</div>
</div>