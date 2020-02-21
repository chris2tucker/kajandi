$(document).ready(function(){

    //display modal form for task editing
    $('.edit_title').click(function(){
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#title_name').val(data.title);
            $('#title_status').val(data.status);
			$('#title_id').val(data.id);
            $('#btn-title-save').val("update");

            $('#myModal-title').modal('show');
        }) 
    });

    //display modal form for creating new task
    $('#button-add-title').click(function(){
        $('#btn-title-save').val("add");
        $('#frmtitle').trigger("reset");
        $('#myModal-title').modal('show');
    });

    //delete task and remove it from list
    $('.delete-task').click(function(){
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

                $("#title_" + task_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-title-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('value')
            }
        })

        e.preventDefault(); 

        var formData = {
            title: $('#title_name').val(),
            status: $('#status').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-title-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#title_id').val();;
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

                var task = '<tr id="title_' + data.id + '"><td>' + data.title + '</td><td>' + data.status + '</td>';
                task += '<td><button class="btn btn-warning btn-xs btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-xs btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add"){ //if user added a new record
                    $('#title-list').append(task);
                }else{ //if user updated an existing record

                    $("#title_" + task_id).replaceWith( task );
                }

                $('#frmtitle').trigger("reset");

                $('#myModal-title').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});