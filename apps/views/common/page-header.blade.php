<!-- BEGIN STYLE CUSTOMIZER -->
<?php 
	$play_details['end_point'] = ( isset($play_details['end_point']) && $play_details['end_point'] > 0 ) ? $play_details['end_point'] : 1;
	$play_details['points'] = (isset($play_details['points']) ? $play_details['points'] : 0);  
	$width_percent = ($play_details['points']/$play_details['end_point']) * 100;
	$play_details['total_points'] = (isset($play_details['total_points']) ? $play_details['total_points'] : 0);
?>
<div class="theme-panel hidden" style="position:fixed; right: 20px;">
	<div class="toggler"></div>
	<div class="toggler-close"></div>
	<div class="theme-options" style="left: -35px; height: 100px; width: 300px; background: rgba(255,255,255, 0.9); border: 2px solid #ed9c28; border-radius: 20px; padding: 8px 5px 5px 5px; z-index:9999;">
		<a rel="{{ get_mod_route('my_hive') }}" href="{{ get_mod_route('my_hive') }}">
			<ul class="list-unstyled text-muted margin-bottom-10 col-md-12" style="padding-left: 5px; padding-right: 5px;">
	            <li class=" padding-bottom-20">
	            	<img src="{{ theme_path() }}/img/honey-points-45x45.png" class="pull-left" style="">
	            	<div class="progress progress-striped" style="margin-left: 28px; margin-top: 3px; padding-top: 0px; height:25px;">
						<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{ $play_details['points'] }}" aria-valuemin="0" aria-valuemax="{{ $play_details['total_points'] }}" style="width: {{ $width_percent }}%">
							<span class="sr-only">{{ $play_details['points'] }} hp</span>
						</div>
					</div>
					<span class="pull-right" style="margin-top: -17px; font-size:8px;">{{ $play_details['points'] }}/{{ $play_details['end_point'] }} honey points</span>
					<span class="pull-left bold text-info" style="margin-top: -19px; margin-left:30px; font-size:9px;">{{ $play_details['total_points'] or 0 }}</span>
	            </li>
	        </ul>
	    </a>
	</div>
</div>
<!-- END BEGIN STYLE CUSTOMIZER -->  
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		@section('page-title')
			<h3 class="page-title">
				<?php if($mod->method == 'payroll'){ ?>
					Payroll Manager
				<?php }else{ ?>
					{{ $mod->long_name }} <small>{{ $mod->description }}</small>
				<?php } ?>
			</h3>
		@show
		@section('page-breadcrumb')
			<ul class="page-breadcrumb breadcrumb">
				@section('page-breadcrumb-back')
					@if($mod->method != "index")
						<li class="btn-group">
							<a href="{{ $mod->url }}" id="back_button"><button class="btn blue" type="button">
							<span>Back</span>
							</button></a>
						</li>
					@endif
				@show
				@if($mod->method == "index")
					<li class="btn-group">
						<button data-close-others="true" data-delay="1000" data-hover="dropdown" data-toggle="dropdown" class="btn blue dropdown-toggle" type="button">
						<span></span> <i class="fa fa-angle-down"></i>
						</button>
						<ul role="menu" class="dropdown-menu pull-right">
							<li><a href="{{ $mod->url }}"><i class="fa fa-refresh"></i> Refresh</a></li>
							
							<li class="hidden import-button"><a href="javascript:void(0)" onclick="mod_import({{ $mod->mod_id }})"><i class="fa fa-cloud-download"></i> Import</a></li>
							<li class="divider hidden"></li>
							<li class="hidden"><a href="#"><i class="fa fa-cloud-upload"></i> Export</a></li>
						</ul>
					</li>
					@endif
				<li>
					<i class="fa fa-home"></i>
					<a href="{{ base_url('') }}">Home</a> 
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<!-- jlm i class="fa {{ $mod->icon }}"></i -->

					<?php if($mod->method == 'payroll'){ ?>
						Payroll Manager
					<?php }else{ ?>
						<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
						@if( $mod->method != "index" )
							<i class="fa fa-angle-right"></i>
						@endif
					<?php } ?>
				</li>
				@if( $mod->method != "index" && $mod->method != 'payroll')
					<li>{{ ucwords( $mod->method )}}</li>
				@endif
			</ul>
		@show
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
