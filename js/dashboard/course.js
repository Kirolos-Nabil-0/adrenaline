$(document).ready(function () {

    $(document).on('click', '.removesection,.removeLesson', removeItem)
    $('#editCourse').on('click', function (e) {
        e.preventDefault();
        $('#editCourseForm').submit();
    })
    // $('.select2').select2();
    function removeItem() {

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
                $(this).find('form.remove').submit();
            }
        })
    }
    if ($('#freecou').is(':checked')) {
        $('#price').prop("readonly", true);
    }
    $("#freecou").click(function () {
        $('#price').attr('readonly', function (index, attr) {
            return attr == 'readonly' ? null : $('#price').removeAttr('readonly');
        });
        $('#price').val('');

    });
    // $('.select2').select2({
    //     placeholder: 'Choose one',
    //     searchInputPlaceholder: 'Search'
    // });
})
