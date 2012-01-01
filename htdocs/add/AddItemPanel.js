function p1UnLock() {
    $(".addpanel_address_").attr("class", "addpanel_address");
    $("#addpanel_submit").removeAttr("disabled");
    $("#itemUrl").removeAttr("disabled");
}

function p1Lock() {
    $("#itemUrl").attr("disabled", "disabled");
    $(".addpanel_address").attr("class", "addpanel_address_");
}

function noPrice(price) {
    if (price != -1)
        $("#productPrice").val(price).attr("disabled", "disabled").attr("class", "addpanel_hui");
    else {
        $("#productPrice").attr("class", "addpanel_red").focus(function() { if ($(this).attr("class") == "addpanel_red") $(this).val(""); $(this).attr("class", ""); }).blur(function() { if ($.trim($(this).val()) <= 0) $(this).attr("class", "addpanel_red").val("请填写商品价格"); disSubBtn(); }).keydown(function() { disSubBtn(); }).val("请填写商品价格");
        $("#proAlert").attr("class", "addpanel_alert").text("系统未能抓取商品相关信息，您可以在输入框中填写相关信息");
    }
}

function disSubBtn() {
    if ($("#productName").attr("class") != "addpanel_red addpanel_k" && $("#productPrice").attr("class") != "addpanel_red") {
        $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
    }
    else {
        $("#successBtn").attr("disabled", "disabled").attr("class", "addpanel_next_no");
    }
}


