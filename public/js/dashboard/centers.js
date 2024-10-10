let centers;
$(document).ready(function(){
    centers = $('#centers_table').DataTable({
        dom: "lBfrtip",
        processing: true,  // Correct spelling
        serverSide: true,
        destroy: true,
        ajax: {
            url: site_url + "/admin/centers",
            type: "GET",
            error: function(xhr, error, thrown) {
                console.error("AJAX Error: ", error);
            }
        },
        columns: [
            { data: "id", name: "id" },
            { data: "firstname", name: "name" },
            { data: "email", name: "email" }
        ],
        
        columnDefs: [{
            targets: [0, 1, 2],
            searchable: true
        }],
        ordering: false
    });
});
