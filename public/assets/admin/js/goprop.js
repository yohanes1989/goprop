(function($){
    var goPropApp = {
        'init': function(context){
            if(context == undefined){
                context = document;
            }

            $('.open-modal', context).click(function(e){
                e.preventDefault();

                $('#modal-wrapper .modal-title').text('Loading');
                $('#modal-wrapper .modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
                $('#modal-wrapper').modal('show');

                $.ajax(
                    $(this).attr('href'),
                    {
                        success: function(data){
                            $realMeat = $(data).find('#real-meat');

                            $('#modal-wrapper .modal-title').text($realMeat.find('.block-title:eq(0)').text());
                            $realMeat.find('.block-title:eq(0)').remove();

                            $('#modal-wrapper .modal-body').html($realMeat);

                            goPropApp.init('#modal-wrapper .modal-body');
                            $('.select-chosen', context).chosen();
                        }
                    }
                );
            });

            $('.btn-confirm', context).click(function(e){
                return confirm('Are you sure to do this action?');
            });

            $('input[type="text"][data-autocomplete]', context).each(function(idx, obj){
                $(obj).wrap('<div class="ui-front"></div>')
                $(obj).after('<i class="fa fa-spinner fa-spin" style="display: none;"></i>');

                $(obj).autocomplete({
                    source: $(obj).data('autocomplete'),
                    minLength: 2,
                    select: function(event, ui){
                        $(obj).val(ui.item.email);
                    },
                    search: function(){
                        $(obj).next().show();
                    },
                    response: function(){
                        $(obj).next().hide();
                    }
                });
            });

            // Javascript for Address options
            $('.form-address-selector-province', context).on('change', function(){
                $('.form-address-selector-city option:eq(0)', context).attr('selected', 'selected');
                $('.form-address-selector-subdistrict option:eq(0)', context).attr('selected', 'selected');

                $.ajax(global_vars.base_path + '/address_helper/get/cities', {
                    method: 'GET',
                    data: {
                        'province_id': $(this).val(),
                        'default_label': $(this).data('default-label')
                    },
                    success: function(data){
                        $('.form-address-selector-city', context).empty();
                        var value;
                        for(idx in data){
                            if(idx == 0){
                                value = '';
                            }else{
                                value = idx;
                            }
                            $('.form-address-selector-city', context).append('<option value="' + value + '">' + data[idx] + '</option>');
                        }
                    }
                });
            });

            $('.form-address-selector-city', context).on('change', function(){
                $.ajax(global_vars.base_path + '/address_helper/get/subdistricts', {
                    method: 'GET',
                    data: {
                        'city_id': $(this).val(),
                        'default_label': $(this).data('default-label')
                    },
                    success: function(data){
                        $('.form-address-selector-subdistrict', context).empty();
                        var value;
                        for(idx in data){
                            if(idx == 0){
                                value = '';
                            }else{
                                value = idx;
                            }
                            $('.form-address-selector-subdistrict', context).append('<option value="' + value + '">' + data[idx] + '</option>');
                        }
                    }
                });
            });

            //Submit on change
            $('.submit-on-change', context).on('change', function(){
                $(this).parents('form').submit();
            });

            //Remove Image
            $('.profile-picture', context).each(function(idx, obj){
                $(obj).find('.remove-image').click(function(e){
                    e.preventDefault();
                    $(obj).find('a, img').remove();
                    $(obj).find('input[name="remove_profile_picture"]').val(1);
                });
            });

            // Initialize Datetimepicker for Bootstrap
            $('.input-datetimepicker').datetimepicker({
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up:   'fa fa-chevron-up',
                    down: 'fa fa-chevron-down'
                },
                format: 'YYYY-MM-DD HH:mm'
            });

            //Scroll
            $('.scrollDiv',context).each(function(idx, obj){
                $(obj).slimScroll({
                    height: $(obj).data('scrollHeight'),
                    color: '#000000',
                    size: '3px',
                    touchScrollStep: 100,
                    distance: '0',
                    start: 'bottom'
                });
            });

            //Dependant field
            $('*[data-field-dependent]', context).hide();

            $('*[data-field-dependent]', context).each(function(idx, obj){
                var $dependentParentField = $('[name="'+$(obj).data('field-dependent').split('|')[0]+'"]');
                var $dependentValue = $(obj).data('field-dependent').split('|')[1];

                $dependentParentField.on('change', function(e){
                    if($(this).val() == $dependentValue){
                        $(obj).show();
                    }else{
                        $(obj).hide();
                    }
                });
                $dependentParentField.change();
            });

            //Autocomplete
            $('input[type="text"][data-autocomplete]', context).each(function(idx, obj){
                $(obj).wrap('<div class="ui-front"></div>')
                $(obj).after('<i class="fa fa-spinner fa-spin" style="display: none;"></i>');

                $(obj).autocomplete({
                    source: $(obj).data('autocomplete'),
                    minLength: 2,
                    select: function(event, ui){
                        $(obj).val(ui.item.email);
                    },
                    search: function(){
                        $(obj).next().show();
                    },
                    response: function(){
                        $(obj).next().hide();
                    }
                });
            });
        }
    };

    goPropApp.init();
})(jQuery);