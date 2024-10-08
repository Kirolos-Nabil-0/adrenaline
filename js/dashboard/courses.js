$(document).ready(function() {




    var columns = [];
    columns.push({
        data: "id",
        name: "id",
    });
    columns.push({
        data: "name",
        name: "name"
    });
    if (currentUser.role == 'admin') {
        columns.push({
            data: "owner",
            name: "owner",
            render: function(d, t, r, m) {
                return d['firstname'] + " " + d['lastname'];
            }
        });
    }
    columns.push({
        data: "price_ar",
        name: "Price EGP",
        render: function(d, t, r, m) {
            if (r.free=="1") {
                return 'Free'
            } else {
                return r.price_ar + " EGP";
            }
        }
    })    
    columns.push({
        data: "price",
        name: "Price USD",
        render: function(d, t, r, m) {
            if (r.free=="1") {
                return 'Free'
            } else {
                return r.price_en + " USD";
            }
        }
    })
    columns.push({
        data: "discount_usd",
        name: "Discount USD",
        render: function(d, t, r, m) {
            if (r.free=="1") {
                return 'Free'
            } else {
                return r.discount_en + " USD";
            }
        }
    })
    columns.push({
        data: "discount_egp",
        name: "Discount EGP",
        render: function(d, t, r, m) {
            if (r.free=="1") {
                return 'Free'
            } else {
                return r.discount_ar + " EGP";
            }
        }
    })
    if (currentUser.role == 'admin') {
        function addmodulesOptions(mid) {
            let modulesOptions = "";
            for (var o of modules) {
                modulesOptions += `<option value="${o.id}" ${o.id==mid?'selected':''}>${o.name}</option>`
            }
            return modulesOptions;
        }
        // columns.push({
        //     data: "module",
        //     name: "module",
        //     render: function(d, t, r, m) {
        //         return `<form method="POST" action="${linkCourseModule}">
        //         ${csrf_input}
        //         <script>
        //         $('.select2-no-search').select2({
        //             minimumResultsForSearch: Infinity,
        //             placeholder: 'Choose one'
        //         });
        //         </script>
        //         <input type="hidden" name="course_id" value="${r.id}" />
        //         <div class="form-group row">
        //             <div class="col-9">
        //                 <select class="form-control select2-no-search" name="module_id">
        //                     <option ${r.module_id == null ? 'selected' : ''}
        //                         value="">Not selected</option>
        //                     ${addmodulesOptions(r.module_id)}
        //                 </select>
        //             </div>
        //             <div class="col-3">
        //                 <button class="btn btn-success">Link</button>
        //             </div>
        //         </div>
        //     </form>`
        //     }
        // })
    }
    // columns.push({
    //     data: "rate",
    //     name: "rate",
    //     render: function(d, t, r, m) {

    //         // $('#starRating-' + r.id).starRating({
    //         //     callback: function(value) {
    //         //         var url = site_url + "/admin/rateCourse/" + r.id + "/" + value;
    //         //         $.get(url, function(response) {
    //         //             if (response.success) {
    //         //                 courses.ajax.reload();
    //         //             }
    //         //         })

    //         //     }
    //         // })
    //         return `
    //         <div class="stars" id="stars-${r.id}">
    //         <ul class="starRating p-0 m-0" >
    //         <li data-value="1" data-id="${r.id}" class="${d==1?'active':''} starButton fa fa-star${d>=1&&d>0?'':' text-light'} text-warning" style="font-size: 18px;"></li>
    //         <li data-value="2" data-id="${r.id}" class="${d==2?'active':''} starButton fa fa-star${d>=2&&d>0?'':' text-light'} text-warning" style="font-size: 18px;"></li>
    //         <li data-value="3" data-id="${r.id}" class="${d==3?'active':''} starButton fa fa-star${d>=3&&d>0?'':' text-light'} text-warning" style="font-size: 18px;"></li>
    //         <li data-value="4" data-id="${r.id}" class="${d==4?'active':''} starButton fa fa-star${d>=4&&d>0?'':' text-light'} text-warning" style="font-size: 18px;"></li>
    //         <li data-value="5" data-id="${r.id}" class="${d==5?'active':''} starButton fa fa-star${d==5&&d>0?'':' text-light'} text-warning" style="font-size: 18px;"></li>
    //         </ul>
    //       </div>`
    //     }
    // })
    // columns.push({
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
    // });
    columns.push({
        data: "edit",
        name: "edit",
        render: function(d, t, r, m) {
            var deleteCourse = "";
            var archiveCourse = "";
            if (currentUser.role == 'admin') {
                deleteCourse = `<a href="${site_url+('/admin/deleteCourse/'+r.id)}" class="text-decoration-none bg-danger p-2 text-light remove"><i class="fa fa-trash"></i></a>`
                archiveCourse = `<button class="archive text-decoration-none bg-warning p-2 text-light border-0 btn-trasnparent" data-id="${r.id}"><i class="fa fa-archive"></i></button>`
            }
            return `
            <div class="dropdown">
                <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-trasnparent p-0"
                data-toggle="dropdown" id="dropdownMenuButton" type="button"><i class="fas fa-caret-down ml-1"></i></button>
                <div  class="dropdown-menu tx-13 p-2" style="min-width:100px">
                    <div class="d-flex justify-content-between">
                    <a href="${site_url + ('/admin/edit-course/' + r.id)}" class="text-decoration-none bg-primary p-2 text-light"><i class="fa fa-edit"></i></a> 
                    ${deleteCourse}
                    ${archiveCourse}
                    </div> 
                </div>
            </div>
            `
        }
    });

    var courses = $('#example1').DataTable({
        processeing: true,
        serverSide: true,
        destroy: true,
        language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			lengthMenu: '_MENU_',
		},
        ajax: {
            url: site_url + "/admin/courses-page",
            type: "GET",
            data: {
                'is_archived': function() {
                    return $('input[name="is_archived"]:checked').val()
                }
            }
        },
        columns: columns,
        columnDefs: [{
            targets: [0, 1, 2],
            searchable: true
        }],
        ordering: false
    })
    $(document).on('click', '.remove', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        // swal({
		// 	title: "Are you sure you want to delete this course?",
		// 	text: "You will not be able to recover this again",
		// 	type: "warning",
		// 	showCancelButton: true,
		// 	confirmButtonText: 'Exit',
        //     cancelButtonColor: '#d33',
        //     confirmButtonColor: '#3085d6',
		// 	cancelButtonText: 'Remove'
		// })
        
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
                        courses.ajax.reload();
                    }
                })

            }
        })
    })

    $(document).on('change', 'input[name="is_archived"]', function() {
        courses.ajax.reload();
    })

    $(document).on('click', '.archive', function() {
        var id = $(this).data('id');
        var data = {
            '_token': csrf_token,
            'id': id
        }
        $.post(archiveCourse, data, function(response) {
            if (response.success) {
                courses.ajax.reload();
            }
        })
    })


    $(document).on('click', '.starButton', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');
        var url = site_url + "/admin/rateCourse/" + id + "/" + value;
        $.get(url, function(response) {
            if (response.success) {
                courses.ajax.reload();
            }
        })
    })

    $(document).on('mouseenter', '.starButton', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');
        $(`#stars-${id} li`).each(function(e) {
            if ($(this).data('value') <= value) {
                $(this).removeClass('text-light').addClass('fa-star')
            }
        })
    })

    $(document).on('mouseleave', '.starButton', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');
        var activeValue = $(`#stars-${id} li.active`).data('value');
        if (!activeValue) {
            activeValue = 0;
        }
        $(`#stars-${id} li`).each(function(e) {
            if (!$(this).hasClass('active') && $(this).data('value') > activeValue) {
                $(this).removeClass('').addClass('text-light')
            }
        })
    })
})