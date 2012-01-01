
function showpresent(sn,money,uname,endtime){
	var username = $("#username").val();
    var presentPanel = $('<div><div class="name"><table><tr><td class="z">优惠券号码：</td><td> </td></tr><tr><td class="z">面 值：</td><td> </td></tr><tr><td class="z">来 自：</td><td> </td></tr><tr><td class="z">有 效 期：</td><td> </td></tr><tr><td class="z">赠 送 给：</td><td><input class="hui" type="text" value="(您想送给谁？就填写TA的Panli用户名吧)" /><div class="no_name">&nbsp;</div></td></tr></table></div><div class="tijiao"><input type="button" value="我要赠送" onmouseover="this.className=\'by\'" onmouseout="this.className=\'\'" /><a href="javascript:;">返回上一步重新选择</a></div></div>');
    var successPanel = $('<div class="succeed"><h2>您的电子优惠券已赠送成功！</h2><span> </span><div class="jxl"><h3>接下来您是不是要：</h3><p><a href="/m.php?name=coupon">查看我的优惠券</a><i>或者</i><a href="javascript:;">继续赠送优惠券</a></p></div></div>');
    $("a", successPanel).click(function() {
        successPanel.hide();
        presentPanel.hide();
        $("#userCouponListPanel").show();
    });
    successPanel.open = function(name) {
        $("span", successPanel).html("您刚刚把了一张电子优惠券<b>（" + presentPanel.data("price") + "元）</b>赠送给" + name + "!<br />卡号为" + presentPanel.data("code") + "，建议您及时提醒对方查收！");
        if (successPanel.isAppend) {
            successPanel.show();
        } else {
            presentPanel.after(successPanel);
            successPanel.show();
            successPanel.isAppend = true;
        }
    };
    successPanel.isAppend = false;
    presentPanel.isAppend = false;
	$("#userCouponListPanel").hide();
	    presentPanel.setValue = function(code, price, source, date) {
        presentPanel.data("code", code);
        presentPanel.data("price", price);
        $("tr:eq(0) td:eq(1)", presentPanel).html(code);
        $("tr:eq(1) td:eq(1)", presentPanel).html("<span>" + price + "元</span>");
        $("tr:eq(2) td:eq(1)", presentPanel).html(source);
        $("tr:eq(3) td:eq(1)", presentPanel).html(date);
        presentPanel.init();
    };
    presentPanel.init = function() {
        $(":text", presentPanel).attr("class", "hui").val("(您想送给谁？就填写TA的用户名吧)");
        $(".no_name", presentPanel).hide();
    };
    presentPanel.open = function() {
        if (presentPanel.isAppend) {
            presentPanel.show();
        } else {
            $("#userCouponListPanel").after(presentPanel);
            presentPanel.show();
            presentPanel.isAppend = true;
        }
    };
    $(":text", presentPanel).focus(function() {
        $(".no_name", presentPanel).hide();
        if ($(this).attr("class") == "hui") {
            $(this).val("");
        }
        $(this).removeClass("hui");
    }).blur(function() {
        if ($.trim($(this).val()).length <= 0) {
            $(this).val("(您想送给谁？就填写TA的用户名吧)").attr("class", "hui");
        }
    }).keydown(function(e) {
        if (e.keyCode == 13) {
            $(":button", presentPanel).click();
        }
    });
    $(":button", presentPanel).click(function() {
        var name = $.trim($(":text", presentPanel).val());
        var btn = $(this);
        if (name.length <= 0 || $(":text", presentPanel).attr("class") == "hui") {
            $(".no_name", presentPanel).text("请输入您想赠送的用户名。").show();
            return false;
        }
        if (name == username) {
            $(".no_name", presentPanel).text("不能赠送给自己噢！").show();
            return false;
        }
        if (!confirm("您确定要将电子优惠券" + presentPanel.data("code") + "（" + presentPanel.data("price") + "元）赠送给" + name + "吗？")) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "/ajax/coupon_ajax.php?action=present",
            cache: false,
            dataType: "json",
            contentType: "application/json;utf-8",
            data: '{"name":"' + name + '","code":"' + presentPanel.data("code") + '"}',
            timeout: 15000,
            beforeSend: function() {
                btn.attr("disabled", "disabled");
            },
            error: function() {
                btn.removeAttr("disabled");
            },
            success: function(r) {
                btn.removeAttr("disabled");
                if (r == "OK") {
                    presentPanel.hide();
                    successPanel.open(name);
                }else{
					$(".no_name", presentPanel).text(r).show();
				}
            }
        });
        return false;
    });
    $("a", presentPanel).click(function() {
        presentPanel.hide();
        $("#userCouponListPanel").show();
    });
	presentPanel.setValue(sn,money,uname,endtime);
	presentPanel.open();

}