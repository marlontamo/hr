$(document).ready(function(){
    $.cookie('menu_id', 1, {path: '/'});  
    //unset page_visited
    $.cookie("page_visited", 'no', { path: '/' });    

   
});

if( typeof( Backbone ) != "undefined" )
{
    var Authentication = Backbone.Model.extend({
        urlRoot: base_url + module.get('route') + '/check_credentials',
        login: function(){
            //$('.alert-danger, .login-form').hide();
            //$('#loader').show();
            var login = { username: $('.login-form input[name="username"]').val(), password: $('.login-form input[name="password"]').val(), rememberme: $('.login-form input[name="remember"]').is(':checked')};
            this.save(login, {
                success: function(model, response){
                    if(response.message.type == 'success')
                    {
                        if(response.redirect != undefined )
                            window.location = root_url + response.redirect;    
                        else
                        window.location = root_url;

                        $.cookie("page_visited", 'no', { path: '/' });  
                    }
                    else
                    {
                        $('.alert-danger, .login-form').show();                        
                        $('.alert-danger span').html( response.message.message );
                        $('#loader').hide();
                    }
                }
            });
            return false;
        },
    });

    window.authentication = new Authentication();
}

function request_reset_pass()
{
    $('form.forget-form').block({ message: '', 
        onBlock: function(){
            $.ajax({
                url: base_url + module.get('route') + '/request_reset_pass',
                type:"POST",
                data: 'email='+$('form.forget-form input[name="email"]').val(),
                dataType: "json",
                async: false,
                beforeSend: function(){
                },
                success: function ( response ) {
                    if( response.success )
                    {
                        $('#back-btn').click()
                        $('.alert-info span').html( 'A password reset mail will be sent to you shortly.' );
                        $('.alert-info', $('.login-form')).show();
                        $('form.forget-form input[name="email"]').val('');
                    }
                    else{
                        var message = response.message;
                        $('form.forget-form div.form-group').addClass('has-error')
                        $('form.forget-form div.form-group').append('<span for="email" class="help-block">'+message.message+'</span>')
                    }
                }
            });
        }
    });
    $('form.forget-form').unblock();
}