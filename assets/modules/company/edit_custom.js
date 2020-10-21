        var create = function(el){ //console.log(el); return false;

            var target_id = el.data('target-id');

            /*console.log('CONTACT TYPE:' + el.data('contact-type'));
            console.log(el);*/

            var contact_type = el.data('contact-type').toLowerCase();
            var current_id = $('.' + contact_type.toLowerCase()).length;
            var next_id = current_id + 1;
            var label = contact_type == 'fax' ? 'Fax No.' : el.data('contact-type').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});

            // console.log(target_id);
            // console.log(contact_type);
            // console.log(current_id);
            // console.log(next_id);


            //console.log($('#com_cm_' + contact_type + '_' + current_id).val());

            if( $('#com_cm_' + contact_type + '_' + current_id).val() === ''){
                $('#com_cm_' + contact_type + '_' + current_id).focus();
                return false;
            }

            /*console.log( $('.' + contact_type.toLowerCase()) );
            console.log($('.phone').length);*/            

            //console.log($('.phone').length);
            //console.log($('.phone').length);

            $(el)
                .attr('id', 'replacer-blah-blah')
                .data('target-id', contact_type + '-group-add-nw' + current_id)
                .addClass('remove')
                .removeClass('create')
                .html('<i class="fa fa-trash-o"></i>');

            $('<div id="' + contact_type + '-group-add-nw' + next_id + '" class="form-group hidden-sm hidden-xs ' + contact_type + '"><label class="control-label col-md-3">' + label + '</label><div class="col-md-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-phone"></i></span><input type="text" class="form-control" maxlength="16" name="users_company_contact[' + contact_type + '][new][contact_no][' + next_id + ']" id="com_cm_' + contact_type + '_' + next_id + '" placeholder="Enter ' + label + ' Number"></div></div><span class="hidden-xs hidden-sm"><a data-target-id="' + contact_type + '-group-add-nw' + next_id + '" data-contact-type="' + contact_type + '" class="btn btn-default btn-sm create" href="#"><i class="fa fa-plus"></i></a></span></div>').insertAfter('.' + contact_type + ':last');

            return false;
        }

        $(document).on('click', '.create', function(e){
            e.preventDefault();
            create($(this));
            // console.log('oks!');
        });

        $(document).on('click', '.remove', function(e){

            e.preventDefault();

            var target = $(this).data('target-id');
            var item = $(this).data('item-id');

            // console.log(target);

            bootbox.confirm("Are you sure you want to delete selected record(s)?", function(confirm) {
                    
                if( confirm ){
                       
                    $("#" + target ).fadeOut().remove();

                    if(item !== undefined){
                        
                        // console.log('send delete call');

                        data = {
                            'records': item,
                        };

                        $.ajax({
                            url: base_url + module.get('route') + '/delete',
                            type: "POST",
                            async: false,
                            data: data,
                            dataType: "json",
                            success: function (data) {
                                //do something here...
                            },
                        });
                    }
                    else{
                        // console.log('no item to delete');
                    }
                }
            });
        });