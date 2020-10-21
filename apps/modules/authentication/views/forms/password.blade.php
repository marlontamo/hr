<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<form id="password-form">
				<div class="form-group">
					<label class="control-label cur_pass">{{ lang('authentication.currentpass') }} <span class="required">*</span></label>
					<div class="input-icon">
						<i class="fa fa-key"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ lang('authentication.entercurrentpass') }}" name="current_password"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">{{ lang('authentication.newpass') }} <span class="required">*</span></label>
					<div class="input-icon">
						<i class="fa fa-key"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ lang('authentication.enternewpass') }}" name="new_password"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label">{{ lang('authentication.confirmpass') }} <span class="required">*</span></label>
					<div class="input-icon">
						<i class="fa fa-key"></i>
						<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="{{ lang('authentication.confirmnewpass') }}" name="confirm_password"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal-footer margin-top-0">
	<button type="button" data-dismiss="modal" class="btn btn-default btn-sm btn_cancel">{{ lang('authentication.cancel') }}</button>
	<button type="button" class="btn green btn-sm" onclick="vaidate_passwords()">{{ lang('authentication.savechanges') }}</button>
</div>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript">
	function vaidate_passwords()
	{
		$('.modal-container').block({ message: '<img src="'+root_url+'assets/img/ajax-loading.gif" />',
			onBlock: function(){
				$('#password-form').submit();	
			}
		});
		$('.modal-container').unblock();
	}

	function init_password_form()
	{
		var form = $('#password-form');
		form.validate({
			rrorElement: 'span', //default input error message container
	        errorClass: 'help-block', // default input error message class
	        focusInvalid: false, // do not focus the last invalid input
	        rules: {
	            //account
	            current_password: {
	                minlength: 8,
	                required: true
	            },
	            new_password: {
	                minlength: 8,
	                required: true
	            },
	            confirm_password: {
	                minlength: 8,
	                required: true,
	                equalTo: 'input[name="new_password"]'
	            },
			},
			highlight: function (element) { // hightlight error inputs
	            $(element)
	                .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
	        },
	        unhighlight: function (element) { // revert the change done by hightlight
	            $(element)
	                .closest('.form-group').removeClass('has-error'); // set error class to the control group
	        },
	        submitHandler: function (form) {
	            update_password();
	        }
		});
	}

	function update_password()
	{
		$.ajax({
			url: base_url + 'update_password',
			type:"POST",
			dataType: "json",
			data: $('#password-form').serialize(),
			async: false,
			success: function ( response ) {
				handle_ajax_message( response.message );

				if( response.update )
					$('.modal-container').modal('hide');
			}
		});
	}
</script>