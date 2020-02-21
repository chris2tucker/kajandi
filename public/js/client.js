
function getClientData(e  = false)
{

	var clientid = $('#clientid').val();
	var url = ajaxurl+'getclient';
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
		}
	})
	if(e)
		e.preventDefault();
	$.ajax({
		type: "GET",
		url: url + '/' + clientid,
		success: function (data) {
			
			$("#clientName").html(data.firstname);
			$("#companyname").html(data.company_name);
			$("#clientTelephone").html(data.telephone);
			$("#clientMobile").html(data.mobile);
			$("#website").html(data.website);
			$("#email").html(data.email);
			
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
}
$(document).ready(function(){





						$(function(){
							$("#clientid").change(function(e){
								getClientData(e);
							})
						});
					$(function(){
							
								
								var clientid = $('#clientid').val();
								var url = ajaxurl+'getclient';
								$.ajaxSetup({
									headers: {
										'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
									}
								})
								$.ajax({
									type: "GET",
									url: url + '/' + clientid,
									success: function (data) {
										
										$("#clientName").html(data.firstname);
										$("#companyname").html(data.company_name);
										$("#clientTelephone").html(data.telephone);
										$("#clientMobile").html(data.mobile);
										$("#website").html(data.website);
										$("#email").html(data.email);
										
									},
									error: function (data) {
										console.log('Error:', data);
									}
								});
							});
							
							


					
	
							
							
							
							
					
				
});

