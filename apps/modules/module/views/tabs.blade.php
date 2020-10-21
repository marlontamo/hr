@if( file_exists( $mod->path . 'views/' . 'tabs_custom.blade.php' )  ) )
	@include('tabs_custom')	
@else
	<ul class="ver-inline-menu tabbable margin-bottom-10">
		<li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa">1</i>Basic Information</a></li>
		<li><a data-toggle="tab" href="#tab-2"><i class="fa">2</i>Module Configuration</a></li>
		<li><a data-toggle="tab" href="#tab-3"><i class="fa">3</i>Field Groups</a></li>
		<li><a data-toggle="tab" href="#tab-4"><i class="fa">4</i>Fields</a></li>
	</ul>
@endif