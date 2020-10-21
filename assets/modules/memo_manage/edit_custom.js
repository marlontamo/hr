$(document).ready(function(){
    
    if ($('.wysihtml5').size() > 0) {
        $('.wysihtml5').wysihtml5({
            "stylesheets": ["assets/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    
        $('input[name="_wysihtml5_mode"]').addClass('dontserializeme');
    }
    // $('#memo-applied_to').multiselect();
    $('select[name="memo[apply_to_id]"]').change(function(){
        $.ajax({
            url: base_url + module.get('route') + '/get_applied_to_options',
            type:"POST",
            data: { apply_to: $('select[name="memo[apply_to_id]"]').val()},
            dataType: "json",
            async: false,
            success: function ( response ) {
                handle_ajax_message( response.message );

                $('#memo-applied_to').html( response.options );
                // $('#memo-applied_to').multiselect("refresh");
                $('#memo-applied_to').select2();
            }
        });
    });
});
function save_record( form, action, callback )
{
    $.blockUI({ message: saving_message(),
        onBlock: function(){

            var hasCKItem = form.find("textarea.ckeditor");

            if(hasCKItem){
                
                for ( instance in CKEDITOR.instances )
                    CKEDITOR.instances[instance].updateElement();
            }

            var data = form.find(":not('.dontserializeme')").serialize();
            $.ajax({
                url: base_url + module.get('route') + '/save',
                type:"POST",
                data: data,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( response.saved )
                    {
                        if( response.action == 'insert' )
                            $('#record_id').val( response.record_id );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                        switch( action )
                        {
                            case 'new':
                                document.location = base_url + module.get('route') + '/add';
                                break;
                        }
                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}