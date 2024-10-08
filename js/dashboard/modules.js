$(document).ready(function() {

    var modules = $('#modules').DataTable({
        dom: "lBfrtip",
        processeing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: site_url + "/admin/module",
            type: "GET",
            data: {
                'is_archived': function() { return $('input[name="is_archived"]:checked').val() }
            }
        },
        columns: [{
                data: "id",
                name: "id"
            },
            {
                data: "image",
                name: "image",
                render: function(d, t, r, m) {
                    if (d == null) {
                        return null
                    } else {
                        return `<img height="60" class="rounded-circle" width="60" src="${d}"/>`
                    }
                }
            },
            {
                data: "name",
                name: "name"
            },
            // {
            //     data: "is_archived",
            //     name: "is_archived",
            //     render: function(d, t, r, m) {
            //         var btnClass = '';
            //         var label = '';
            //         if (d == 0) {
            //             btnClass = 'btn-primary';
            //             label = 'Click to Archive'
            //         } else {
            //             btnClass = 'btn-secondary';
            //             label = 'Click to UnArchive'
            //         }
            //         return `<button data-id="${r.id}" class="archive btn ${btnClass}">${label}</button>`
            //     }
            // },
            {
                data: "auth_users",
                name: "auth_users",
                render: function (d, t, r, m) {
                    return `<button type="button" class="btn auth_users" data-users='${JSON.stringify(d)}' data-id="${r.id}"><i class="fa fa-plus"></i></button>`
                }
            },
            {
                data: "is_archived",
                name: "is_archived",
                render: function(d, t, r, m) {
                    var btnClass = '';
                    var label = '';
                    console.log(d)
                    if (d == 0) {
                        btnClass = 'btn-primary';
                        // label = 'Click to Archive'
                    } else {
                        btnClass = 'btn-secondary';
                        // label = 'Click to UnArchive'
                    }
                    return `<a href="${site_url+('/admin/module/'+r.id)}" class="text-decoration-none text-light bg-primary p-1"><i class="fa fa-edit"></i></a> <a href="${site_url+('/admin/deleteModule/'+r.id)}" class="text-decoration-none text-light bg-danger p-1 remove"><i class="fa fa-trash"></i></a>
                    <button data-id="${r.id}" class="archive btn ${btnClass} p-1"><i class="fa fa-archive"></i></button>
                    `
                }
            },
            
        ],
        columnDefs: [{
            targets: [0, 1, 2],
            searchable: true
        }],
        ordering: false
    })
    $(document).on('click', '.remove', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
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
                $.get(href, function(response) {
                    if (response.success) {
                        modules.ajax.reload();
                    }
                })

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
    $(document).on('click', '.auth_users', function () {
        var id = $(this).data('id');
        var selectedUsers = $(this).data('users');
        var usersContent = "";
        selectedUsers.forEach(u => {
            usersContent += `<tr>
            <td data-id="${u.id}">${u.id}</td>
            <td>${u.firstname} ${u.lastname}</td>
            <td><button type="button" class="delete-user btn btn-danger" data-user="${u.id}" data-module="${id}"><i class="fa fa-trash"></i></button></td>
            </tr>`
        })
        var all_users = "<option disabled value='' selected>Choose</option>";
        users.forEach(u => {
            u.exist = false;
            for (var i = 0; i < selectedUsers.length; i++) {
                if (u.id == selectedUsers[i].id) {
                    u.exist = true;
                    break;
                }
            }
            if (!u.exist) {

                all_users += `
                <option value="${u.id}" >${u.firstname} ${u.lastname}</option>
                `
            }
        })
        var selectUser = `
        <select class="form-control" id="select-${id}">${all_users}</select><button class="btn btn-success add-user ml-2" data-id="${id}" style="width:150px">Add</button>`;

        var html = `
        <div class="form-group p-2 d-flex">
        ${selectUser}
        </div>
        <table class="table" id="module-${id}">
        <thead>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        ${usersContent}
        </tbody>
        </table>
        `
        Swal.fire({
            title: 'Authorized Users',
            html: html,
            // icon: 'warning',
            showCancelButton: true,
            showConfirmButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).find('form.remove').submit();
            }
        })
    })

    $(document).on('click', '.add-user', function () {
        var id = $(this).data('id');
        var userId = $('#select-' + id).val();
        var data = {
            '_token': csrf_token,
            'module_id': id,
            'user_id': userId,
        }
        $.post(add_auth_user, data, function (response) {
            if (response.success) {
                $(`#module-${id} tbody`).append(`<tr>
                    <td data-id="${response.user.id}">${response.user.id}</td>
                    <td>${response.user.firstname} ${response.user.lastname}</td>
                    <td><button type="button" class="delete-user btn btn-danger" data-user="${response.user.id}" data-module="${id}"><i class="fa fa-trash"></i></button></td>
                </tr>`);
                $(`#select-${id} option`).each(function (e) {
                    if ($(this).attr('value') == response.user.id) {
                        $(this).remove();
                    }
                })
                modules.ajax.reload();
            }
        })
    })
    $(document).on('click', '.delete-user', function () {
        var id = $(this).data('module');
        var userId = $(this).data('user');
        var data = {
            '_token': csrf_token,
            'module_id': id,
            'user_id': userId,
        }
        $.post(delete_auth_user, data, function (response) {
            if (response.success) {
                $(`#module-${id} tbody tr`).each(function(e){
                    var tr=$(this);
                    $(this).children('td').each(function(c){
                        if($(this).data('id')==response.user.id){
                            $(tr).remove();
                        }
                    })
                })
                $(`#select-${id}`).append(`<option value="${response.user.id}">${response.user.firstname} ${response.user.lastname}</option>`)
                modules.ajax.reload();
            }
        })
    })
})