"use strict";



var val = '';
var category = '';
var price = '';
var url = '';
//  i Check plugin
$('.i-check, .i-radio').iCheck({
    checkboxClass: 'i-check',
    radioClass: 'i-radio'
});

// price slider
$("#price-slider").ionRangeSlider({
    min: 1,
    max: 100000000,
    type: 'double',
    prettify: false,
    hasGrid: false,
    onStart: updateInputs,
    onChange: updateInputs
});

function updateInputs() {
    // body...
    var searchterm='';
    val = $('.form').serialize();
    category = $('#category').val();
    price = $('#price-slider').val();
    var category_level=$("#category_level").val();
   
    if(category_level=='subcategory'){
        url = ajaxurl+'/searchsubcategory'
    }
    else if(category_level=='search'){
        url=ajaxurl+'searchterms';
        searchterm=$("#searchterm").val();
    }
    else{
    url = ajaxurl+'/searchcategory'
}
    $('body').addClass('overlay');
    $.get(
      url,
      {val : val,
        category : category,
        search:searchterm,
        price : price
      },
      function(data) {
        $('body').removeClass('overlay');
        $('#data').html(data);
      });
}

$('#jqzoom').jqzoom({
    zoomType: 'standard',
    lens: true,
    preloadImages: false,
    alwaysOn: false,
    zoomWidth: 460,
    zoomHeight: 460,
    // xOffset:390,
    yOffset: 0,
    position: 'left'
});
$('.jqzoom').jqzoom({
    zoomType: 'standard',
    lens: true,
    preloadImages: false,
    alwaysOn: false,
    zoomWidth: 460,
    zoomHeight: 460,
    // xOffset:390,
    yOffset: 0,
    position: 'left'
});


$('.form-group-cc-number input').payment('formatCardNumber');
$('.form-group-cc-date input').payment('formatCardExpiry');
$('.form-group-cc-cvc input').payment('formatCardCVC');

// Register account on payment
$('#create-account-checkbox').on('ifChecked', function() {
    $('#create-account').removeClass('hide');
});

$('#create-account-checkbox').on('ifUnchecked', function() {
    $('#create-account').addClass('hide');
});

$('#shipping-address-checkbox').on('ifChecked', function() {
    $('#shipping-address').removeClass('hide');
});

$('#shipping-address-checkbox').on('ifUnchecked', function() {
    $('#shipping-address').addClass('hide');
});



$('.owl-carousel').each(function(){
  $(this).owlCarousel();
});



// Lighbox gallery
$('#popup-gallery').each(function() {
    $(this).magnificPopup({
        delegate: 'a.popup-gallery-image',
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});

// Lighbox image
$('.popup-image').magnificPopup({
    type: 'image'
});

// Lighbox text
$('.popup-text').magnificPopup({
    removalDelay: 500,
    closeBtnInside: true,
    callbacks: {
        beforeOpen: function() {
            this.st.mainClass = this.st.el.attr('data-effect');
        }
    },
    midClick: true
});



$(".product-page-qty-plus").on('click', function() {

    var currentVal = parseInt($(this).prev(".product-page-qty-input").val(), 10);
    var maxvalue = parseInt($(this).prev(".product-page-qty-input").attr('max'), 10);
    if (!currentVal || currentVal == "" || currentVal == "NaN") currentVal = 0;
if(maxvalue<=currentVal){
    return false;
}else{
    $(this).prev(".product-page-qty-input").val(currentVal + 1);
}
});

$(".product-page-qty-minus").on('click', function() {
    var currentVal = parseInt($(this).next(".product-page-qty-input").val(), 10);
    var minValue = parseInt($(this).next(".product-page-qty-input").attr('min'), 10);
    if (currentVal == "NaN") currentVal = 1;
    if (currentVal > 1 && minValue<currentVal) {
        $(this).next(".product-page-qty-input").val(currentVal - 1);
    }
    else{
        return false;
    }
});