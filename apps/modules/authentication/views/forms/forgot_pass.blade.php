<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget-form" method="post" style="display: none;">
	<h3 >{{ lang('authentication.forgotpass') }}</h3>
	<!-- p>{{ lang('authentication.entermail') }}</p -->
	<div class="form-group">
		<div class="input">
			<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="{{ lang('authentication.email') }}" name="email" />
		</div>
	</div>
	<div class="form-actions">
		<button type="button" id="back-btn" class="btn btn-lg">
		<!-- i class="m-icon-swapleft"></i --> {{ lang('authentication.back') }}
		</button>
		<button type="submit" class="btn btn-lg blue pull-right">
		{{ lang('authentication.submit') }} <!-- i class="m-icon-swapright m-icon-white"></i -->
		</button>            
	</div>
</form>
<!-- END FORGOT PASSWORD FORM -->