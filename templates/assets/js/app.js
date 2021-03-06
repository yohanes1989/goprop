var app = {
  init: function(context){
      // Javascript for Responsive Button
      $('.responsive-btn').click(function() {
          $('.main-menu-wrapper').toggle();
      });

      // Javascript for Owl Carousel
      $('#partner-carousel', context).owlCarousel({
          autoplay:true,
          autoplayTimeout:3000,
          smartSpeed: 500,
          items: 3,
          loop: false
      });

      $('#testimonial-carousel', context).owlCarousel({
          autoplay:true,
          autoplayTimeout:3000,
          smartSpeed: 500,
          items: 1,
          loop: true
      });

      $('#exclusiveProperty-list', context).owlCarousel({
          autoplay:true,
          autoplayTimeout:3000,
          smartSpeed: 500,
          items: 3,
          loop: true,
          nav:true,
          navText: [
              "<i class='fa fa-chevron-left icon-white'></i>",
              "<i class='fa fa-chevron-right icon-white'></i>"
          ]
      });

      $('#exclusivePropertyWidget-list', context).owlCarousel({
          autoplay:true,
          autoplayTimeout:3000,
          smartSpeed: 500,
          items: 1,
          loop: true,
          nav:true,
          navText: [
              "<i class='fa fa-chevron-left icon-white'></i>",
              "<i class='fa fa-chevron-right icon-white'></i>"
          ]
      });

      // Javascript for Image Preview when Upload Files
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#userform-pic img', context).attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }
      }

      $("#inputProfilePic", context).change(function(){
          readURL(this);
      });

      // Javascript for Price Range - Bootstrap Slider
      $('#inputPriceRange', context).slider({
          tooltip: 'hide'
      });
      $('#inputPriceRange', context).on('change', function(slideEvt){
          $('#price-from', context).text(accounting.formatNumber(slideEvt.value.newValue[0]));
          $('#price-to', context).text(accounting.formatNumber(slideEvt.value.newValue[1]));
      });
      $('#price-from', context).text(accounting.formatNumber($('#price-from', context).text()));
      $('#price-to', context).text(accounting.formatNumber($('#price-to', context).text()));

      //Replace Links
      $('[data-replace-href]', context).each(function(idx, obj){
          $(obj).attr('href', $(obj).data('replace-href'));
      });

      // Javascript for Lightbox - Colorbox
      $('.ajax_popup', context).fancybox({
          maxWidth	: 800,
          fitToView	: false,
          width		: 800,
          height		: 300,
          autoSize	: false,
          closeClick	: false,
          openEffect	: 'none',
          closeEffect	: 'none',
          afterShow: function(){
              app.init('#popup-wrapper');
          }
      });

      // Javascript for Counting Character in Textarea Field
      $('.textarea-group textarea', context).keyup(function () {
          var left = 300 - $(this).val().length;
          if (left < 0) {
              left = 0;
          }
          $('.textarea-count span', context).text(left);
      });

      //Share popup
      $('.popup-share-link', context).click(function(e){
          e.preventDefault();
          window.open($(this).attr('href'), "_blank", "toolbar=no, scrollbars=no, resizable=no, top=200, left=200, width=640, height=300");
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

      //Alert
      $('[data-confirm]', context).on('click', function(e){
          return confirm($(e.target).data('confirm'));
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

      //SOrt auto submit
      $('#sort.form-control', context).on('change', function(){
          window.location.href = $(this).find('option[value="'+$(this).val()+'"]').data('sort-url');
      });

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

      $('.packages-table').each(function(idx, obj){
          var $upFrontFee = 0;

          $('.property-price', obj).on('keyup', function(evt){
              var charCode = (evt.which) ? evt.which : event.keyCode;

              if (charCode == undefined || (charCode > 47 && charCode <58) || charCode == 45 || charCode == 32 || charCode == 9 || charCode == 8)
              {
                  $(this).val(accounting.formatNumber($(this).val()));
                  var price = accounting.unformat($(this).val());
                  var calculatedCommission = app.calculateCommission(price, $(this).data('package'));
                  var projectedFee = accounting.unformat($('.up-front-total[data-package="'+$(this).data('package')+'"]').text()) + calculatedCommission;
                  var conventionalFee = price * 2.5/100;

                  $('.projection-fee[data-package="'+$(this).data('package')+'"]').text(accounting.formatNumber(projectedFee));
                  $('.saving-amount[data-package="'+$(this).data('package')+'"]').text(accounting.formatNumber(conventionalFee - projectedFee));
              }
          });

          $('.property-price', obj).trigger('keyup');

          $('.feature-price', obj).on('change', function(){
              $upFrontFee = 0;
              $('.feature-price[data-package="'+$(this).data('package')+'"]:checked', obj).each(function(idy, objY){
                  $upFrontFee += parseFloat($(objY).data('price'));
              });

              if($upFrontFee == 0){
                  $('.up-front-total[data-package="'+$(this).data('package')+'"]').text('');
              }else{
                  $('.up-front-total[data-package="'+$(this).data('package')+'"]').text(accounting.formatNumber($upFrontFee));
              }

              $('.property-price[data-package="'+$(this).data('package')+'"]').trigger('keyup');
          });
      });

      // Javascript for Property Detail
      $("a.faqs-question", context).click(function() {
          if ($(this).hasClass("opened")) {
              $(this).removeClass("opened");
              $(this).children('.faqs-arrow').children('i').removeClass('fa-angle-up');
              $(this).children('.faqs-arrow').children('i').addClass('fa-angle-down');
              $(this).next(".faqs-answer").slideUp("fast");
              return false;
          } else {
              $("a.faqs-question").removeClass("opened");
              $(this).addClass("opened");
              $("a.faqs-question").children('.faqs-arrow').children('i').removeClass('fa-angle-up');
              $("a.faqs-question").children('.faqs-arrow').children('i').addClass('fa-angle-down');
              $(this).children('.faqs-arrow').children('i').removeClass('fa-angle-down');
              $(this).children('.faqs-arrow').children('i').addClass('fa-angle-up');
              $(".faqs-answer").slideUp("fast");
              $(this).next(".faqs-answer").slideDown("fast");
              return false;
          }
      });

      // Price Saving Calculator Widget
      if($('#price-saving-widget', context).length > 0){
          $('#price-saving-widget #inputPropertyPrice', context).slider({
              tooltip: 'always',
              formatter: function(data){
                  return accounting.formatNumber(data);
              }
          });

          $('#price-saving-widget #inputPropertyPrice', context).on('change', function(slideEvt){
              $('#price-saving-widget .saved-value', context).text(accounting.formatNumber(app.calculateSaving(slideEvt.value.newValue)));
          });
          $('#price-saving-widget .saved-value', context).text(accounting.formatNumber(app.calculateSaving($('#price-saving-widget #inputPropertyPrice', context).val())));

          $('.onlyNumber', context).each(function(idx, obj){
              $(obj).on('keypress', function(evt){
                  var charCode = (evt.which) ? evt.which : event.keyCode;

                  if ((charCode > 47 && charCode <58) || charCode == 45 || charCode == 46)
                  {
                      return true;
                  }
                  return false;
              });
          });
      }

      $('.formatNumberOnType', context).each(function(idx, obj){
          $(obj).on('keyup', function(evt){
              var charCode = (evt.which) ? evt.which : event.keyCode;

              if ((charCode > 47 && charCode <58) || charCode == 45)
              {
                  $(evt.target).val(accounting.formatNumber($(evt.target).val()));
              }
          });
          $(obj).val(accounting.formatNumber($(obj).val()));
      });

      //Saving Widget Calculator
      if($('#price-saving-calculator', context).length > 0){
          $('#price-saving-calculator .agent-commission', context).on('keyup', function(evt){
              var charCode = (evt.which) ? evt.which : event.keyCode;

              if ((charCode > 47 && charCode <58) || charCode == 45 || charCode == 46)
              {
                  $(evt.target).val($(evt.target).val().replace('%','') + '%');
              }
          });
          $('#price-saving-calculator .agent-commission', context).val($('#price-saving-calculator .agent-commission', context).val().replace('%','') + '%');

          $('#calculate-saved-price-btn', context).click(function(e){
              e.preventDefault();

              var $savedPercentage = $('#price-saving-calculator .agent-commission', context).val().replace('%','') - 1;
              var $savedValue = accounting.unformat($('#price-saving-calculator .property-price').val()) * $savedPercentage/100;
              $('#price-saving-calculator .saved-value').text(accounting.format($savedValue));
          });

          $('#calculate-saved-price-btn', context).click();
      }

      //Ajax Form
      $('.ajax-form', context).each(function(idx, obj){
          $(obj).submit(function(e){
              e.preventDefault();

              $.ajax(
                  $(obj).attr('action'),
                  {
                      method: $(obj).attr('method'),
                      data: $(obj).serialize(),
                      success: function(data){
                          $(obj).find('.form-group').removeClass('has-error');
                          $(obj)[0].reset();

                          if($(obj).find('.ajax-message').length < 1){
                              $(obj).append('<div class="ajax-message"></div>');
                          }

                          $(obj).append(data.message);
                      },
                      error: function(xhr){
                          $(obj).find('.form-group').removeClass('has-error');
                          for(var idx in xhr.responseJSON){
                              $(obj).find('[name="'+idx+'"]').parents('.form-group').addClass('has-error');
                          }
                      }
                  }
              );
          });
      });

      $(window).load(function(){
          $('#propertyDetailThumb-Slider', context).flexslider({
              animation: "slide",
              controlNav: false,
              animationLoop: false,
              slideshow: false,
              itemWidth: 150,
              itemMargin: 5,
              asNavFor: '#propertyDetail-Slider'
          });

          $('#propertyDetail-Slider', context).flexslider({
              animation: "slide",
              controlNav: false,
              animationLoop: false,
              slideshow: false,
              smoothHeight: true,
              sync: "#propertyDetailThumb-Slider"
          });
      });

      //Tab auto active
      $('.custom-tabs', context).each(function(idx, obj){
          $(obj).find('.nav-tabs li:first').addClass('active');
          $(obj).find('.tab-pane:first').addClass('active');
      });

      $('#datetimepicker12').datetimepicker({
          icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right'
          },
          format: 'DD/MM/YYYY LT',
          inline: true,
          sideBySide: true
      });
  },
    calculateCommission: function(price, package)
    {
        var commissionRule = commissionRules['package_'+package];
        var calculatedCommission = 0;

        for(key in commissionRule){
            var rules = key.split('-');
            var from = rules[0].trim();
            var to = rules[1].trim();
            var commission = commissionRule[key];

            if(from <= price){
                if(to == '~'){
                    break;
                }else{
                    if(to > price){
                        break;
                    }
                }
            }
        }

        if(commission.toString().indexOf('%') > -1){
            calculatedCommission = price * commission.toString().replace('%', '')/100;
        }else{
            calculatedCommission = commission;
        }

        if(calculatedCommission < 5000000){
            calculatedCommission = 5000000;
        }

        return calculatedCommission;
    },
    calculateSaving: function(propertyValue)
    {
        return propertyValue * 0.015;
    }
};

$(function() {
	$(document).ready(function() {
        app.init(document);
	});

    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function (event) {
        var that = $(this);

        that.on('click', onMapClickHandler);
        that.off('mouseleave', onMapMouseleaveHandler);
        that.find('iframe').css("pointer-events", "none");
    }

    var onMapClickHandler = function (event) {
        var that = $(this);

        // Disable the click handler until the user leaves the map area
        that.off('click', onMapClickHandler);

        // Enable scrolling zoom
        that.find('iframe').css("pointer-events", "auto");

        // Handle the mouse leave event
        that.on('mouseleave', onMapMouseleaveHandler);
    }

    // Enable map zooming with mouse scroll when the user clicks the map
    $('.maps-container').on('click', onMapClickHandler);
});