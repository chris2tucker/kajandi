$(document).ready(function(){

	
/*-------------------------------------------------------------------------------------*/	

var url = ajaxurl+'gigsource';

     $(document).on('click','.edit_gigsource',function(e){
		e.preventDefault();
		
        var gig_id = $(this).val();
	

        $.get(url + '/' + gig_id, function (data) {
            //success data
            console.log(data);
            $('#addoption_gig').val(data.option_gig);
			$('#gigsorce_id').val(data.id);
            $('#btn_addoption').val("update");
				
            
        }) 
    });
	
	
	
	
  $(document).on('click','.delete_source',function(e){
	  
        var gig_id = $(this).val();
		
		$.ajaxSetup({
		 	headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		})
		    e.preventDefault(); 
        $.ajax({
			

            type: "DELETE",
            url: url + '/' + gig_id,
            success: function (data) {
                console.log(data);

                $("#gigsource_" + gig_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });



 $(document).on('click','#btn_addoption',function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        e.preventDefault(); 
           
		  
		  
        var formData = {
			
          	/*act_eventid     : $('#eventid').val(),*/
		    option_gig   : $('#addoption_gig').val(),
			user_id    : $('#userid').val(),
       	
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn_addoption').val();

        var type = "POST"; //for creating new resource
        var gig_id = $('#gigsorce_id').val();
		
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + gig_id;
        }

        console.log(formData);
 $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
				
					 var task = '<tr id="gigsource_' + data.id + '"><td>' + data.option_gig + '</td>';
                task += '<td><button class="btn btn-warning btn-xs btn-detail edit_gigsource" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete_source" value="' + data.id + '">Delete</button></td></tr>';
                
                if (state == "add"){ //if user added a new record
                    $('#gigsource-list').append(task);
                }else{ //if user updated an existing record

                    $("#gigsource_" + gig_id).replaceWith( task );
                }

                $('#gig_source_form').trigger("reset");

             
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		
		
    });
       
 
/*----------------Entertainer----------------------------------*/
	
	
       

	
	
	
	
	
						
});