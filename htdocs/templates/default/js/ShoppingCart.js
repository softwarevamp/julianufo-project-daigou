var uGroup=0;
var sp_prol='';
var thisPage = {
    userGroup: uGroup,
    products: sp_prol,
    index: [],
    remarkPanel: '<div style="display:none;" class="beizhu"><div class="bzbox"><div class="if"><label><input type="checkbox" id="noRemarkck"/>无特殊商品备注说明，请勾选此项</label></div><textarea maxLength="500" id="newRemark" onfocus="thisPage.isRemarkFocus=true;" onblur="thisPage.isRemarkFocus=false" cols="" rows=""></textarea><dl><dt><input type="button" id="updmk" value="提交" /></dt><dd><input type="button" value="关闭" onclick="thisPage.isRemarkFocus=false;thisPage.closeRemarkPanel()" /></dd></dl></div><img src="/images/jiantou.gif"/></div>',
    toID: [],
    outID: [],
    isRemarkFocus: false,
    init: function(da) {
        this.index = [];
        if (da.length > 0) {
            for (var i = 0; i < da.length; i++) {
                var u = da[i].Shop.Href;
                if (this.index.length > 0) {
                    for (var j = 0; j < this.index.length; j++) {
                        if (da[this.index[j][0]].Shop.Href == u) { this.index[j][this.index[j].length] = i; break; }
                        if (j + 1 == this.index.length) { this.index[j + 1] = new Array(); this.index[j + 1][0] = i; break; }
                    }
                }
                else { this.index[0] = new Array(); this.index[0][0] = i; };
            }

        }
    },
    ANum: function(i) { this.updateNum(i, this.products[i].BuyNum + 1); },
    MNum: function(i) { if (this.products[i].BuyNum > 0) this.updateNum(i, this.products[i].BuyNum - 1); },
    cleartoID: function(li) { if (li.length > 0) { $.each(li, function(i, d) { clearInterval(d); }); li = []; } },
	
    closeRemarkPanel: function() { if (this.isRemarkFocus) return; this.cleartoID(thisPage.toID); if ($(".beizhu").length > 0) { $(".beizhu").animate({ width: "0", marginLeft: "0" }, 300, function() { $(this).remove(); }); } },
    accountAll: function() {
	    if ($("input:checked").length <= 0) {
			$("#totalFreight").text("￥" + 0); 
			$("#totalProPrice").text("￥" + 0); 
			$("#totalPrice").text("￥" + 0); 
			return;
        }
		var s = [];
		$.each($("input:checked"), function(i, d) { s.push(d.value); });
		
        $.ajax({
            type: "POST",
            url: "/ajax/cart_ajax.php?action=accountAll",
            dataType: "json",
			data: "gids=" + s.toString(),
            timeout: 25000,
            error: function() { alert("统计价格失败");},
            success: function(data) {
				$("#totalFreight").text("￥" + data.sendmoney.toFixed(2)); 
				$("#totalProPrice").text("￥" + data.goodsmoney.toFixed(2)); 
				$("#totalPrice").text("￥" + data.totalmoney.toFixed(2)); 
			}
        });
	},	
    showRemarkPanel: function(i, type, dom,remarktxt) {
				if (this.isRemarkFocus) return; this.closeRemarkPanel();
					if (type) { if ($(".beizhu").length > 0) { 
					setTimeout(function() {	thisPage.showRemarkPanel(i, type, dom,remarktxt); }, 500); 
					return; 
					} 
					this.toID.push(setTimeout(function() { thisPage.showRemarkPanel(i, !type, dom,remarktxt); }, 500)); 
					} else { 
					$(".beizhu").remove(); 
					$(dom).before(this.remarkPanel); 

					$("#newRemark").val(remarktxt); 
					
					$("#noRemarkck").click(function() {
						if (this.checked) $("#newRemark").val("我对此商品无任何特殊备注。").attr("disabled", "disabled"); 
						else $("#newRemark").val(remarktxt).removeAttr("disabled"); }); 
						$("#updmk").click(function() {
						thisPage.updateRemark($("#newRemark").val(), i,remarktxt);
						}); 
						$(".beizhu").animate({ width: "282px", marginLeft: "-294px" }, 300, function() { $(this).css("display", "inline"); }).mouseenter(function() { thisPage.cleartoID(thisPage.outID); }).mouseleave(function() { thisPage.closeRemarkPanel(); }); } },
	
	
    updateRemark: function(remark, i,remarktxt) {
        if (remark == remarktxt)
        { thisPage.isRemarkFocus = false; thisPage.closeRemarkPanel(); return; }
        $.ajax({ type: "POST",
            url: "/ajax/cart_ajax.php?action=editremark",
            data: "gid=" + i + "&remark=" + remark,
            timeout: 6000,
            error: function() {
                alert('修改备注失败！');
            },
            success: function() {
                remarktxt = remark;
				
                //if ($.trim(remark).length > 0 && remark != "我对此商品无任何特殊备注。")
                  //  $("#li" + i + " .b8 a").attr("class", "").text("商品备注");
               // else
                //    $("#li" + i + " .b8 a").attr("class", "orange").text("添加备注");
                alert("修改备注成功");
				window.location.reload();
            }
        });
    },
    updateNum: function(i, num) {
        if (num.toString().length <= 0) { num = "1"; }
        num = parseInt(num);
        if ($("#li" + i + " .b5 input")[0].disabled) { return; };
        if (num == 0) { $("#li" + i + " .b5 input").val("1"); return }
        $("#li" + i + " .b5 input").attr("disabled", true);
        $.ajax({ type: "POST",
            url: "/ajax/cart_ajax.php?action=updatenum",
			data: "gid=" + i + "&num=" + num,
            timeout: 5000,
            error: function() { alert('修改数量失败！'); window.location = window.location; },
            success: function(totle) {
                $("#li" + i + " .b5 input").attr("disabled", false).val(num);
				price=$("#li" + i + " .b4").html();
				price=price.substr(1);
                $("#li" + i + " .b6 span").html('￥'+price*num);
                thisPage.accountAll();
            }
        });
    },
    addToFavorites: function(dom) {
        if ($("input:checked").length <= 0) {
            alert("请勾选您要收藏的商品"); return;
        }
        $(dom).attr("disabled", "disabled");
        var s = [];
        $.each($("input:checked"), function(i, d) { s.push(d.value); });
        $.ajax({
            type: "POST",
            url: "/ajax/cart_ajax.php?action=addtofavorites",
            dataType: "json",
			data: "gids=" + s.toString(),
            timeout: 25000,
            error: function() { alert("添加收藏失败"); $(dom).removeAttr("disabled"); },
            success: function(data) { alert(data); $(dom).removeAttr("disabled"); }
        });
    },
    del: function(dom) {
        if ($("input:checked").length <= 0) {
            alert("请勾选您要删除的商品"); return;
        }
        if (!confirm("您确定要删除这些商品吗")) return;
        $(dom).attr("disabled", "disabled");
        var s = [];
        $.each($("input:checked"), function(i, d) { s.push(d.value); });

        $.ajax({
            type: "POST",
            url: "/ajax/cart_ajax.php?action=del",
            dataType: "json",
			data: "gids=" + s.toString(),
            timeout: 10000,
            error: function() { alert("删除失败"); window.location = window.location; },
            success: function(data) {alert(data); $(dom).removeAttr("disabled");window.location.reload();}
        });
    },
    submitCheck: function() { if ($("input:checked").length <= 0) { alert("请勾选您要代购的商品"); return false; } },
    getSiteName: function(url) {
        if (url.indexOf("taobao.com") > 0)
            return "淘宝网";
        if (url.indexOf("paipai.com") > 0)
            return "拍拍网";
        if (url.indexOf("eachnet.com") > 0)
            return "易趣网";
        if (url.indexOf("youa.baidu.com") > 0)
            return "百度有啊";
        if (url.indexOf("panli.com") > 0)
            return "Panli";
        if (url.indexOf("139shop.com") > 0)
            return "北斗手机";
        if (url.indexOf("360buy.com") > 0)
            return "京东商城";
        if (url.indexOf("4inlook.com") > 0)
            return "4inLOOK";
        if (url.indexOf("7shop24.com") > 0)
            return "7shop24";
        if (url.indexOf("818shyf.com") > 0)
            return "上海药房";
        if (url.indexOf("amazon.cn") > 0)
            return "卓越网";
        if (url.indexOf("blemall.com") > 0)
            return "联华OK";
        if (url.indexOf("china-pub.com") > 0)
            return "China-Pub";
        if (url.indexOf("cntvs.com") > 0)
            return "七星网";
        if (url.indexOf("dangdang.com") > 0)
            return "当当网";
        if (url.indexOf("e-giordano.com") > 0)
            return "佐丹奴";
        if (url.indexOf("gome.com.cn") > 0)
            return "国美电器";
        if (url.indexOf("m18.com") > 0)
            return "麦网";
        if (url.indexOf("newegg.com.cn") > 0)
            return "新蛋中国";
        if (url.indexOf("no5.com.cn") > 0)
            return "No5时尚广场";
        if (url.indexOf("redbaby.com.cn") > 0)
            return "红孩子";
        if (url.indexOf("shishangqiyi.com") > 0)
            return "时尚起义";
        if (url.indexOf("vancl.com") > 0)
            return "凡客诚品";
        if (url.indexOf("wangshanghai.com") > 0)
            return "网上海";
        if (url.indexOf("x.com") > 0)
            return "北京桔色";
        return "其他网站";
    }
}