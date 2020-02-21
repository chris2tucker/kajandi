$(document).ready(function(){
	var url = ajaxurl+'/currancy';
    //display modal form for task editing
    $('.edit_currancy').click(function(){
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#currancy_name').val(data.currancy);
          
			$('#currancy_id').val(data.id);
            $('#btn-currancy-save').val("update");

            $('#myModal-currancy').modal('show');
        }) 
    });

    //display modal form for creating new task
    $('#button-add-currancy').click(function(){
        $('#btn-currancy-save').val("add");
        $('#form-currancy').trigger("reset");
        $('#myModal-currancy').modal('show');
    });

    //delete task and remove it from list
    $('.delete_currancy').click(function(){
        var task_id = $(this).val();
		$.ajaxSetup({
		 	headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
			}
		})
        $.ajax({
			

            type: "DELETE",
            url: url + '/' + task_id,
            success: function (data) {
                console.log(data);

                $("#currancy_" + task_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-currancy-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
            }
        })

        e.preventDefault(); 

        var formData = {
            currancy: $('#currancy_name').val(),
            
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-currancy-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#currancy_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + task_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var task = '<tr id="currancy_' + data.id + '"><td>' + data.currancy + '</td>' ;
                task += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete_currancy" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#currancy-list').append(task);
                }else{ //if user updated an existing record

                    $("#currancy_" + task_id).replaceWith( task );
                }

                $('#form-currancy').trigger("reset");

                $('#myModal-currancy').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});