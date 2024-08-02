$(document).ready(function() {
	
    $('#table_id').DataTable({

        dom: 'Bfrtip',
        responsive: true,
      
        // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

        buttons: [  
           
            {  
                extend: 'excel',  
           
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> '  
            },  
            {  
                extend: 'pdf',  
               
                text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> '  
            },  
            {  
                extend: 'copy',  
               
                text: '<i class="fa fa-files-o" aria-hidden="true"></i>'  
            },  
            {  
                extend: 'print',  
                
                text: '<i class="fa fa-print" aria-hidden="true"></i> '  
            }  
        ]  

    });
});
