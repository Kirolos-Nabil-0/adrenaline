$('.form-buttons-select p').each(function () {
    this.onclick = function () {
        $(this).addClass("active").siblings().removeClass("active")
        $("." + $(this).data("div")).fadeIn().siblings().fadeOut()
    }
})

$('.User-avtar').click(function () {
    if ($(".User-Dropdown").hasClass("U-open")) {
        $('.User-Dropdown').removeClass("U-open");
    } else {
        $('.User-Dropdown').addClass("U-open");
    }
});
$('.close-slide').click(function () {
    $('.slide-videos-list').removeClass("open");
});
$('.open-slide').click(function () {
    $('.slide-videos-list').addClass("open");
});

var loadFile = function (event) {
    var image = document.getElementById("output");
    image.src = URL.createObjectURL(event.target.files[0]);
};
  var frameObj = document.querySelector(".video-player");
  console.log(frameObj)
$('.slide-videos-list ul li li').each(function () {
    this.onclick = function () {
        $('.slide-videos-list ul li li').each(function () {
            $(this).removeClass("active")
        })

        $(".video-player")[0].src = $(this).data("url")
        $('#title').text(`${$(this).data("section")} : ${$(this).data("name")}`)
        $(this).addClass("active").siblings().removeClass("active")
    }
})
onload = () =>{
        setTimeout(()=>{
            let x = $(".video-player").html()
            console.log(x)
        },5000)
}
// var x = window.matchMedia("(min-width: 992px)")
// if (x.matches) { // If media query matches
//     $("body").addClass("small-size")
//     $("body")[0].innerHTML = `<div class="text-center"><img src="../images/oops.png" width="100%"/> <br><br>هذا الموقع غير متوفر لأجهزة الكمبيوتر</div>`
// }

// (function () {
//         (function a() {
//                 try {
//                     (function b(i) {
//                             if (('' + (i / i)).length !== 1 || i % 20 === 0) {
//                                 (function () {
//
//                                 }).constructor('debugger')()
//
//
//                             } else {
//                                 debugger
//                             }
//                             b(++i)
//                         }
//                     )(0)
//                 } catch (e) {
//                     setTimeout(a, 5000)
//                 }
//             }
//         )()
//     }
// )();

// window.onresize = function () {
//     if ((window.outerHeight - window.innerHeight) > 100 || (window.outerWidth - window.innerWidth) > 100) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//     }
// }


// document.onkeydown = function (e) {
//     if (event.keyCode == 123) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//         return false;
//     }
//      if (event.keyCode == 17) {return false;}
//       if (event.keyCode == 107) {return false;}
//        if (event.keyCode == 109) {return false;}
//     if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//         // return false;
//     }
//     if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//         return false;
//     }
//     if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//         return false;
//     }
//     if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
//         setInterval(() => {

//             var $all = document.querySelectorAll("*");

//             for (var each of $all) {
//                 each.classList.add(`asdjaljsdliasud8ausdijaisdluasdjasildahjdsk${Math.random()}`);
//             }


//         }, 5);
//         return false;
//     }
// }


// setTimeout(()=>{
//     console.log(config)
// },10000)


