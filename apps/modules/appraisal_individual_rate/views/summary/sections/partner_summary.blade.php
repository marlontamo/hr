{{ $header }}
<ul class="list-group">
	<li class="list-group-item">
		@if( $appraisee->status_id == 6 )
			<textarea class="form-control" rows="3" name="partner_summary">{{ $appraisee->partner_summary }}</textarea>
		@else
			<textarea class="form-control" rows="3" name="partner_summary" disabled>{{ $appraisee->partner_summary }}</textarea>
		@endif
	</li>
</ul>
{{ $footer }}