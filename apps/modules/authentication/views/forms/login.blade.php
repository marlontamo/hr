<!-- BEGIN LOGIN FORM -->
<form class="login-form" method="post" style="display: none;">
	<h3 class="form-title">{{ lang('authentication.login') }}</h3>
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		<span></span>
	</div>
	<div class="alert alert-info display-hide">
		<button class="close" data-close="alert"></button>
		<span></span>
	</div>
	<div class="form-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9">{{ lang('authentication.username') }}</label>
		<div class="input">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{ lang('authentication.username') }}" name="username" id="username"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">{{ lang('authentication.password') }}</label>
		<div class="input">
			<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ lang('authentication.password') }}" name="password"/>
		</div>
		<div class="small alert alert-warning margin-top-10 padding-5" style="display:none" id="caps-lock">
			<i class="fa fa-warning"></i> Caps lock is on
		</div>
	</div>
	<div class="form-actions">
		<label class="checkbox pull-right">
		<input type="checkbox" name="remember" value="1"/> {{ lang('authentication.remember') }}
		</label>
		<button type="submit" class="btn btn-lg blue">
		{{ lang('authentication.loginbutton') }} <!-- i class="m-icon-swapright m-icon-white"></i -->
		</button>            
	</div>
	<div class="forget-password">
		{{ lang('authentication.noworries') }}
	</div>
</form>
<!-- END LOGIN FORM -->