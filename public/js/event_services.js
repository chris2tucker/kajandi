
$(document).ready(function(){
	servicetotal();
	var url = ajaxurl+'services';

    //delete task and remove it from list
    $(document).on('click','.delete_services',(function(e){
		e.preventDefault();
        var task_id = $(this).val();
		$.ajaxSetup({
		 	headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		})
        $.ajax({
			

            type: "DELETE",
            url: url + '/' + task_id,
            success: function (data) {
                $("#service_" + task_id).remove();
				servicetotal()
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }));

    //create new task / update existing task
    $(document).on('click',"#btn_addservices",(function (e) {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        e.preventDefault();
		
        var formData = {
            quantity : $('#quantity').val(),
			event_id : $('#eventid').val(),
            product: $('#product').val(),
			price: $('#price').val(),
			vat: $('#vat').val(),
        }
		var totalPrice =formData.quantity*formData.price;
	
		var rowVAT = totalPrice*(parseFloat(formData.vat)/100);
			if(isNaN(rowVAT)) {
				var rowVAT = 0;
				}
				
				
		var rowTotal = rowVAT+totalPrice;
		
     	var state = $('#btn_addservices').val();
        var type = "POST"; //for creating new resource
        
        var my_url = url;

        console.log(formData);
		
			
		

       $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {				
                if (state == "add"){ //if user added a new record
					var product = '<tr id="service_' + data.id + '">'+
								'<td class="">'+formData.quantity+'</td>'+
								'<td class="">'+formData.product+'</td>'+
								'<td class="">'+formData.price+'</td>'+
								'<td class="">'+totalPrice+'</td>'+
								'<td class="">'+formData.vat+' %</td>'+
								'<td class="">'+rowVAT+'</td>'+
								'<td class="">'+rowTotal+'</td>'+
								'<td class=""><button class="btn btn-danger btn-xs btn-delete delete_services" value="' + data.id + '">Delete</button></td>'+'</tr>';
                    $('#product_list').append(product).servicetotal();
                }else{ //if user updated an existing record

                    alert('somthing Wrong');
                }

                $('#services_form').trigger("reset");

               
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }));
	
	
	
	
	
	
	
	

});

function servicetotal()
{
	
	var total = 0
	$('.total').each(function(index, element) {
        total += parseFloat($(this).text());
    });
	$('#total').text(total);
}	

/*
	function myFunction() {
		
    var inpObj = document.getElementById("quantity");
	//alert(inpObj);
    if (inpObj.checkValidity() == false) {
        document.getElementById("demo").innerHTML = inpObj.validationMessage;
    } else {
        document.getElementById("demo").innerHTML = "Input OK";
    } 
}*/
	
