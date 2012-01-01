

function showsell(sn,money,uname,endtime,state,cid){
    var sellPanel = $('<div><div class="name"><table><tr><td class="z">优惠券号码：</td><td> </td></tr><tr><td class="z">面 值：</td><td> </td></tr><tr><td class="z">来 自：</td><td> </td></tr><tr><td class="z">有 效 期：</td><td> </td></tr><tr><td class="z">售价：</td><td><input class="hui" type="text" maxlength="6" /><p>电子优惠券面值×0.5＜售价＜电子优惠券面值×0.8</p></td></tr></table></div><div class="tijiao"><input type="button" value="我要发布" onmouseover="this.className=\'by\'" onmouseout="this.className=\'\'" /><a href="javascript:;">返回上一步重新选择</a></div></div>');
    var successPanel = $('<div class="succeed se_"><h2>您的出售信息已成功发布到电子优惠券商城！</h2><span>温馨提示：您发布的电子优惠券如果出售成功，所售金额将自动转入您的RMB账户中。</span><div class="jxl"><h3>接下来您是不是要：</h3><p><a href="coupon.php" target="_blank">去电子优惠券商城瞧瞧</a><i>或者</i><a href="/m.php?name=coupon">查看我的优惠券</a></p></div></div>');
    successPanel.open = function() {
        if (successPanel.isAppend) {
            successPanel.show();
        } else {
            sellPanel.after(successPanel);
            successPanel.show();
            successPanel.isAppend = true;
        }
    };
    successPanel.isAppend = false;
    sellPanel.isAppend = false;
    sellPanel.setValue = function(sn,money,uname,endtime,state,cid) {
        sellPanel.data("code", sn);
        sellPanel.data("index", cid);
        sellPanel.data("price", money);
        $("tr:eq(0) td:eq(1)", sellPanel).html(sn);
        $("tr:eq(1) td:eq(1)", sellPanel).html("<span>" + money + "元</span>");
        $("tr:eq(2) td:eq(1)", sellPanel).html(uname);
        $("tr:eq(3) td:eq(1)", sellPanel).html(endtime);
    };
    sellPanel.open = function() {
        if (sellPanel.isAppend) {
            sellPanel.show();
        } else {
            $("#userCouponListPanel").after(sellPanel);
            sellPanel.show();
            sellPanel.isAppend = true;
        }
    };
    $(":text", sellPanel).focus(function() {
        $(".no_name", sellPanel).hide();
        if ($(this).attr("class") == "hui") {
            $(this).val("");
        }
        $(this).removeClass("hui");
    }).keyup(function() {
        this.value = this.value.replace(/[^\d\.]/g, "").replace(/^0+/, "");
    }).keydown(function(e) {
        if (e.keyCode == 13) {
            $(":button", sellPanel).click();
        }
    });
    $(":button", sellPanel).click(function() {
        var price = $.trim($(":text", sellPanel).val());
        var wrongPanel = $("p", sellPanel);
        if (price.length <= 0) {
            wrongPanel.attr("class", "wrong").text("请输入电子优惠券的售价");
            return false;
        }
        price = parseFloat(price);
        if (!price) {
            wrongPanel.attr("class", "wrong").text("您输入的价格有误，请从新输入");
            return false;
        }
        var couponPrice = sellPanel.data("price");
        if (couponPrice * 0.5 > price) {
            wrongPanel.attr("class", "wrong").text("售价须高于电子优惠券面值×0.5");
            return false;
        }
        if (couponPrice * 0.8 < price) {
            wrongPanel.attr("class", "wrong").text("售价须低于电子优惠券面值×0.8");
            return false;
        }
        price = parseFloat(price.toFixed(2));
        var btn = $(this);
        $.ajax({
            type: "POST",
            url: "/ajax/coupon_ajax.php?action=sell",
            cache: false,
            dataType: "json",
            contentType: "application/json;utf-8",
            data: '{"code":"' + sellPanel.data("code") + '","price":' + price + "}",
            timeout: 10000,
            beforeSend: function() {
                btn.attr("disabled", "disabled");
            },
            error: function() {
                btn.removeAttr("disabled");
            },
            success: function(r) {
                btn.removeAttr("disabled");
                if (r == "OK") {
                    $("#c" + sellPanel.data("index")).removeClass("sell").text("出售中，取消出售");
                    sellPanel.hide();
                    successPanel.open();
                    return;
                }else{
					sellPanel.attr("class", "wrong").text(r);
					return;
				}
                sellPanel.attr("class", "wrong").text("出售失败。");
                return;
            }
        });
        return false;
    });
    $("a", sellPanel).click(function() {
        sellPanel.hide();
        $("#userCouponListPanel").show();
    });


	
	if (state==2) {
		if (!confirm("您确定要取消出售电子优惠券" + sn + "（" + money + "元）吗？")) {
			return;
		}
		var button =  $("#c" + cid);
		$.ajax({
			type: "POST",
			url: "/ajax/coupon_ajax.php?action=cancelsell",
			cache: false,
			dataType: "json",
			contentType: "application/json;utf-8",
			data: '{"code":"' + sn + '"}',
			timeout: 10000,
			beforeSend: function() {
				button.attr("disabled", "disabled");
			},
			error: function() {
				button.removeAttr("disabled");
				alert("网络错误，请稍后再试！");
			},
			success: function(r) {
				button.removeAttr("disabled");
				if (r == "OK") {
					state = 1;
					button.addClass("sell").text("就选这张，下一步");
					return;
				}
				alert("撤销失败或者重复撤销，如多次失败请联系客服。");
			}
		});
		return false;
	} else {
		$("#userCouponListPanel").hide();
		sellPanel.setValue(sn,money,uname,endtime,state,cid);
		sellPanel.open();
	}








}