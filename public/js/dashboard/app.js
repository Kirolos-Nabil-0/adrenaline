let messageInnerText = document.querySelectorAll(".message");
messageInnerText.forEach(mess=>{
    mess.innerHTML = mess.innerHTML.substr(0,50) + "..."
})

see_code = (e) =>{
    e.nextElementSibling.classList.toggle("see")
}

let slideBar = document.querySelector(".side-bar");
let menuIcon = document.querySelector(".menu-navbar");
let spans = document.querySelectorAll(".menu-navbar span");
let shadow = document.querySelector(".shadow")
let dashboard_content = document.querySelector(".dashboard-content-right-side")
let media = window.matchMedia("(max-width:767px)");
if(media.matches){
    menuIcon.addEventListener("click",() =>{
        slideBar.classList.toggle("open");
        spans[0].classList.toggle("x")
        spans[1].classList.toggle("disapper")
        spans[2].classList.toggle("x");
        shadow.classList.add("open")
    });
    shadow.addEventListener("click",(e) => {
        shadow.classList.toggle("open");
        slideBar.classList.toggle("open");

    })
}else{
    menuIcon.addEventListener("click",() =>{
        slideBar.classList.toggle("slide_close");
        dashboard_content.classList.toggle("to_left");
        spans[0].classList.toggle("x")
        spans[1].classList.toggle("disapper")
        spans[2].classList.toggle("x")
    })
}

let sidebar_itmes = document.querySelectorAll(".direct");

sidebar_itmes.forEach(item =>{
  item.addEventListener("click",() =>{
    $(item).toggleClass("open").siblings().removeClass("open")

    item.children[1].classList.toggle("chevron_open")
  })
})

$(".addcourse").click(function(){
  Swal.fire({
    icon: 'success',
    title: 'تمت إضافة الكورس بنجاح شكرا لك',
    showConfirmButton: false,
    timer: 1500
  })
})

$(".delete_student").click(function(e){
    e.preventDefault();
    var url=$(this).attr('href');
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
      Swal.fire(
        'Deleted!',
        'Your file has been deleted.',
        'success'
      )
        window.location.href=url;
    }
  })
})



$(document).ready(function(){

  // Initialize select2
  $("#SelExample").select2();
  // Read selected option
  $('#but_read').click(function(){
    var username = $('#SelExample option:selected').text();
    var userid = $('#SelExample').val();
    // $('#result')[0].innerHTML += "id : " + userid + ", name : " + username + "<br>  "
    $('#result')[0].innerHTML += `
      <div class="bg-dark user-added text-light p-3 d-inline-block rounded-pill main-shadow">
        <input type="hidden" value="${userid}"/>
        ${username}
        <i class="fa fa-times text-danger" onclick="deleteuser(this)"></i>
      <div>
    `
  });
});

function deleteuser(e){
  e.parentElement.remove()
}
function removesection(e){
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
      e.parentElement.parentElement.parentElement.remove()
    }
  })
}
function removelecture(e){
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
      e.parentElement.parentElement.remove()
    }
  })
}
