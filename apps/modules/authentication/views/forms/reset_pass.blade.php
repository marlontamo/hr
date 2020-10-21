<!-- BEGIN RESET PASSWORD FORM -->
<form class="reset-form" method="post" style="display: none;">
	@if($reset)
		<h3 class="form-title">{{ lang('authentication.resetpass') }}</h3>
			<p>{{ lang('authentication.clicklogin') }}</p>

			<div class="alert alert-success">
				<strong>{{ lang('authentication.success') }}</strong> {{ $message }}
			</div>

			<div class="form-actions">
				<a id="login-now" class="btn blue pull-right">
				{{ lang('authentication.loginbutton') }} <i class="m-icon-swapright m-icon-white"></i>
				</a>            
			</div>
		</form>
	@endif

	@if(!$reset)
		<h3 class="form-title">{{ lang('authentication.resetpass') }}</h3>
		<p>{{ lang('authentication.clicktoreset') }}</p>

		<div class="alert alert-danger">
			<strong>{{ lang('authentication.error') }}</strong> {{ $message }}
		</div>

		<div class="form-actions">
			<a id="request-again" class="btn blue pull-right">
			{{ lang('authentication.resetpass') }} <i class="m-icon-swapright m-icon-white"></i>
			</a>            
		</div>
	@endif
</form>
<!-- END RESET PASSWORD FORM -->