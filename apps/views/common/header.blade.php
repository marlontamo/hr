<div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		@section('logo')
			<a class="navbar-brand active-menu" href="{{ site_url('dashboard') }}" style="padding-top:7px;" menu_id="1">
				<img src="<?php echo get_company_logo( $user ); ?>" alt="&nbsp;<?php echo get_system_config('system', 'application_title')?>" style="height:32px;top:0px;margin-left: 15px;" />
			</a>
			<div class="sidebar-toggler hidden-phone"></div>
		@show

		@if(isset($business_group) && sizeof($business_group) > 1)
			@include('common/business_group')
		@endif

		@section('menu_toggle_switch')
			<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<img src="{{ theme_path() }}img/menu-toggler.png" alt="" />
			</a>				
		@show

		@section('menu_nav')
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->	
				<li class="dropdown" id="header_notification_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="fa fa-bell-o"></i>
						<span class="badge"></span>
					</a>
					<ul class="dropdown-menu extended notification">
						<li id="notification-summary"></li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height:100%;max-height:250px;" id="notification-detail"></ul>
						</li>
						<li class="external">&nbsp;  
							<!-- <a href="#">See all notifications <i class="m-icon-swapright"></i></a> -->
						</li>
					</ul>
				</li>
				<!-- END NOTIFICATION DROPDOWN -->

				<!-- BEGIN INBOX DROPDOWN -->
				<?php if( get_system_config('other_settings', 'enable_chat') ): ?>
				<li class="dropdown" id="header_inbox_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
						data-close-others="true">
					<i class="fa fa-globe"></i>
					<span class="badge"></span>
					</a>
					<ul class="dropdown-menu extended inbox">
						<li id="inbox-summary"></li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height:100%;max-height:250px;" id="inbox-detail"></ul>
						</li>
						<li class="external">&nbsp;
							<!-- <a href="#">See all messages <i class="m-icon-swapright"></i></a> -->
						</li>
					</ul>
				</li>
				<?php endif; ?>
				<!-- END INBOX DROPDOWN -->

				<!-- BEGIN GROUP NOTIFICATION DROPDOWN -->	
				<li class="dropdown" id="header_gnotification_bar">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="fa fa-tasks"></i>
						<span class="badge"></span>
					</a>
					<ul class="dropdown-menu extended inbox gnotification">
						<li id="gnotification-summary"></li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height:100%;max-height:250px;" id="gnotification-detail"></ul>
						</li>
						<li class="external">&nbsp;  
							<!-- <a href="#">See all notifications <i class="m-icon-swapright"></i></a> -->
						</li>
					</ul>
				</li>
				<!-- END GROUP NOTIFICATION DROPDOWN -->
				
				@include('templates/todo')
				
				<li class="dropdown hidden">
					@if( get_system_config('other_settings', 'enable_language') )
					<a data-toggle="dropdown" data-onclick="dropdown" data-close-others="true" class="dropdown-toggle" href="javascript:;">
						<span class="selected"></span>
						<span class="tooltips" data-placement="right" data-original-title="Languange">
							<img class="flag" width="18px" style="margin-top: -6px" src="{{ theme_path() }}language/{{ $user_language }}/icon.png">
						</span>   
					</a>
					@endif
					<ul class="dropdown-menu">
						<li>
							<a href="javascript:change_lang('id')" <?php if( $lang == 'id' ) echo 'class="active"';?>>
								<img class="img-responsive pull-left margin-right-10" src="{{ theme_path() }}language/indonesian/icon.png">
							<span>Bahasa Indonesia</span>                 
							</a>
						</li>
						<li>
							<a href="javascript:change_lang('en')" <?php if( $lang == 'en' ) echo 'class="active"';?>>
								<img class="img-responsive pull-left margin-right-10" src="{{ theme_path() }}language/english/icon.png">
							<span>English </span>                 
							</a>
						</li>
						
					</ul>
				</li>
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user"> 
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" src="{{ base_url( $user['photo'] ) }}" height="29px"/>
					<span class="username">{{ $user['firstname'] .' '. $user['lastname'] .' '. (isset($user['suffix']) ? $user['suffix'] : '')  }}</span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{ site_url('account/profile') }}"><i class="fa fa-user"></i> My Profile</a></li>
						<li><a href="{{ site_url('account/calendar') }}"><i class="fa fa-calendar"></i> My Calendar</a></li>
						<!-- 
						<li><a href="account/inbox"><i class="fa fa-envelope"></i> My Inbox <span class="badge badge-danger">3</span></a></li>
						<li><a href="#"><i class="fa fa-tasks"></i> My Tasks <span class="badge badge-success">7</span></a></li>
						-->
						<li class="divider"></li>
						@if( $user['role_id'] == 1 )
							<li><a href="javascript:reset_all_config()"><i class="fa fa-undo"></i> Reset Configs</a></li>
						@endif
						<li><a href="javascript:change_password()"><i class="fa fa-key"></i> Change Password</a></li>
						<li><a href="javascript:support_box()"><i class="fa fa-dropbox"></i> Support Box</a></li>
						<li><a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a></li>
						<li><a href="{{site_url('screenlock')}}"><i class="fa fa-lock"></i> Lock Screen</a></li>
						<li><a href="{{site_url('logout')}}"><i class="fa fa-power-off"></i> Log Out</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
		@show	
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>