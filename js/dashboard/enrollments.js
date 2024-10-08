$(document).ready(function() {

    var enrollments = $('#enrollments').DataTable({
        language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_',
		},
        dom: "lBfrtip",
        ajax: {
            url: site_url + "/admin/enrollment-history",
            type: "GET"
        },
        columns: [
            // {
            //     data: "profile_photo_path",
            //     name: "profile_photo_path",
            //     render: function(d, t, r, m) {
            //         return `<img src="${d}" width="40" class="rounded-circle border" height="40" alt="">`
            //     }
            // },
            {
                data: "uname",
                name: "uname",
                render: function(d, t, r, m) {
                    return `<p>${r.firstname} ${r.lastname}</p>`
                }
            },
            {
                data: "email",
                name: "email",
                render: function(d, t, r, m) {
                    return ` ${d}`
                }
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "edit",
                name: "edit",
                render: function(d, t, r, m) {
                    return `
                    <button data-url="${site_url+('/admin/delete-user/'+r.cid)}" class="delete_student p-2 btn btn-danger text-light"><i class="fa fa-trash text-light"></i></button>
            <button data-url="${site_url+('/admin/edit-status/' + r.cid)}" class="change_status p-2 btn btn-primary text-light"
               title="${r.status==1? 'Enroll is opened click to Close':'Enroll is closed click to Open'}"><i class="fa ${r.status==0?'fa-check text-light':'fa-times text-light'}"></i></button>`
                }
            }

        ],
        columnDefs: [{
            targets: [0, 1, 2],
            searchable: true
        }],
        ordering: true
    })
    $(document).on('click', '.delete_student', function(e) {
        var url = $(this).data('url');
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
                $.get(url, function(response) {
                    if (response.success) {
                        alert("asd")
                        enrollments.ajax.reload();
                    }
                })

            }
        })
    })
    $(document).on('click', '.change_status', function(e) {
        var url = $(this).data('url');

        $.get(url, function(response) {
            if (response.success) {
                enrollments.ajax.reload();
            }
        })



    })

    $(document).on('change', 'input[name="is_archived"]', function() {
        modules.ajax.reload();
    })

    $(document).on('click', '.archive', function() {
        var id = $(this).data('id');
        var data = {
            '_token': csrf_token,
            'id': id
        }
        $.post(archiveModule, data, function(response) {
            if (response.success) {
                modules.ajax.reload();
            }
        })
    })
})