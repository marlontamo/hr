<div class="portlet" id="vl_container">
	<div class="portlet-title">
		<div class="caption">Memorandum <small class="text-muted">view</small></div>
	</div>
	
    <div class="portlet-body">
    	<div class="form-body margin-bottom-25">
    		<div class="memo-header margin-bottom-25">
				<span class="text-muted small clearfix pull-right hidden-xs">Recipients: {{ $record['memo_apply_to_id'] }}</span>
				<h3>{{ $record['memo_memo_title'] }}</h3>
				<h5>{{ $record['memo_publish_from'] }} - {{ date('D', strtotime( $record['memo_publish_from'] )) }}</h5>
				<h6 class="text-muted">{{ $record['memo_memo_type_id'] }}</h6>
			</div>
			@if(getimagesize(base_url().$record['memo_attachment']))
				<image src="{{base_url().$record['memo_attachment']}}" width="100%" />
				</image>
			@elseif(mime_content_type($record['memo_attachment']) == 'application/pdf')
				<iframe src="{{base_url().$record['memo_attachment']}}" width="100%" style="overflow: auto; height: 600px;"></iframe>
			@endif
			<br><br>
        	{{ $record['memo_memo_body'] }}
        </div>
    </div>
</div>