$(document).ready(function(){
		
	var url = ajaxurl+'event';
    //display modal form for task editing
    $('.edit_country').click(function(){
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#event_title').val(data.event_title);
            $('#client').val(data.client_id);
			$('#event_id').val(data.id);
            $('#btn-event-save').val("update");

            $('#myModal').modal('show');
        }) 
    });

    //display modal form for creating new task
    $('#btn-event-add').click(function(){
        $('#myModal').modal('show');
    });

    //delete task and remove it from list
    $('.delete-task').click(function(){
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
                console.log(data);

                $("#country_" + task_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-event-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        e.preventDefault(); 

        var formData = {
			
			 	
            event_title: $('#event_title').val(),
            client_id  : $('#client-list').val(),
			
        }

        var type = "POST"; //for creating new resource

        console.log(formData);

        $.ajax({

            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {

                if (data.id){ //if user added a new record
                    window.location = 'http://localhost/mybookingmanager/public/events/'+data.id+'/edit';
                }else{ //if user updated an existing record
					alert('something wrong while adding event');
                }

                $('#frmTasks').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});