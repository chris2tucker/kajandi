/// <reference path="jquery-1.12.3.js" />

(function ($) {
    var list = [];

    /* function to be executed when product is selected for comparision*/
jQuery.fn.extend({
    toggleText: function (a, b){
        var that = this;
            if (that.text() != a && that.text() != b){
                that.text(a);
            }
            else
            if (that.text() == a){
                that.text(b);
            }
            else
            if (that.text() == b){
                that.text(a);
            }
        return this;
    }
});
    $(document).on('click', '.addToCompare', function () {
        $(".comparePanle").show();
        $(this).toggleText('Added', 'Compare');
        //$(this).parents(".product").toggleClass("selected");
        var productID = $(this).parents('.product').attr('data-title');
            
        var inArray = $.inArray(productID, list);
        console.log(inArray);
        if (inArray < 0) {
            if (list.length > 1) {
                $("#WarningModal").modal('show');
                /*$("#warningModalClose").click(function () {
                    $("#WarningModal").hide();
                }); */
                $(this).text("Compare");
               // $(this).parents(".product").toggleClass("selected");
                return;
            }

            if (list.length < 3) {
                list.push(productID);

                var displayTitle = $(this).parents('.product').attr('data-id');
                console.log(displayTitle);
                var image = $(this).closest('.product').find('img').attr('src');
                console.log(image);
                $(".comparePan").append('<div id="kamoke'+productID+'" class="relPos titleMargin col-sm-3"><div class="titleMargin" style="text-align:center;border-radius:10px;background-color: white !important;"><a class="selectedItemCloseBtn" style="float: right;cursor: pointer;font-size:20px;">&times</a><img src="' + image + '" alt="image" style="height:100px;width:50%;"/><p id="' + productID + '" class="titleMargin1">' + displayTitle + '</p></div></div>');
            }
        } else {
            list.splice($.inArray(productID, list), 1);
            var prod = productID.replace(" ", "");
            console.log(prod);
            $('#kamoke'+prod).remove();
            hideComparePanel();

        }
        if (list.length > 1) {

            $(".cmprBtn").addClass("active");
            $(".cmprBtn").removeAttr('disabled');
        } else {
            $(".cmprBtn").removeClass("active");
            $(".cmprBtn").attr('disabled', '');
        }

    });
    /*function to be executed when compare button is clicked*/
    $(document).on('click', '.cmprBtn', function () {
        if ($(".cmprBtn").hasClass("active")) {
            /* this is to print the  features list statically*/
            $(".contentPop").append('<div class="col-sm-3 compareItemParent relPos" style="padding:0;">' + '<ul class="comparison_product compare_product">' + '<li class=" relPos compHeader"><p class="w3-display-middle">Features</p></li>' + '<li style="min-height:100px;">Name</li>' + '<li style="min-height:100px;">Category</li>' + '<li style="min-height:100px;">Modal</li>' + '<li style="min-height:100px;">Manufacturer</li>' + '<li >Price</li>' +'<li>Instance Price</li>' +'<li>15 Days Price</li>'+'<li>30 Days Price</li>'+'<li>Source</li>'+'<li>Condition</li>'+'<li>Location</li>'+'<li>Vendor</li></ul>' + '<li>Moldel Number</li></ul>' +'<li>Serial Number</li></ul>' +  '</div>');

            for (var i = 0; i < list.length; i++) {
                /* this is to add the items to popup which are selected for comparision */
                product = $('.product[data-title="' + list[i] + '"]');
                var image = $('[data-title=' + list[i] + ']').find(".product-img-primary").attr('src');
                var title = $('[data-title=' + list[i] + ']').attr('data-id');
                /*appending to div*/
                $(".contentPop").append('<div class="col-sm-4 compareItemParent relPos" style="padding:0;" >' + '<ul class="comparison_product">' + '<li class="compHeader"><img src="' + image + '" class="compareThumb" style="width:60%;"></li>' + '<li style="min-height: 100px;">' + title + '</li>' + '<li style="min-height:100px;">' + $(product).data('category') + '</li>' + '<li style="min-height:100px;">' + $(product).data('model') + '<li style="min-height: 100px;">' + $(product).data('manufactoror') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('price') + '</li>' + '<li style="min-height: 42px;">' + $(product).data('instance')+'</li>' + '<li style="min-height: 42px;">' + $(product).data('within15') + '</li>' + '<li style="min-height: 42px;">' + $(product).data('within30') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('source') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('condition') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('location') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('vendor') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('model') + '</li>'+ '<li style="min-height: 42px;">' + $(product).data('serial') + '</li></ul>' + '</div>');
            }
            $('.comparePanle').hide();
            $('.modPos').modal('show');
        }
        $(".modPos").show();
    });

    /* function to close the comparision popup */
    $(document).on('click', '.closeBtn', function () {
        $(".contentPop").empty();
        $(".comparePan").empty();
        $(".comparePanle").hide();
        $(".modPos").hide();
        $(".selectProduct").removeClass("selected");
        $(".cmprBtn").attr('disabled', '');
        list.length = 0;
        $(".addToCompare").text("Compare");
    });

    /*function to remove item from preview panel*/
    $(document).on('click', '.selectedItemCloseBtn', function () {
        console.log('here');
        var test = $(this).siblings("p").attr('id');
        $('[data-title=' + test + ']').find(".addToCompare").click();
        hideComparePanel();
    });

    function hideComparePanel() {
        if (!list.length) {
            $(".comparePan").empty();
            $(".comparePanle").hide();
        }
    }
})(jQuery);