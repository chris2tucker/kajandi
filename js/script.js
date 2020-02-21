$(document).ready(function() {

	$('.productcategory').bind('change', function () {
		var val = $(this).val();

		url = ajaxurl+'admin/changecat';
		$.get(
			url,
      {val: val},
      function(data) {
        $('#subcat').html(data);
      });
	});


$('.getproduct').bind('change', function() {
	var val = $(this).val();

	url = ajaxurl+'admin/getproduct';

	$.get(
			url,
      {val: val},
      function(data) {
        $('.viewproduct').html(data);
      });
})

});
$('.login').click(function() {
	loginemail = $('.loginemail').val();
	loginpassword = $('.loginpassword').val();
	if (loginemail.length < 1) {
		$('.emailerror').show();
		$('.passworderror').hide();
	}else if(loginpassword.length < 1){
		$('.emailerror').hide();
		$('.passworderror').show();
	}else{
		url = ajaxurl+'loginuser'
		$.get(
			url,
      {loginemail: loginemail,
      	loginpassword: loginpassword},
      function(data) {
      	if (data == 'true') {
      		location.reload();
      	}else{
		$('.passworderror').hide();
		$('.emailerror').hide();
      		$('.loginformerror').show();
      	}
      });
	}
})

$('.createaccount').click(function() {
	name = $('.name').val();
	email = $('.email').val();
	password = $('.password').val();
	repeatpassword = $('.repeatpassword').val();
	phonenumber = $('.phonenumber').val();
	company_name = $('.company_name').val();
	about_company = $('.about_company').val();
	website_url = $('.website_url').val();
	cac_number = $('.cac_number').val();
	type_of_business = $('.type_of_business').val();
	year_of_existence = $('.year_of_existence').val();
	phone_of_MD_Chairman = $('.phone_of_MD_Chairman').val();
	email_of_MD_Chairman = $('.email_of_MD_Chairman').val();
	phone_of_contact_person = $('.phone_of_contact_person').val();
	email_of_contact_person = $('.email_of_contact_person').val();

	
	
 /*if(company_name.length < 1){

		$('.company_nameerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.about_companyerror').hide();
		$('.website_urlerror').hide();
		$('.cac_numbererror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();

	}else if (about_company.length < 1) {
		$('.about_companyerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.website_urlerror').hide();
		$('.cac_numbererror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (website_url.length < 1) {
		$('.website_urlerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (cac_number.length < 1) {
		$('.cac_numbererror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (type_of_business.length < 1) {
		$('.type_of_businesserror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (year_of_existence.length < 1) {
		$('.year_of_existenceerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (phone_of_MD_Chairman.length < 1) {
		$('.phone_of_MD_Chairmanerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (email_of_MD_Chairman.length < 1) {
		$('.email_of_MD_Chairmanerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if (phone_of_contact_person.length < 1) {
		$('.phone_of_contact_personerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_contact_personerror').hide();
	}
	else if (email_of_contact_person.length < 1) {
		$('.email_of_contact_personerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.cac_numbererror').hide();
		$('.website_urlerror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();

	}else */
	if (name.length < 1) {
		$('.nameerror').show();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
		$('.company_nameerror').hide();
		$('.about_companyerror').hide();
		$('.website_urlerror').hide();
		$('.cac_numbererror').hide();
		$('.type_of_businesserror').hide();
		$('.year_of_existenceerror').hide();
		$('.phone_of_MD_Chairmanerror').hide();
		$('.email_of_MD_Chairmanerror').hide();
		$('.phone_of_contact_personerror').hide();
		$('.email_of_contact_personerror').hide();
	}else if(email.length < 1){
		$('.emailerror1').show();
		$('.nameerror').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
	}else if (!isValidEmailAddress(email)) {
		$('.emailerror2').show();
		$('.nameerror').hide();
		$('.emailerror1').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
	}else if (phonenumber.length < 1) {
		$('.phoneerror').show();
		$('.nameerror').hide();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
	}else if(password.length < 1){
		$('.passworderror').show();
		$('.nameerror').hide();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.repeatpassworderror').hide();
		$('.passwordcorrespond').hide();
	}else if (repeatpassword.length < 1) {
		$('.repeatpassworderror').show();
		$('.nameerror').hide();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.passwordcorrespond').hide();
	}else if (password != repeatpassword) {
		$('.passwordcorrespond').show();
		$('.nameerror').hide();
		$('.emailerror1').hide();
		$('.emailerror2').hide();
		$('.phoneerror').hide();
		$('.passworderror').hide();
		$('.repeatpassworderror').hide();
	}
	else{
		url = ajaxurl+'signupuser'
		$.get(
			url,
      {name: name,
      	email: email,
      	password: password,
      	repeatpassword: repeatpassword,
      	phonenumber: phonenumber},
      function(data) {
      	if (data == 'true') {
      		location.reload();
      	}
      });
	}
})

