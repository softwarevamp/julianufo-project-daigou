
function ActivateCoupon(a, b) {
    var c = '"' + a + '"';
    $.ajax({
        type: "POST",
        url: "/ajax/coupon_ajax.php?action=active",
        cache: false,
        dataType: "json",
        contentType: "application/json;utf-8",
        data: '{"code":' + c + "}",
        timeout: 15000,
        error: function(e) {
            $("#showContent").html("您输入的号码为无效号码，请输入正确的优惠券号码。");
        },
        success: function(d) {
            if (b) {
                ClickToActivate(d, a);
            } else {
                ShowActivate(d, a);
            }
        }
    });
}
function ShowActivate(b, a) {
    if (b == "Success") {
        ShowSuccess(a);
    } else {
        alert("兑换失败！");
    }
}
function ClickToActivate(b, a) {
    switch (b) {
    case "OK":
        ShowSuccess(a);
		break;
    default:
        $("#showContent").html(b);
        break;
    }
}
function Click() {
    $("#showContent").show();
    var b = $.trim($("#clickcode").val());
    var a = new RegExp("^([A-Za-z0-9]{0,50})$");
    if (b == "") {
        $("#showContent").html("请输入电子优惠券的号码。");
    } else {
        if (a.test(b)) {
            ActivateCoupon(b, true);
        } else {
            $("#showContent").html("您输入的号码为无效号码，请输入正确的优惠券号码。");
        }
    }
}
function ShowSuccess(b) {
    $("#showContent").html("");
    $("#loading").hide();
    $(".shuru").hide();
    $("#userCouponListPanel").hide();
    $("#userCouponList").hide();
    $("#ajaxPager").hide();
    $("#noneList").hide();
    var c = new Array();
    c = $("#BeijingDate").html().replace("北京时间：", "").split("-");
    var a = new Date();
    a.setFullYear(c[0], c[1], c[2]);
    a.setDate(a.getDate() + 30);
    $(".succeed").append("<h2> 恭喜！您的电子优惠券已成功激活！</h2><span>本次激活的电子优惠券号码为" + b + "，有效期至" + a.getFullYear() + "-" + a.getMonth() + "-" + a.getDate() + '！</span><div class="jxl"><h3>接下来您是不是要：</h3><p><a href="/m.php?name=coupon">查看我的优惠券</a><i>或者</i><a href="/m.php?name=coupon&action=active">继续激活优惠券</a></p></div>').show();
}

$(document).ready(function() {
    $("#clickcode").keydown(function(a) {
        if (a.keyCode == 13) {
            Click();
            return false;
        }
    });
    $("#clickcode").keyup(function() {
        if ($.trim($("#clickcode").val()) == "") {
            $("#showContent").hide();
        }
    });
    $("#clickcode").focus(function() {
        if ($.trim($("#clickcode").val()) == "") {
            $("#showContent").hide();
        }
    });
    $("#clickcode").blur(function() {
        if ($.trim($("#clickcode").val()) == "") {
            $("#showContent").hide();
        }
    });
});