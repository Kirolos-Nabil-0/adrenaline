
function removeCode(e, id){
    
    // console.log(remove_code)
    Swal.fire({
        title: 'هل انت متأكد؟',
        text: "لن تقدر علي إستعادة هذا",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'إزالة'
    }).then((result) => {
        if (result.isConfirmed) {
            var data={
                '_token':csrf_token,
                'id':id,
            }
            $.post(remove_code,data,function(response){
                if(response.success){
                    $(`#code-${id}`).remove()
                    toastr.success('Code has been deleted successfully', 'Success');
                }
            })
        }
    })
}

let codes = []
let items = [];
function onMultipleCheck(id) {
    const index = codes.indexOf(id);

    if (index > -1) {
        codes.splice(index, 1);
    } else {
        codes.push(id);
    }

    console.log(codes);
}

function onMultipleDelete() {
    if (codes.length === 0) {
        toastr.error('Please select the codes first', 'Error');
    } else {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن يمكنك استعادة هذا",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'إزالة'
        }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    '_token': csrf_token,
                    'id': codes
                };

                $.post(remove_code_group, data, function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');

                        window.location.reload()
                    } else {
                        toastr.error('An error occurred while deleting codes.', 'Error');
                    }
                }).fail(function() {
                    toastr.error('Failed to communicate with the server.', 'Error');
                });
            }
        });
    }
}
function onDeleteAll(courseCodes) {
    const convertedCodes = JSON.parse(courseCodes);
    
    if (convertedCodes.length === 0) {
        toastr.error('No codes. Please add first.', 'Error');
        return;
    }

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن يمكنك استعادة هذا",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'إزالة'
    }).then((result) => {
        if (result.isConfirmed) {
            const codes = []; // Make sure to initialize codes here
            convertedCodes.forEach(code => {
                codes.push(code.id);
            });
            
            const data = {
                '_token': csrf_token,
                'id': codes
            };

            $.post(remove_code_group, data, function(response) {
                if (response.success) {
                    toastr.success(response.message, 'Success');
                    window.location.reload();
                } else {
                    toastr.error('An error occurred while deleting codes.', 'Error');
                }
            }).fail(function() {
                toastr.error('Failed to communicate with the server.', 'Error');
            });
        }
    });
}