function isValidEmailAddress(emailAddress) {

        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;

    return pattern.test(emailAddress);
        };

 $('.orderworkplace').change(function() {
 	val = $(this).val();
 	ordernumber = $(this).attr('id');
 	url = ajaxurl+'changeoderworkplace';
 	if (ordernumber.length > 0) {
 		$.get(
			url,
      {val: val,
      	ordernumber: ordernumber},
      function(data) {
      	
      });
 	}
 	
 })

 $('.ordersdetailsworkspcae').change(function() {
 	val = $(this).val();
 	order_id = $(this).attr('id');
 	url = ajaxurl+'changeoderdetailsworkplace';
 	if (order_id.length > 0) {
 		$.get(
			url,
      {val: val,
      	order_id: order_id},
      function(data) {
      	
      });
 	}
 	
 })

 $('.searchsite').bind('keyup', function() {
 	$('div').remove('.tt-dropdown-menu');
 	$('.tt-dropdown-menu').hide();
 	val = $(this).val();
 	url = ajaxurl+'searchsiterequest';
 	if (val != '') {
 		$.get(
			url,
      {val: val},
      function(data) {
      	$('.searchsite').after(data);
      });
 	}
 })


$('html body').click(function() {
 	$('.tt-dropdown-menu').hide();
})

$(document).ready(function(){
    if ($('#searchbox').length) {
        $('#searchbox').selectize({

            valueField: 'url',
            labelField: 'name',
            searchField: ['name', 'product_generic_name', 'part_number', 'other_information', 'key_specification', 'model_number', 'serial_number'],
            maxOptions: 10,
            options: [],
            create: false,

            render: {
                option: function (item, escape) {
                    if (item.product_generic_name == undefined) {
                        var generic_name = '';
                    } else {
                        generic_name = item.product_generic_name;
                    }
                    if (item.part_number == undefined) {
                        var part_number = '';
                    } else {
                        part_number = item.part_number;
                    }
                    if (item.other_information == undefined) {
                        var other_information = '';
                    } else {
                        other_information = item.other_information;
                    }
                    if (item.key_specification == undefined) {
                        var key_specification = '';
                    } else {
                        key_specification = item.key_specification;
                    }
                    if (item.model_number == undefined) {
                        var model_number = '';
                    } else {
                        model_number = item.model_number;
                    }
                    if (item.serial_number == undefined) {
                        var serial_number = '';
                    } else {
                        serial_number = item.serial_number;
                    }
                    return '<div style=padding: 0; margin: 0><img style=width:30px src="' + img_path + item.image + '">' + escape(item.name) + ' ' + escape(generic_name) + ' ' + escape(part_number) + ' ' + escape(key_specification) + ' ' + escape(other_information) + ' ' + escape(model_number) + ' ' + escape(serial_number) + '</div>';
                }
            },
            optgroups: [
                {value: 'product', label: 'Products'},
                {value: 'category', label: 'Categories'},
                {value: 'subcategory', label: 'Sub Categories'},
                {value: 'vendors', label: 'Vendors'}

            ],
            optgroupField: 'class',
            optgroupOrder: ['product', 'category', 'subcategory', 'vendors'],
            load: function (query, callback) {
                if (!query.length) return callback();
                console.log(query);
                $("#qq").val(query);
                $.ajax({

                    url: ajaxurl + '/searchautocomplete',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        console.log(res);
                        callback(res.data);
                    }
                });
            },
            onChange: function () {
                window.location = this.items[0];
            }
        });
    }
$("#btn").click(function(){
		var value=$("#qq").val();
		window.location=ajaxurl+'searchitems/'+value;
	});


});

$(document).ready(function(){
$('.iCheck-helper').click(function() {
	val = $('.form').serialize();
	var searchterm='';
	var category_level=$("#category_level").val();
	if(category_level=='subcategory'){
		url = ajaxurl+'searchsubcategory'
	}
	else if(category_level=='search'){
		url=ajaxurl+'searchterms';
		searchterm=$("#searchterm").val();

	}
	else{
		url = ajaxurl+'searchcategory'
	}
	category = $('#category').val();
	price = $('#price-slider').val();
	
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
})

$('.wishlist').click(function() {
	id = $(this).attr('id');
	
	url = ajaxurl+'addtowhishlist';
	$.get(
      url,
      {id : id},
      function(data) {

	$('.wishlist').addClass('wishlistadd');
      //	$('#data').html(data);
      });
})

$('.cardpayment').click(function() {
	 code = $('#code').val();
	 console.log(code);
	 alert(code);
	url = ajaxurl+'validatepayment';
	$.get(
      url,
      {code : code},
      function(data) {

      	window.location = ajaxurl+'stripe';
      });
})

$('.paymentcashless').click(function() {
	code = $('#code').val();
	url = ajaxurl+'validatecashless';
	$.get(
      url,
      {code : code},
      function(data) {
      	window.location = ajaxurl+'ordersummary/'+data;
      });
});


});

$(document).ready(function(){

$('#department').change(function(){
	var depart =  $(this).val();
	
	    $.ajax({
                url: ajaxurl+'/searchautocomplete',
                type: 'GET',
                dataType: 'json',
                data: {
                    depart: depart
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    window.location = ajaxurl
                }
            });
                    
        });
   });











