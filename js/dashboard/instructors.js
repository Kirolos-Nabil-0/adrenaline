let instructor;
$(document).ready(function(){
    instructors=$('#instructors').DataTable({
        dom:"lBfrtip",
        processeing:true,
        serverSide:true,
        destroy:true,
        ajax:{
            url:site_url+"/admin/instructors",
            type:"GET",
        },
        columns:[
            {
                data:"id",
                name:"id"
            },
            {
                data:"name",
                name:"name",
                render:function(d,t,r,m){
                    return `
                    <button class="btn" onclick="removeUser(${r.id})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="25" height="15">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                    ${r.firstname+" "+r.lastname}
                    `
                }
            },
            {
                data:"email",
                name:"email"
            },
            {
                data:"role",
                name:"role"
            },
            {
                data:"action",
                name:"action",
                render:function(d,t,r,m){

                    return  `
                    <script>
                    $('.select2').select2({
                        placeholder: 'Choose one',
                        searchInputPlaceholder: 'Search'
                    });
                    </script>
                    
                    <div class="d-flex align-items-center">
                    <select class="select2 select-role" id="select-role-${r.id}">
                        <option value="" ${r.role=='instructor'?'selected':''}>No Role</option>
                        <option value="instructor" ${r.role==null?'selected':''}>Instructor</option>
                    </select>
                    <button type="button" data-id="${r.id}" class="btn btn-primary save-role ml-2">Change</button>
                    </div>
                    `
                }
            },
            
        ],
        columnDefs:[{
            targets:[0,1,2,3,4],
            searchable:true
        }],
        ordering:false
    })
    $(document).on('click','.save-role',function(){
        var id=$(this).data('id');

        var role=$('#select-role-'+id).val();
        var data={
            '_token':csrf_token,
            'id':id,
            'role':role
        }
        $.post(update_user_role,data,function(response){
            if(response.success){
                instructors.ajax.reload();
            }
        })
        
    })
})
function removeUser(id){
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
            $.post(remove_user,data,function(response){
                if(response.success){
                    instructors.ajax.reload();
                }
            })
        }
    })
}

