/*register*/
$(".back").mouseover(function() {
    $(".back").css("color", "black");
});

$(".back").mouseleave(function() {
    $(".back").css("color", "white");
});

$("#submit_button").click(function() {
    $(".register-form").submit();
});

$(".input-name").blur(function() {
    var reg = new RegExp("^[a-zA-Z][a-zA-Z0-9_]{4,15}$");
    var value = $(".input-name")[0].value;
    if (!reg.test(value)) {
        $(".message-name")[0].style.display = "inline";
    }
});

$(".password-input").blur(function() {
    var reg = new RegExp("^[a-zA-Z0-9]{7,17}$");
    var value = $(".password-input")[0].value;
    if (!reg.test(value)) {
        $(".message-password")[0].style.display = "inline";
    }
});

$(".confirm-input").blur(function() {
    var pwd = $(".password-input")[0].value;
    var conPwd = $(".confirm-input")[0].value;
    if (pwd != conPwd) {
        $(".confirm-message")[0].style.display = "inline";
    }
})

$(".email-input").blur(function() {
    var reg = new RegExp("^[a-zA-Z0-9_-]+@([a-zA-Z0-9-]+)*[a-zA-Z/.]+$");
    var value = $(".email-input")[0].value;
    if (!reg.test(value)) {
        $(".email-message")[0].style.display = "inline";
    }
});

$(".input-name").mousedown(function() {
    $(".message-name")[0].style.display = "none";
});

$(".password-input").mousedown(function() {
    $(".message-password")[0].style.display = "none";
});

$(".confirm-input").mousedown(function() {
    $(".confirm-message")[0].style.display = "none";
});

$(".email-input").mousedown(function() {
    $(".email-message")[0].style.display = "none";
});
$("#reset_button").click(function() {
    $(".message-name").css("display", "none");
    $(".message-password").css("display", "none");
    $(".confirm-message").css("display", "none");
    $(".email-message").css("display", "none");
    $(".input-name").val("");
    $(".password-input").val("");
    $(".confirm-input").val("");
    $(".email-input").val("");
})