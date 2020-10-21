@if( file_exists( $mod->path . 'views/' . 'tabs_custom.blade.php' )  ) )
	@include('tabs_custom')	
@else
	<ul class="ver-inline-menu tabbable margin-bottom-10">
		<li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-plus"></i> Basic Information</a></li>
		<li><a data-toggle="tab" href="#tab-2"><i class="fa fa-plus"></i> Module Configuration</a></li>
		<li><a data-toggle="tab" href="#tab-3"><i class="fa fa-plus"></i> Field Groups</a></li>
	</ul>
@endif