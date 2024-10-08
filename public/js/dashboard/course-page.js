setInterval(showName, 2000);

function showName() {
    document.getElementById('name').innerText = $('#userTitle').data('email');
}

setInterval(myTimer, 2000);

function myTimer() {
    if ($('#name').length > 0) {

        // $('#name').css({
        //     'display': 'block',
        //     'opacity': '.5',
        //     'left': '50%',
        //     'right': '0',
        //     'top': '50%',
        //     'bottom': '0'
        // })
    } else {
        $('iframe').parent().append('<p id="name"></p>')
    }
}

//Start disable print screen

document.addEventListener("keyup", function (e) {
    var keyCode = e.keyCode ? e.keyCode : e.which;
    if (keyCode == 44) {
        stopPrntScr();
    }
});

function stopPrntScr() {

    var inpFld = document.createElement("input");
    inpFld.setAttribute("value", ".");
    inpFld.setAttribute("width", "0");
    inpFld.style.height = "0px";
    inpFld.style.width = "0px";
    inpFld.style.border = "0px";
    document.body.appendChild(inpFld);
    inpFld.select();
    document.execCommand("copy");
    inpFld.remove(inpFld);
}

function AccessClipboardData() {
    try {
        window.clipboardData.setData('text', "Access   Restricted");
    } catch (err) {
    }
}

setInterval("AccessClipboardData()", 300);
