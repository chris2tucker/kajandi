'use strict';
//  Author: ThemeREX.com
// 
//  This file is reserved for changes made by the user.
//  Your scripts should be placed here so you can be sure
//  it won't disappear after update
// 

(function($) {

$('.catagory_table').DataTable();
   // Your custom scripts here
$('#table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ],
       "processing": 'true'
    } );


 $('#example').DataTable();
})(jQuery);

