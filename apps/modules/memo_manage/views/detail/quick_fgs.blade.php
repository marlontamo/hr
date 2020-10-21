<div class="portlet" id="vl_container">
	<div class="portlet-body">
    	<div class="form-body margin-bottom-25">
    		<div class="memo-header margin-bottom-25">
				<span class="text-muted small clearfix pull-right hidden-xs">Recipients: {{ $record['memo_apply_to_id'] }}</span>
				<h3>{{ $record['memo_memo_title'] }}</h3>
				<h5>{{ $record['memo_publish_from'] }} - {{ date('D', strtotime( $record['memo_publish_from'] )) }}</h5>
				<h6 class="text-muted">{{ $record['memo_memo_type_id'] }}</h6>
			</div>
        	{{ $record['memo_memo_body'] }}
        </div>
    </div>
</div>