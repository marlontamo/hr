@foreach ($menu as $item)
	<li>
		<a href="{{ $item->uri }}" menu_id="{{ $item->menu_item_id }}" parent="0">
			<i class="fa {{ $item->icon }}"></i> 
			<span class="title">{{ $item->label }}</span>
			@if( !empty( $item->submenu ) )
				<span class="arrow"></span>
			@endif
		</a>
		@if( !empty( $item->submenu ) )
			<ul class="sub-menu">
				@foreach( $item->submenu as $subitem ) 
					<li ><a rel="{{ $subitem->uri }}" href="{{ $subitem->uri }}" menu_id="{{ $subitem->menu_item_id }}" parent="{{ $subitem->parent_menu_item_id }}">{{ $subitem->label }}</a></li>
				@endforeach
			</ul>
		@endif
	</li>
@endforeach