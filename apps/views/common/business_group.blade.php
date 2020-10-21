<div class="hor-menu">
	<ul class="nav navbar-nav">
		<li>
			<a class="dropdown-toggle dark-grey-menu padding-11" href="javascript:;" data-close-others="true" data-onclick="dropdown" data-toggle="dropdown">
				<span class="hidden-sm hidden-xs tooltips" data-original-title="change region" data-placement="right">{{ $business_group[$current_db]->group }} <i class="fa fa-angle-down"></i> </span>
			</a>
			<ul class="dropdown-menu">
				@foreach( $business_group as $dbname => $bg )
					@if( $bg->db != $current_db )
						<li>
							<a role="menuitem" tabindex="-1" href="javascript:change_business_group( '{{$bg->db}}' )">
								<img src="{{ base_url($bg->logo) }}" style="height:16px;" class="img-responsive pull-left margin-right-10">
								<span>{{ $bg->group }}</span>
							</a>
						</li>
					@endif	
				@endforeach
			</ul>
		</li>
	</ul>
</div>