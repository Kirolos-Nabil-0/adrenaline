$(document).ready(function () {

    var modules = $('#modules').DataTable({
        dom: "lBfrtip",
        processeing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: site_url + "/admin/manage-modules",
            type: "GET",

        },
        columns: [{
                data: "id",
                name: "id"
            },

            {
                data: "name",
                name: "name"
            },

            {
                data: "price",
                name: "price",
                render: function (d, t, r, m) {
                    return `<input type="number" class="form-control w-25 d-inline-block" id="price-${r.id}" value="${d}" /><button class="mx-2 btn btn-success change" data-id="${r.id}">Change</button>`
                }
            },

        ],
        columnDefs: [{
            targets: [0, 1, 2],
            searchable: true
        }],
        ordering: false
    })



    $(document).on('click', '.change', function () {
        var id = $(this).data('id');
        var button = $(this);
        var module_price = $('#price-' + id).val();
        var data = {
            '_token': csrf_token,
            'module_id': id,
            'module_price': module_price
        }
        $.post(changeModulePrice, data, function (response) {
            if (response.success) {
                $(button).text('Done !');
                setTimeout(function () {
                    modules.ajax.reload();
                }, 500)
            }
        })
    })
    
})
