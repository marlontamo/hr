<div class="portlet" id="vl_container">
	<div class="portlet-title">
		<div class="caption">{{ lang('memo.memo') }} <small class="text-muted">{{ lang('common.view') }}</small></div>
	</div>
	
    <div class="portlet-body">
    	<div class="form-body margin-bottom-25">
    		<div class="memo-header margin-bottom-25">
				<span class="text-muted small clearfix pull-right hidden-xs">{{ lang('memo.recipient') }}: {{ $record['memo_apply_to_id'] }}</span>
				<h3>{{ $record['memo_memo_title'] }}</h3>
				<h5>{{ $record['memo_publish_from'] }} - {{ date('D', strtotime( $record['memo_publish_from'] )) }}</h5>
				<h6 class="text-muted">{{ $record['memo_memo_type_id'] }}</h6>
			</div>
			@if ( !empty($record['memo_attachment']) )
				@if( file_exists($record['memo_attachment']) )
					@if(getimagesize(base_url().$record['memo_attachment']))
						<image src="{{base_url().$record['memo_attachment']}}" width="100%" />
						</image>
					@elseif(mime_content_type($record['memo_attachment']) == 'application/pdf')
						<iframe src="{{base_url().$record['memo_attachment']}}" width="100%" style="overflow: auto; height: 600px;"></iframe>
					@endif
				@else
					<span style="font-size:14px;font-weight:bold">{{ lang('memo.file_del') }}</span>
				@endif	
			@endif	
			<br><br>
			@if( !empty($record['memo_memo_body']) )
        		{{ $record['memo_memo_body'] }}
        	@endif	
        </div>
    </div>
</div>