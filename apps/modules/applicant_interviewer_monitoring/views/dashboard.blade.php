<div class="row margin-bottom-25">
	<div class="col-md-4">
		<div class="portlet">
			<form name="filter">
				<input type="hidden" name="year" value="{{ date('Y') }}">
				<input type="hidden" name="request_id" value="{{ $request_id }}">
			</form>
			<div class="portlet-title">
				<div class="caption">Active Post</div>
			</div>

			<div class="portlet-body">
				@if( sizeof( $mrf ) > 0 )
					@foreach( $mrf as $year => $mrfs )
						<span class="small">{{ $year }}</span>
						<div>
							<span class="margin-right-5"><a type="button" class="btn default btn-xs margin-bottom-6 filter-year" year="{{$year}}" href="javascript:filter_all({{ $year }})"> <i class="fa fa-tags"></i> All</a></a></span>	
							@foreach( $mrfs as $mrf )
								<span class="margin-right-5"><a type="button" class="btn default btn-xs margin-bottom-6 filter-request" request_id="{{ $mrf->request_id }}" href="javascript:filter_detail({{ $mrf->request_id }})"> <i class="fa fa-tags"></i> {{ $mrf->position }} </a></a></span>
							@endforeach
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="portlet steps-container"></div>
	</div>
	
</div>