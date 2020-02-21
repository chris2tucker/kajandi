$(document).ready(function(){
	$("#start-time").on('change',(function(){
		$("#actstarttime").attr('value',$(this).val());
	}))
	
	$("#arival-time").on('change',(function(){
		$("#arrivaltime").attr('value',$(this).val());
	}))
	$("#finish-time").on('change',(function(){
		$("#finishtime").attr('value',$(this).val());
	}))
	
	$("#finish-time").on('load','change',function(){
       $("#finishtime").attr('value',$(this).val());
    });
	
/*-------------------------------------------------------------------------------------*/	

var url = ajaxurl+'bookact';

     $(document).on('click','.edit_bookact',function(e){
		e.preventDefault();
		
        var task_id = $(this).val();
	 

        $.get(url + '/' + task_id, function (data) {
            
            $('#performerid').val(data.performer_id);
            $('#act_required').val(data.act_required);
			$('#dresscode').val(data.dresscode );
			$('#fee_performer').val(data.fee_performer);
			$('#arrivaltime').val(data.arrivaltime);
			$('#actstarttime').val(data.starttime);
			$('#finishtime').val(data.finishtime );
			$('#contactname').val(data.contact_name);
			$('#contactno').val(data.contact_no );
			$('#note-perf-contact').val(data.note_performer_contract);
			$('#note_perf_record').val(data.note_performer_record);
			$('#bookact_id').val(data.id);
            $('#btn_add_bookact').val("update");
				
            
        }) 
    });
	
	
	
	
  $(document).on('click','.delete_bookact',function(e){
	  
        var task_id = $(this).val();
		
		$.ajaxSetup({
		 	headers: {
				'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
			}
		})
		    e.preventDefault(); 
        $.ajax({
			

            type: "DELETE",
            url: url + '/' + task_id,
            success: function (data) {
                console.log(data);

                $("#bookact_" + task_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });



 $(document).on('click','#btn_add_bookact',function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        })

        e.preventDefault(); 
           
		  
		  
        var formData = {
			
          	act_eventid     : $('#eventid').val(),
		    performer_id  : $('#performerid').val(),
       		act_required  : $('#act_required').val(),
			dresscode     : $('#dresscode').val(),
			fee_performer : $('#fee_performer').val(),
			arrivaltime	  : $('#arrivaltime').val(),
			starttime : $('#actstarttime').val(),
			finishtime   : $('#finishtime').val(),
			contact_name  : $('#contactname').val(),
			contact_no    : $('#contactno').val(),
			note_performer_contract : $('#note-perf-contact').val(),
			note_performer_record  : $('#note_perf_record').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn_add_bookact').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#bookact_id').val();
		
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

                var task = '<div class="row"><div class="col-xs-3 col-sm-2 pb10"><span class="badge bg-default"><span class="visible-xs">ENQ</span><span class="hidden-xs">ENQUIRY</span></span></div><div class="col-xs-9 col-sm-7 pb10" >'+
				'<li><strong>' + data.contact_name + '</strong>|' + data.starttime + '|' + data.finishtime + '|' + data.fee_performer  + '</li></div><div class="col-xs-12 col-sm-3 pr0 pl10"><a  class="btn btn-block btn-flickr btn-xs pull-right mb5" href="#"><em class="fa fa-file-pdf-o mr5"></em>GENERATE CONTRACT</a></div></div>';
				
					task += '<div class="row"><div class="col-xs-12 col-sm-9 mt0 pt0"><h5><strong>Event Information</strong></h5><p>'+
					'Arrival Time:' + data.arrivaltime + '<br>'+
					'Dress Code:' + data.dresscode + '<br>'+
					'Internal Notes:' + data.note_performer_record + '<br>'+
					'Performer Contract Notes:' + data.note_performer_contract + '<br>'+
					'</p></div>'+
					'<div class="col-xs-12 col-sm-3 pr0 pl10">'+
					
					'<button class="btn btn-block btn-info btn-xs pull-right edit_bookact" value="' + data.id + '"><em class="ti-pencil-alt mr5"></em>Edit</button>';
					task += '<button class="btn btn-block btn-danger btn-xs pull-right mb20 delete_bookact btn_delete" value="' + data.id + '"><em class="fa fa-trash mr5"></em>Delete</button><hr></div>';

                if (state == "add"){ //if user added a new record
                    $('#bookact_list').append(task);
                }else{ //if user updated an existing record

                    $("#bookact_" + task_id).html( task );
                }

                $('#act_form').trigger("reset");

             
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
		
		
    });
       
 

	
	
 $(document).on('click','.edit_bookact',function() { 
    if ($("#btn_add_bookact").text() == "ADD FREELANCER TO JOB") { 
        $("#btn_add_bookact").text("UPDATE FREELANCER TO JOB"); 
    } else { 
        $(this).text("Edit"); 
    }; 
});
$(document).on('click','#btn_add_bookact',function() { 
    if ($(this).text() == "UPDATE FREELANCER TO JOB") { 
        $(this).text("ADD FREELANCER TO JOB"); 
    } else { 
        $(this).text("ADD FREELANCER TO JOB"); 
    }; 
});
	

	
	
	
	
	
						
});