// 产品抓取成功后数据绑定方法
function buildP2(data) {
    var item = data.d;
    if (data._statusCode == 500) {
        buildP2_fail();
    } else {

        if (item.Name != "")
            $("#productName").val(item.Name).attr("class", " addpanel_k").attr("disabled", "disabled");
        else {
            $("#productName").attr("class", "addpanel_red addpanel_k").focus(function() { if ($(this).attr("class") == "addpanel_red addpanel_k") $(this).val(""); $(this).attr("class", "addpanel_k"); }).blur(function() { if ($.trim($(this).val()) <= 0) $(this).attr("class", "addpanel_red addpanel_k").val("请填写商品名称"); disSubBtn(); }).keydown(function() { disSubBtn(); }).val("请填写商品名称");
            $("#proAlert").attr("class", "addpanel_alert").text("系统未能抓取商品相关信息，您可以在输入框中填写相关信息");
        }

        if (!item.IsAuction) {
            switch (item.UserGroup) {
                case 0:

                    if (item.Price != -1) {

                        $("#productPrice").val(item.Price).attr("disabled", "disabled").attr("class", "addpanel_hui");
                        if ($("#productName").attr("class") != "addpanel_red") $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
                    }
                    else
                        noPrice(-1);
                    break;
                case 1:
                    if (item.VIPPrice1 != -1) {
                        $("#productPrice").val(item.VIPPrice1).attr("class", "addpanel_hui").next("span").after('<span id="vipPriceS" style="color:#fff;background:#66CC00;padding:1px 2px;background:">金卡会员价</span>');
                        if ($("#productName").attr("class") != "addpanel_red") $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
                    }
                    else
                        noPrice(item.Price);
                    break;
                case 2:
                    if (item.VIPPrice2 != -1) {
                        $("#productPrice").val(item.VIPPrice2).attr("class", "addpanel_hui").next("span").after('<span id="vipPriceS" style="color:#fff;background:#66CC00;padding:1px 2px;background:">白金卡会员价</span>');
                        if ($("#productName").attr("class") != "addpanel_red") $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
                    }
                    else
                        noPrice(item.Price);
                    break;
                case 3:
                    if (item.VIPPrice3 != -1) {
                        $("#productPrice").val(item.VIPPrice3).attr("class", "addpanel_hui").next("span").after('<span id="vipPriceS" style="color:#fff;background:#66CC00;padding:1px 2px;background:">钻石会员价</span>');
                        if ($("#productName").attr("class") != "addpanel_red") $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
                    }
                    else
                        noPrice(item.Price);
                    break;
                default:
                    if (item.Price != -1) {
                        $("#productPrice").val(item.Price).attr("disabled", "disabled").attr("class", "addpanel_hui");
                        if ($("#productName").attr("class") != "addpanel_red") $("#successBtn").removeAttr("disabled").attr("class", "addpanel_next");
                    }
                    else
                        noPrice(-1);
                    break;
            }
        }else if(1){
			noPrice(-1);
		}else {
            $("#isAuction").show();
            if (item.Price != -1)
                $("#productPrice").val(item.Price).attr("disabled", "disabled").attr("class", "").blur(function() { if ($.trim($(this).val()) < item.Price) $(this).val(item.Price.toString()); });
            else
                $("#productPrice").attr("class", "addpanel_red").focus(function() { if ($(this).attr("class") == "addpanel_red") $(this).val(""); $(this).attr("class", ""); }).blur(function() { if ($.trim($(this).val()) <= 0) $(this).attr("class", "addpanel_red").val("请填写商品价格") }).val("请填写商品价格");
        }

        if (item.Freight != -1)
            $("#productSendPrice").val(item.Freight).attr("class", "");
        else
            $("#productSendPrice").val("10").attr("class", "addpanel_red addpanel_wen").focus(function() { $("#question").css("display", "inline"); });

        if (item.Href != "")
            $("#productUrl").val(item.Href);
        else
            $("#productUrl").val($("#itemUrl").val());

        if (item.Picture != "")
            $("#productImg").css("display", "inline").children("img").attr("src", item.Picture);

        if (item.Thumbnail != "")
            $("#productThumbnail").css("display", "none").children("img").attr("src", item.Thumbnail);



        disSubBtn();

        // 将商品信息存放到全局变量addItem_productInfo
        addItem_productInfo.Name = $("#productName").val();
        addItem_productInfo.Href = $("#productUrl").val();
        addItem_productInfo.Picture = item.Picture;
        addItem_productInfo.Thumbnail = item.Thumbnail;
		addItem_productInfo.chicun = $("#chicun").val();
		addItem_productInfo.yanse = $("#yanse").val();
        addItem_productInfo.ShopName = item.Shop.Name;
        addItem_productInfo.ShopHref = item.Shop.Href;
        addItem_productInfo.Price = item.Price;
        addItem_productInfo.VIPPrice1 = item.VIPPrice1;
        addItem_productInfo.VIPPrice2 = item.VIPPrice2;
        addItem_productInfo.VIPPrice3 = item.VIPPrice3;
        addItem_productInfo.Freight = $("#productSendPrice").val();
        addItem_productInfo.IsAuction = item.IsAuction;
		//翻译
		//$('#p2 .addpanel_data').translate('zh-CN','ja',{fromOriginal:false,alwaysReplace:true});
		//$('#productName').translate('zh-CN','ja',{fromOriginal:false,alwaysReplace:true});

    }
}

function buildP2_fail() {
    $("#proAlert").attr("class", "addpanel_alert").text("系统未能抓取商品相关信息，您可以在输入框中填写相关信息");
    $("#productUrl").val(/^http(s)?:\/\//g.test($("#itemUrl").val()) ? $("#itemUrl").val() : "http://" + $("#itemUrl").val());
    $("#productSendPrice").val("10").attr("class", "addpanel_red addpanel_wen").focus(function() { $("#question").css("display", "inline"); });
    $("#productName").attr("class", "addpanel_red addpanel_k").focus(function() { if ($(this).attr("class") == "addpanel_red addpanel_k") $(this).val(""); $(this).attr("class", "addpanel_k"); }).blur(function() { if ($.trim($(this).val()) <= 0) $(this).attr("class", "addpanel_red addpanel_k").val("请填写商品名称"); disSubBtn(); }).keydown(function() { disSubBtn(); }).val("请填写商品名称");
    $("#productPrice").attr("class", "addpanel_red").focus(function() { if ($(this).attr("class") == "addpanel_red") $(this).val(""); $(this).attr("class", ""); }).blur(function() { if ($.trim($(this).val()) <= 0) $(this).attr("class", "addpanel_red").val("请填写商品价格"); disSubBtn(); }).keydown(function() { disSubBtn(); }).val("请填写商品价格");
    disSubBtn();
	

    addItem_productInfo.Name = "";
    addItem_productInfo.Href = $("#productUrl").val();
    addItem_productInfo.Picture = "";
    addItem_productInfo.Thumbnail = "";
    addItem_productInfo.chicun = "";
    addItem_productInfo.yanse = "";
    addItem_productInfo.ShopName = "";
    addItem_productInfo.ShopHref = "";
    addItem_productInfo.Price = 0;
    addItem_productInfo.VIPPrice1 = -1;
    addItem_productInfo.VIPPrice2 = -1;
    addItem_productInfo.VIPPrice3 = -1;
    addItem_productInfo.Freight = $("#productSendPrice").val();
    addItem_productInfo.IsAuction = false;
}

var addItem_productInfo = {
    "Name": "",
    "Href": "",
    "Picture": "",
    "Thumbnail": "",
    "chicun": "",
    "yanse": "",
    "ShopName": "",
    "ShopHref": "",
    "Price": -1,
    "VIPPrice1": -1,
    "VIPPrice2": -1,
    "VIPPrice3": -1,
    "BuyNum": -1, //此属性暂时无用
    "Freight": -1,
    "IsAuction": false
};

//$(document).ready(function() {

var ShowError = function(XMLHttpRequest, textStatus, errorThrown) {
    p1UnLock();
    $("#p1").hide();
    if ($("#p2 div") <= 0) {
        $("#p2").load("/add/AddItemPanel/AddItemPanel2.htm", function() { buildP2_fail(); $("#p2").show(); $("#productRemark").focus(); });
    } else {
        buildP2_fail();
        $("#p2").show();
        $("#productRemark").focus();
    }
    //alert(textStatus);
}
var ShowItemSnapshot = function(data) {
    p1UnLock();
	var error = data.d.Error;
    if (error == "BlockedShop") {
        $("#promptInfo").attr("class", "addpanel_wrong").find("img").remove();
        $("#promptInfo p").html("该商品的卖家为嫌疑商家，请不要代购此商品！<a href=\"/Help/Detail.aspx?hid=98\" target=\"_blank\">什么是嫌疑商家？</a>");
        return;
    }
    $("#p1").hide();
    if ($("#p2 div").length <= 0) {
        $("#p2").load("/add/AddItemPanel/AddItemPanel2.htm", function() { buildP2(data); $("#productRemark").focus(); });
    } else {
        buildP2(data);
        $("#p2").show();
        $("#productRemark").focus();
    }
}

//输入商品网址后提交方法
$("#addpanel_submit").click(function() {
    var url = $("#itemUrl").val();
    var reg = new RegExp("http(s)?://([\\w-]+\\.)+[\\w-]+(/[\\w- ./?%&=]*)?");
    if (url.length <= 0) {
        $("#promptInfo").attr("class", "addpanel_wrong");
        $("#promptInfo p").text("请输入您想代购商品的详细页网址！");
    }
    else {
        if (url.indexOf("http://") == -1 && url.indexOf("https://") == -1)
            url = "http://" + url;
        if (reg.test(url)) {
            p1Lock();
            $(this).attr("disabled", "disabled");
            $("#promptInfo").attr("class", "addpanel_loading").prepend("<img src=\"/add/newimages/loading.gif\" alt=\"请稍候\" />");
            $("#promptInfo p").text("正在抓取商品信息...");

            $.ajax({
                type: "POST",
                url: "/ajax/fast_ajax.php?action=get",
                dataType: "json",
               // contentType: "application/json;utf-8",
                data: "url=" + encodeURIComponent(url),
                timeout: 25000,
                error: ShowError,
                success: ShowItemSnapshot
            });
        }
        else {
            $("#promptInfo").attr("class", "addpanel_wrong");
            $("#promptInfo p").text("输入的网址不正确，请核实后再填写！");
        }
    }
});

$("#itemUrl").keydown(function(e) { if (e.keyCode == 13) { $("#addpanel_submit").click(); return false; } });
//});